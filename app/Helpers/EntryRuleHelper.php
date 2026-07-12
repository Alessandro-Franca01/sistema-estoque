<?php

namespace App\Helpers;

use App\Models\Entry;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EntryRuleHelper
{
    public static function calculateStockChange(array $originalProducts, array $newProducts, string $entryType): array
    {
        $sign = self::getEntrySign($entryType);
        $changes = [];
        
        foreach ($newProducts as $product) {
            $productId = $product['product_id'];
            $newQuantity = $product['quantity'];
            $oldQuantity = collect($originalProducts)
                ->where('product_id', $productId)
                ->first()['quantity'] ?? 0;
                
            $changes[$productId] = [
                'quantity' => $newQuantity * $sign,
                'old_quantity' => $oldQuantity,
                'difference' => ($newQuantity - $oldQuantity) * $sign,
            ];
        }
        
        return $changes;
    }
    
    public static function getEntrySign($entryType): int
    {
        $signs = [
            Entry::TYPE_PURCHASED => 1,
            Entry::TYPE_FEEDING => 1,
            Entry::TYPE_REVERSAL => -1,
        ];
        
        return $signs[$entryType] ?? 1;
    }
    
    public static function validateEntryType(string $requestEntryType, string $action): void
    {
        $validTypes = [Entry::TYPE_PURCHASED, Entry::TYPE_FEEDING, Entry::TYPE_REVERSAL];
        
        if (!in_array($requestEntryType, $validTypes)) {
            throw ValidationException::withMessages([
                'entry_type' => 'O tipo de entrada deve ser uma das opções válidas.'
            ]);
        }
        
        self::validateEntryTypeByAction($requestEntryType, $action);
    }
    
    private static function validateEntryTypeByAction(string $type, string $action): void
    {
        $rules = [
            Entry::TYPE_PURCHASED => ['create', 'store', 'edit', 'update'],
            Entry::TYPE_FEEDING => ['create_feeding', 'store_feeding'],
            Entry::TYPE_REVERSAL => ['create_reversal', 'store_reversal'],
        ];
        
        if (!in_array($action, $rules[$type])) {
            throw ValidationException::withMessages([
                'entry_type' => "O tipo de entrada {$type} não é permitido para ação {$action}"
            ]);
        }
    }
}

class InventoryRuleEngine
{
    public static function processProductChanges(array $productChanges, int $sign): void
    {
        foreach ($productChanges as $productId => $data) {
            $product = Product::find($productId);
            if (!$product) {
                continue;
            }
            
            if ($product->quantity + $data['quantity'] * $sign < 0) {
                throw ValidationException::withMessages([
                    'quantity' => "Estoque insuficiente para produto {$product->name}"
                ]);
            }
            
            $newQuantity = $product->quantity + $data['quantity'] * $sign;
            if ($newQuantity > $product->max_stock_level) {
                throw ValidationException::withMessages([
                    'quantity' => "Produto {$product->name} excedeu o estoque máximo: {$product->max_stock_level}"
                ]);
            }
            
            if ($data['quantity'] * $sign >= 0) {
                $product->increment('quantity', $data['quantity'] * $sign);
            } else {
                $product->decrement('quantity', abs($data['quantity'] * $sign));
            }
        }
    }
}

class FeedingRuleEngine
{
    public static function validateFeeding(array $feedingData): void
    {
        $nonZeroProducts = Product::whereIn('id', collect($feedingData)->pluck('product_id'))
            ->where('quantity', '>', 0)
            ->exists();
            
        if ($nonZeroProducts) {
            throw ValidationException::withMessages([
                'products' => "Todos os produtos devem ter quantidade zero para alimentação"
            ]);
        }
        
        $duplicateProducts = collect($feedingData)
            ->groupBy('product_id')
            ->filter(fn($group) => $group->count() > 1)
            ->keys()
            ->toArray();
            
        if (!empty($duplicateProducts)) {
            $productNames = Product::whereIn('id', $duplicateProducts)
                ->pluck('name')
                ->toArray();
                
            throw ValidationException::withMessages([
                'products' => "Múltiplos batches por produto não permitidos no mesmo pedido de alimentação: " . implode(', ', $productNames)
            ]);
        }
        
        $productIds = collect($feedingData)->pluck('product_id');
        $supplierIds = Product::whereIn('id', $productIds)->distinct()->pluck('supplier_id');
        
        if ($supplierIds->count() > 1) {
            throw ValidationException::withMessages([
                'products' => "Todos os produtos de alimentação devem ser do mesmo fornecedor"
            ]);
        }
    }
}

class ReversalRuleEngine
{
    public static function processReversal(array $reversalData): array
    {
        $entry = Entry::findOrFail($reversalData['entry']);
        
        if ($entry->entry_type === Entry::TYPE_REVERSAL) {
            throw new \Exception('Esta entrada já foi estornada.');
        }
        
        $originalState = self::captureOriginalState($entry);
        
        $entry->update([
            'original_state' => $originalState,
            'entry_type' => Entry::TYPE_REVERSAL,
            'observation' => $entry->observation,
        ]);
        
        self::reverseStockFromOriginal($entry, $originalState);
        
        return $originalState;
    }
    
    private static function captureOriginalState(Entry $entry): array
    {
        $originalProducts = $entry->products->map(function ($product) {
            return [
                'product_id' => $product->id,
                'quantity_original' => $product->pivot->quantity,
                'unit_cost' => $product->pivot->unit_cost,
            ];
        })->toArray();
        
        return [
            'original_entry_type' => $entry->entry_type,
            'original_observation' => $entry->observation,
            'original_products' => $originalProducts,
        ];
    }
    
    private static function reverseStockFromOriginal(Entry $entry, array $originalState): void
    {
        foreach ($originalState['original_products'] as $originalProduct) {
            $product = Product::find($originalProduct['product_id']);
            if ($product) {
                $product->decrement('quantity', $originalProduct['quantity_original']);
            }
        }
    }
}

class BusinessRuleAuditor
{
    public static function logRuleViolation($subject, string $ruleName, array $violationData): void
    {
        $auditData = [
            'rule_name' => $ruleName,
            'violation_details' => $violationData,
            'timestamp' => now(),
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ];
        
        AuditHelper::logEvent('business_rule_violation', $subject, null, null, request(), $auditData);
    }
}