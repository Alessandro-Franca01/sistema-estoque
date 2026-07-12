# Documentação dos Testes - EntryController

## Visão Geral

Esta documentação descreve a implementação dos testes unitários e de feature para o **EntryController**, responsável pelo gerenciamento de entradas de estoque (compra, alimentação e estorno).

---

## Estrutura de Arquivos

```
tests/
├── Unit/
│   └── EntryController/
│       ├── EntryRuleHelperTest.php        # Testes das regras de negócio (8 testes)
│       ├── EntryControllerSetupTest.php   # Testes de estrutura do controller (1 teste)
│       └── EntryControllerTest.php        # Testes dos métodos do controller (14 testes)
├── Feature/
│   └── EntryController/
│       └── EntryWorkflowTest.php          # Testes de fluxo completo (3 testes)
└── docs/
    └── README.md                          # Este arquivo
```

---

## O Que Foi Feito

### 1. Factories Criados

Foram criados 3 factories ausentes no projeto para viabilizar os testes:

| Factory | Modelo | Localização |
|---|---|---|
| `SupplierFactory` | `App\Models\Supplier` | `database/factories/SupplierFactory.php` |
| `ProductFactory` | `App\Models\Product` | `database/factories/ProductFactory.php` |
| `EntryFactory` | `App\Models\Entry` | `database/factories/EntryFactory.php` |

#### ProductFactory - Métodos de Estado
- `outOfStock()` - Cria produto com `quantity = 0`
- `inactive()` - Cria produto com `is_active = false`

#### EntryFactory - Métodos de Estado
- `purchased()` - Cria entrada do tipo `purchased`
- `feeding()` - Cria entrada do tipo `feeding`
- `reversal()` - Cria entrada do tipo `reversal`

### 2. Helper de Regras de Negócio

Criado `app/Helpers/EntryRuleHelper.php` contendo 5 classes:

| Classe | Função |
|---|---|
| `EntryRuleHelper` | Cálculo de variação de estoque, validação de tipo de entrada |
| `InventoryRuleEngine` | Processamento seguro de mudanças de estoque (evita negativo, respeita máximo) |
| `FeedingRuleEngine` | Validação de regras de alimentação (produtos zerados, sem duplicados, mesmo fornecedor) |
| `ReversalRuleEngine` | Processamento de estorno com preservação de dados originais |
| `BusinessRuleAuditor` | Registro de violações de regras de negócio |

### 3. Correções Realizadas

- **`AuditHelper.php`** - Corrigidos parâmetros opcionais declarados antes de obrigatórios (deprecated no PHP 8.3)
- **`Product.php`** - Adicionado `max_stock_level` ao `$fillable`
- **`phpunit.xml`** - Preparado para uso com SQLite em memória (comentado, requer ativação do driver `pdo_sqlite`)

---

## Descrição dos Testes

### EntryRuleHelperTest (8 testes - TODOS PASSANDO)

Testa as classes de regras de negócio sem dependência de banco de dados.

| # | Método | O que testa |
|---|---|---|
| 1 | `test_calculate_stock_change_with_purchased_type` | Cálculo de variação para entrada de compra: (8-5)*1 = 3 |
| 2 | `test_calculate_stock_change_with_feeding_type` | Cálculo de variação para alimentação: (5-0)*1 = 5 |
| 3 | `test_calculate_stock_change_with_reversal_type` | Cálculo de variação para estorno: (5-8)*-1 = 3 |
| 4 | `test_get_entry_sign` | Sinais corretos: purchased=+1, feeding=+1, reversal=-1, inválido=+1 |
| 5 | `test_get_entry_sign_with_constants` | Sinais usando constantes do modelo Entry |
| 6 | `test_validate_entry_type_accepts_valid_types` | Validação aceita tipos válidos |
| 7 | `test_validate_entry_type_rejects_invalid_type` | Validação rejeita tipo inválido com ValidationException |
| 8 | `test_validate_entry_type_rejects_wrong_action_for_type` | Validação rejeita ação incorreta para o tipo |

### EntryControllerSetupTest (1 teste - PASSANDO)

| # | Método | O que testa |
|---|---|---|
| 1 | `test_controller_has_all_expected_methods` | Verifica existência dos 10 métodos do controller |

### EntryControllerTest (14 testes - REQUER BANCO DE DADOS)

Testa os métodos do controller com requisições HTTP.

