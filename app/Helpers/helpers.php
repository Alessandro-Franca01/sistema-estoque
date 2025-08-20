<?php

use Carbon\Carbon;

if (!function_exists('formatPhone')) {
    /**
     * Formata um número de telefone
     *
     * @param string|null $phone
     * @return string
     */
    function formatPhone(?string $phone): string
    {
        if (empty($phone)) {
            return 'N/A';
        }

        // Remove tudo que não é dígito
        $digits = preg_replace('/\D/', '', $phone);

        $length = strlen($digits);

        if ($length === 11) { // Com DDD e 9º dígito
            return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $digits);
        } elseif ($length === 10) { // Com DDD e sem 9º dígito
            return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $digits);
        } elseif ($length === 9) { // Sem DDD com 9º dígito
            return preg_replace('/(\d{5})(\d{4})/', '$1-$2', $digits);
        } elseif ($length === 8) { // Sem DDD e sem 9º dígito
            return preg_replace('/(\d{4})(\d{4})/', '$1-$2', $digits);
        }

        return $phone; // Retorna original se não conseguir formatar
    }
}

if (!function_exists('formatCep')) {
    /**
     * Formata um CEP
     *
     * @param string|null $cep
     * @return string
     */
    function formatCep(?string $cep): string
    {
        if (empty($cep)) {
            return '';
        }

        // Remove tudo que não é dígito
        $digits = preg_replace('/\D/', '', $cep);

        if (strlen($digits) === 8) {
            return preg_replace('/(\d{5})(\d{3})/', '$1-$2', $digits);
        }

        return $cep; // Retorna original se não conseguir formatar
    }
}

if (!function_exists('formatDate')) {
    /**
     * Formata uma data para o formato brasileiro
     *
     * @param string|null $date
     * @param bool $includeTime
     * @return string
     */
    function formatDate(?string $date, bool $includeTime = false): string
    {
        if (empty($date)) {
            return '';
        }

        try {
            $carbon = Carbon::parse($date);
            return $includeTime
                ? $carbon->format('d/m/Y H:i')
                : $carbon->format('d/m/Y');
        } catch (\Exception $e) {
            return $date;
        }
    }
}

if (!function_exists('formatDocument')) {
    /**
     * Formata CPF ou CNPJ
     *
     * @param string|null $document
     * @return string
     */
    function formatDocument(?string $document): string
    {
        if (empty($document)) {
            return '';
        }

        // Remove tudo que não é dígito
        $digits = preg_replace('/\D/', '', $document);

        $length = strlen($digits);

        if ($length === 11) { // CPF
            return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $digits);
        } elseif ($length === 14) { // CNPJ
            return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $digits);
        }

        return $document; // Retorna original se não conseguir formatar
    }
}

if (!function_exists('formatCurrency')) {
    /**
     * Formata um valor como moeda brasileira
     *
     * @param float|null $value
     * @return string
     */
    function formatCurrency(?float $value): string
    {
        if (is_null($value)) {
            return '';
        }

        return 'R$ ' . number_format($value, 2, ',', '.');
    }
}

if (!function_exists('statusBadge')) {
    /**
     * Retorna uma badge colorida baseada no status
     *
     * @param string $status
     * @return string
     */
    function statusBadge(string $status): string
    {
        $statusClasses = [
            'open' => 'bg-blue-100 text-blue-800',
            'pending' => 'bg-yellow-100 text-yellow-800',
            'solved' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            'in_progress' => 'bg-indigo-100 text-indigo-800',
        ];

        $class = $statusClasses[strtolower($status)] ?? 'bg-gray-100 text-gray-800';

        return '<span class="px-2 py-1 text-xs font-semibold rounded-full ' . $class . '">'
               . ucfirst(str_replace('_', ' ', $status)) . '</span>';
    }
}

if (!function_exists('shortenText')) {
    /**
     * Encurta um texto e adiciona "..." se necessário
     *
     * @param string $text
     * @param int $length
     * @return string
     */
    function shortenText(string $text, int $length = 100): string
    {
        if (strlen($text) <= $length) {
            return $text;
        }

        return substr($text, 0, $length) . '...';
    }
}

if (!function_exists('activeMenu')) {
    /**
     * Retorna a classe 'active' se a rota atual corresponder
     *
     * @param string|array $route
     * @return string
     */
    function activeMenu($route): string
    {
        if (is_array($route)) {
            return in_array(request()->route()->getName(), $route) ? 'active' : '';
        }

        return request()->route()->getName() === $route ? 'active' : '';
    }
}

if (!function_exists('formatBytes')) {
    /**
     * Formata bytes em unidades legíveis (KB, MB, GB, etc.)
     *
     * @param int $bytes
     * @param int $precision
     * @return string
     */
    function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}

if (!function_exists('customMask')) {
    // Função para mostrar a mascara generica:
    function customMask($val, $mask): string
    {
        $maskared = '';
        $k = 0;
        for ($i = 0; $i <= strlen($mask) - 1; ++$i) {
            if ($mask[$i] == '#') {
                if (isset($val[$k])) {
                    $maskared .= $val[$k++];
                }
            } else {
                if (isset($mask[$i])) {
                    $maskared .= $mask[$i];
                }
            }
        }
        return $maskared;
    }
}

if (!function_exists('removeAccents')) {
    function removeAccents($nome): string
    {
        $comAcentos = array('à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ü', 'ú', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'O', 'Ù', 'Ü', 'Ú');
        $semAcentos = array('a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'y', 'A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U');
        return str_replace($comAcentos, $semAcentos, $nome);
    }
}