| # | Método | Tipo | O que testa |
|---|---|---|---|
| 1 | `test_index_displays_entries` | GET | Página de listagem renderiza corretamente |
| 2 | `test_create_displays_form` | GET | Formulário de criação renderiza |
| 3 | `test_show_displays_entry_details` | GET | Detalhes da entrada com relacionamentos |
| 4 | `test_edit_displays_form` | GET | Formulário de edição com dados |
| 5 | `test_store_creates_purchased_entry` | POST | Cria entrada de compra, atualiza estoque, verifica pivot |
| 6 | `test_store_requires_products` | POST | Validação: produtos obrigatórios |
| 7 | `test_store_requires_valid_product_id` | POST | Validação: produto deve existir |
| 8 | `test_store_requires_positive_quantity` | POST | Validação: quantidade mínima = 1 |
| 9 | `test_create_feeding_displays_form` | GET | Formulário de alimentação renderiza |
| 10 | `test_store_feeding_creates_entry` | POST | Cria entrada de alimentação e atualiza estoque |
| 11 | `test_create_reversal_displays_form` | GET | Formulário de estorno renderiza |
| 12 | `test_store_reversal_reverts_stock` | POST | Estorna entrada e reverte estoque |
| 13 | `test_update_stock_increase` | PUT | Atualização que aumenta estoque: 15 -> 20 |
| 14 | `test_update_stock_decrease` | PUT | Atualização que diminui estoque: 15 -> 12 |

### EntryWorkflowTest (3 testes - REQUER BANCO DE DADOS)

Testes de integração com `RefreshDatabase`.

| # | Método | O que testa |
|---|---|---|
| 1 | `test_complete_entry_workflow_create_and_reverse` | Fluxo completo: criar entrada -> estornar -> verificar estoque zerado |
| 2 | `test_entry_update_workflow_with_stock_changes` | Fluxo de atualização: criar -> atualizar quantidade -> verificar pivot |
| 3 | `test_feed_multiple_products` | Alimentação de múltiplos produtos simultaneamente |

---

## Como Executar os Testes

### Pré-requisitos

Para executar todos os testes, é necessário um banco de dados:

**Opção 1 - SQLite em memória (recomendado)**
1. Ativar a extensão `pdo_sqlite` no `php.ini`:
   ```ini
   extension=pdo_sqlite
   ```
2. Descomentar no `phpunit.xml`:
   ```xml
   <env name="DB_CONNECTION" value="sqlite"/>
   <env name="DB_DATABASE" value=":memory:"/>
   ```

**Opção 2 - MySQL**
1. Ter MySQL rodando
2. Configurar `.env` com as credenciais corretas

### Comandos

```bash
# Testes de lógica (não precisam de banco)
vendor/bin/phpunit tests/Unit/EntryController/EntryRuleHelperTest.php
vendor/bin/phpunit tests/Unit/EntryController/EntryControllerSetupTest.php

# Todos os testes unitários
vendor/bin/phpunit tests/Unit/EntryController

# Testes de feature (fluxo completo)
vendor/bin/phpunit tests/Feature/EntryController

# Todos os testes de uma vez
vendor/bin/phpunit tests/Unit/EntryController tests/Feature/EntryController
```

### Resultado Atual

```
OK (9 tests, 27 assertions)  # Testes de lógica pura
```

Os 17 testes restantes (EntryControllerTest + EntryWorkflowTest) dependem de conexão com banco de dados.

---

## Cobertura de Regras de Negócio

| Regra | Testada em |
|---|---|
| Tipo de entrada válido (purchased/feeding/reversal) | `EntryRuleHelperTest` |
| Cálculo de variação de estoque com sinal | `EntryRuleHelperTest`, `EntryControllerTest` |
| Produtos com quantidade zero para alimentação | `EntryControllerTest::test_store_feeding_*` |
| Estorno não pode ser duplicado | `EntryControllerTest::test_store_reversal_*` |
| Validação de duplicados na lista de produtos | `EntryStoreRequest` (validação `distinct`) |
| Atualização de estoque em operações de update | `EntryControllerTest::test_update_stock_*` |
| Fluxo completo de entrada + estorno | `EntryWorkflowTest` |

---

## Arquivos Modificados no Projeto

| Arquivo | Tipo de Alteração |
|---|---|
| `database/factories/SupplierFactory.php` | Novo |
| `database/factories/ProductFactory.php` | Novo |
| `database/factories/EntryFactory.php` | Novo |
| `app/Helpers/EntryRuleHelper.php` | Novo |
| `app/Helpers/AuditHelper.php` | Corrigido (deprecated) |
| `app/Models/Product.php` | Adicionado `max_stock_level` |
| `composer.json` | Adicionado `EntryRuleHelper.php` ao autoload |
| `tests/Unit/EntryController/*.php` | 3 novos arquivos de teste |
| `tests/Feature/EntryController/*.php` | 1 novo arquivo de teste |
| `ANALISE_ENTRYCONTROLLER.md` | Documento de análise (raiz do projeto) |
