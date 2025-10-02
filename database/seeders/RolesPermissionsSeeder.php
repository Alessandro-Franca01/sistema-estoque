<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesPermissionsSeeder extends Seeder
{
    public function run()
    {
        DB::transaction(function () {
            // Primeiro, criar as roles
            $roles = $this->createRoles();

            // Depois, criar as permissions
            $permissions = $this->createPermissions();

            // Finalmente, associar permissions às roles
            $this->assignPermissionsToRoles($roles, $permissions);
        });
    }

    private function createRoles()
    {
        $rolesData = [
            [
                'name' => 'almoxarife',
                'display_name' => 'Almoxarife',
                'description' => 'Responsável pelas operações diárias do almoxarifado: entradas, saídas, inventários e atendimento a chamados.',
                'is_active' => true,
            ],
            [
                'name' => 'administrativo',
                'display_name' => 'Administrativo',
                'description' => 'Supervisão geral, aprovações, gestão de usuários, relatórios avançados e controle de auditoria.',
                'is_active' => true,
            ],
            [
                'name' => 'auditor',
                'display_name' => 'Auditor',
                'description' => 'Acesso apenas à leitura para fins de auditoria e fiscalização.',
                'is_active' => true,
            ],
            [
                'name' => 'consultor',
                'display_name' => 'Consultor',
                'description' => 'Acesso limitado apenas para consulta de informações específicas.',
                'is_active' => true,
            ],
        ];

        $roles = [];
        foreach ($rolesData as $roleData) {
            $roles[$roleData['name']] = Role::create($roleData);
            echo "✓ Role criada: {$roleData['display_name']}\n";
        }

        return $roles;
    }

    private function createPermissions()
    {
        // TODO: ADD DEPOIS AS PERMISSOES DOS FLUXOS DE ENTRADA, SAIDA E CHAMADOS
        $permissionsData = [
            // ==========================================
            // MÓDULO: DASHBOARD E NAVEGAÇÃO
            // ==========================================
            [
                'name' => 'dashboard.view',
                'display_name' => 'Visualizar Dashboard',
                'module' => 'dashboard',
                'action' => 'view',
                'description' => 'Acessar a página inicial do sistema',
            ],
            [
                'name' => 'navigation.reports',
                'display_name' => 'Acessar Menu Relatórios',
                'module' => 'navigation',
                'action' => 'view',
                'description' => 'Visualizar menu de relatórios',
            ],
            [
                'name' => 'navigation.admin',
                'display_name' => 'Acessar Menu Administrativo',
                'module' => 'navigation',
                'action' => 'view',
                'description' => 'Visualizar menu administrativo',
            ],

            // ==========================================
            // MÓDULO: PRODUTOS
            // ==========================================
            [
                'name' => 'products.view_any',
                'display_name' => 'Listar Produtos',
                'module' => 'products',
                'action' => 'view_any',
                'description' => 'Visualizar lista de produtos',
            ],
            [
                'name' => 'products.view',
                'display_name' => 'Visualizar Produto',
                'module' => 'products',
                'action' => 'view',
                'description' => 'Visualizar detalhes de um produto específico',
            ],
            [
                'name' => 'products.create',
                'display_name' => 'Criar Produtos',
                'module' => 'products',
                'action' => 'create',
                'description' => 'Cadastrar novos produtos',
            ],
            [
                'name' => 'products.update',
                'display_name' => 'Editar Produtos',
                'module' => 'products',
                'action' => 'update',
                'description' => 'Modificar dados de produtos existentes',
            ],
            [
                'name' => 'products.delete',
                'display_name' => 'Excluir Produtos',
                'module' => 'products',
                'action' => 'delete',
                'description' => 'Remover produtos do sistema',
            ],
            [
                'name' => 'products.toggle_status',
                'display_name' => 'Ativar/Desativar Produtos',
                'module' => 'products',
                'action' => 'toggle_status',
                'description' => 'Alterar status ativo/inativo de produtos',
            ],
            [
                'name' => 'products.view_stock',
                'display_name' => 'Visualizar Estoque',
                'module' => 'products',
                'action' => 'view_stock',
                'description' => 'Ver quantidades em estoque',
            ],

            // ==========================================
            // MÓDULO: CATEGORIAS
            // ==========================================
            [
                'name' => 'categories.view_any',
                'display_name' => 'Listar Categorias',
                'module' => 'categories',
                'action' => 'view_any',
                'description' => 'Visualizar lista de categorias',
            ],
            [
                'name' => 'categories.view',
                'display_name' => 'Visualizar Categoria',
                'module' => 'categories',
                'action' => 'view',
                'description' => 'Visualizar detalhes de categoria',
            ],
            [
                'name' => 'categories.create',
                'display_name' => 'Criar Categorias',
                'module' => 'categories',
                'action' => 'create',
                'description' => 'Cadastrar novas categorias',
            ],
            [
                'name' => 'categories.update',
                'display_name' => 'Editar Categorias',
                'module' => 'categories',
                'action' => 'update',
                'description' => 'Modificar categorias existentes',
            ],
            [
                'name' => 'categories.delete',
                'display_name' => 'Excluir Categorias',
                'module' => 'categories',
                'action' => 'delete',
                'description' => 'Remover categorias do sistema',
            ],
            [
                'name' => 'categories.toggle_status',
                'display_name' => 'Ativar/Desativar Categorias',
                'module' => 'categories',
                'action' => 'toggle_status',
                'description' => 'Alterar status das categorias',
            ],

            // ==========================================
            // MÓDULO: FORNECEDORES
            // ==========================================
            [
                'name' => 'suppliers.view_any',
                'display_name' => 'Listar Fornecedores',
                'module' => 'suppliers',
                'action' => 'view_any',
                'description' => 'Visualizar lista de fornecedores',
            ],
            [
                'name' => 'suppliers.view',
                'display_name' => 'Visualizar Fornecedor',
                'module' => 'suppliers',
                'action' => 'view',
                'description' => 'Ver detalhes de fornecedor específico',
            ],
            [
                'name' => 'suppliers.create',
                'display_name' => 'Criar Fornecedores',
                'module' => 'suppliers',
                'action' => 'create',
                'description' => 'Cadastrar novos fornecedores',
            ],
            [
                'name' => 'suppliers.update',
                'display_name' => 'Editar Fornecedores',
                'module' => 'suppliers',
                'action' => 'update',
                'description' => 'Modificar dados de fornecedores',
            ],
            [
                'name' => 'suppliers.delete',
                'display_name' => 'Excluir Fornecedores',
                'module' => 'suppliers',
                'action' => 'delete',
                'description' => 'Remover fornecedores do sistema',
            ],
            [
                'name' => 'suppliers.view_cnpj',
                'display_name' => 'Ver CNPJ Fornecedores',
                'module' => 'suppliers',
                'action' => 'view_sensitive',
                'description' => 'Visualizar CNPJ completo dos fornecedores',
            ],

            // ==========================================
            // MÓDULO: ENTRADAS
            // ==========================================
            [
                'name' => 'entries.view_any',
                'display_name' => 'Listar Entradas',
                'module' => 'entries',
                'action' => 'view_any',
                'description' => 'Visualizar lista de entradas',
            ],
            [
                'name' => 'entries.view',
                'display_name' => 'Visualizar Entrada',
                'module' => 'entries',
                'action' => 'view',
                'description' => 'Ver detalhes de entrada específica',
            ],
            [
                'name' => 'entries.create',
                'display_name' => 'Criar Entradas',
                'module' => 'entries',
                'action' => 'create',
                'description' => 'Registrar novas entradas no estoque',
            ],
            [
                'name' => 'entries.update',
                'display_name' => 'Editar Entradas',
                'module' => 'entries',
                'action' => 'update',
                'description' => 'Modificar entradas existentes',
            ],
            [
                'name' => 'entries.delete',
                'display_name' => 'Excluir Entradas',
                'module' => 'entries',
                'action' => 'delete',
                'description' => 'Remover registros de entrada',
            ],
            [
                'name' => 'entries.approve',
                'display_name' => 'Aprovar Entradas',
                'module' => 'entries',
                'action' => 'approve',
                'description' => 'Aprovar entradas pendentes',
            ],
            [
                'name' => 'entries.reject',
                'display_name' => 'Rejeitar Entradas',
                'module' => 'entries',
                'action' => 'reject',
                'description' => 'Rejeitar entradas pendentes',
            ],
            [
                'name' => 'entries.view_values',
                'display_name' => 'Ver Valores Entradas',
                'module' => 'entries',
                'action' => 'view_sensitive',
                'description' => 'Visualizar valores financeiros das entradas',
            ],
            [
                'name' => 'entries.view_all',
                'display_name' => 'Ver Todas Entradas',
                'module' => 'entries',
                'action' => 'view_all',
                'description' => 'Ver entradas de todos os usuários',
            ],

            // ==========================================
            // MÓDULO: SAÍDAS
            // ==========================================
            [
                'name' => 'outputs.view_any',
                'display_name' => 'Listar Saídas',
                'module' => 'outputs',
                'action' => 'view_any',
                'description' => 'Visualizar lista de saídas',
            ],
            [
                'name' => 'outputs.view',
                'display_name' => 'Visualizar Saída',
                'module' => 'outputs',
                'action' => 'view',
                'description' => 'Ver detalhes de saída específica',
            ],
            [
                'name' => 'outputs.create',
                'display_name' => 'Criar Saídas',
                'module' => 'outputs',
                'action' => 'create',
                'description' => 'Registrar novas saídas do estoque',
            ],
            [
                'name' => 'outputs.update',
                'display_name' => 'Editar Saídas',
                'module' => 'outputs',
                'action' => 'update',
                'description' => 'Modificar saídas existentes',
            ],
            [
                'name' => 'outputs.delete',
                'display_name' => 'Excluir Saídas',
                'module' => 'outputs',
                'action' => 'delete',
                'description' => 'Remover registros de saída',
            ],
            [
                'name' => 'outputs.finish',
                'display_name' => 'Finalizar Saídas',
                'module' => 'outputs',
                'action' => 'finish',
                'description' => 'Finalizar saídas com quantidades usadas/devolvidas',
            ],
            [
                'name' => 'outputs.cancel',
                'display_name' => 'Cancelar Saídas',
                'module' => 'outputs',
                'action' => 'cancel',
                'description' => 'Cancelar saídas em andamento',
            ],
            [
                'name' => 'outputs.approve',
                'display_name' => 'Aprovar Saídas',
                'module' => 'outputs',
                'action' => 'approve',
                'description' => 'Aprovar saídas pendentes',
            ],
            [
                'name' => 'outputs.view_all',
                'display_name' => 'Ver Todas Saídas',
                'module' => 'outputs',
                'action' => 'view_all',
                'description' => 'Ver saídas de todos os usuários',
            ],

            // ==========================================
            // MÓDULO: INVENTÁRIOS
            // ==========================================
            [
                'name' => 'inventories.view_any',
                'display_name' => 'Listar Inventários',
                'module' => 'inventories',
                'action' => 'view_any',
                'description' => 'Visualizar lista de inventários',
            ],
            [
                'name' => 'inventories.view',
                'display_name' => 'Visualizar Inventário',
                'module' => 'inventories',
                'action' => 'view',
                'description' => 'Ver detalhes de inventário específico',
            ],
            [
                'name' => 'inventories.create',
                'display_name' => 'Criar Inventários',
                'module' => 'inventories',
                'action' => 'create',
                'description' => 'Iniciar novos inventários',
            ],
            [
                'name' => 'inventories.update',
                'display_name' => 'Editar Inventários',
                'module' => 'inventories',
                'action' => 'update',
                'description' => 'Atualizar dados de inventário',
            ],
            [
                'name' => 'inventories.delete',
                'display_name' => 'Excluir Inventários',
                'module' => 'inventories',
                'action' => 'delete',
                'description' => 'Remover inventários',
            ],
            [
                'name' => 'inventories.close',
                'display_name' => 'Fechar Inventários',
                'module' => 'inventories',
                'action' => 'close',
                'description' => 'Fechar inventários e atualizar estoque',
            ],
            [
                'name' => 'inventories.approve',
                'display_name' => 'Aprovar Inventários',
                'module' => 'inventories',
                'action' => 'approve',
                'description' => 'Aprovar fechamento de inventários',
            ],

            // ==========================================
            // MÓDULO: CHAMADOS
            // ==========================================
            [
                'name' => 'calls.view_any',
                'display_name' => 'Listar Chamados',
                'module' => 'calls',
                'action' => 'view_any',
                'description' => 'Visualizar lista de chamados',
            ],
            [
                'name' => 'calls.view',
                'display_name' => 'Visualizar Chamado',
                'module' => 'calls',
                'action' => 'view',
                'description' => 'Ver detalhes de chamado específico',
            ],
            [
                'name' => 'calls.create',
                'display_name' => 'Criar Chamados',
                'module' => 'calls',
                'action' => 'create',
                'description' => 'Registrar novos chamados',
            ],
            [
                'name' => 'calls.update',
                'display_name' => 'Editar Chamados',
                'module' => 'calls',
                'action' => 'update',
                'description' => 'Modificar dados de chamados',
            ],
            [
                'name' => 'calls.delete',
                'display_name' => 'Excluir Chamados',
                'module' => 'calls',
                'action' => 'delete',
                'description' => 'Remover chamados do sistema',
            ],
            [
                'name' => 'calls.view_personal_data',
                'display_name' => 'Ver Dados Pessoais Chamados',
                'module' => 'calls',
                'action' => 'view_sensitive',
                'description' => 'Ver telefone e dados pessoais dos chamados',
            ],

            // ==========================================
            // MÓDULO: SERVIDORES PÚBLICOS
            // ==========================================
            [
                'name' => 'public_servants.view_any',
                'display_name' => 'Listar Servidores',
                'module' => 'public_servants',
                'action' => 'view_any',
                'description' => 'Visualizar lista de servidores públicos',
            ],
            [
                'name' => 'public_servants.view',
                'display_name' => 'Visualizar Servidor',
                'module' => 'public_servants',
                'action' => 'view',
                'description' => 'Ver detalhes de servidor específico',
            ],
            [
                'name' => 'public_servants.create',
                'display_name' => 'Criar Servidores',
                'module' => 'public_servants',
                'action' => 'create',
                'description' => 'Cadastrar novos servidores públicos',
            ],
            [
                'name' => 'public_servants.update',
                'display_name' => 'Editar Servidores',
                'module' => 'public_servants',
                'action' => 'update',
                'description' => 'Modificar dados de servidores',
            ],
            [
                'name' => 'public_servants.delete',
                'display_name' => 'Excluir Servidores',
                'module' => 'public_servants',
                'action' => 'delete',
                'description' => 'Remover servidores do sistema',
            ],
            [
                'name' => 'public_servants.view_cpf',
                'display_name' => 'Ver CPF Servidores',
                'module' => 'public_servants',
                'action' => 'view_sensitive',
                'description' => 'Visualizar CPF dos servidores',
            ],

            // ==========================================
            // MÓDULO: USUÁRIOS E ACESSOS
            // ==========================================
            [
                'name' => 'users.view_any',
                'display_name' => 'Listar Usuários',
                'module' => 'users',
                'action' => 'view_any',
                'description' => 'Visualizar lista de usuários do sistema',
            ],
            [
                'name' => 'users.view',
                'display_name' => 'Visualizar Usuário',
                'module' => 'users',
                'action' => 'view',
                'description' => 'Ver detalhes de usuário específico',
            ],
            [
                'name' => 'users.create',
                'display_name' => 'Criar Usuários',
                'module' => 'users',
                'action' => 'create',
                'description' => 'Cadastrar novos usuários',
            ],
            [
                'name' => 'users.update',
                'display_name' => 'Editar Usuários',
                'module' => 'users',
                'action' => 'update',
                'description' => 'Modificar dados de usuários',
            ],
            [
                'name' => 'users.delete',
                'display_name' => 'Excluir Usuários',
                'module' => 'users',
                'action' => 'delete',
                'description' => 'Remover usuários do sistema',
            ],
            [
                'name' => 'users.assign_roles',
                'display_name' => 'Atribuir Perfis',
                'module' => 'users',
                'action' => 'assign_roles',
                'description' => 'Atribuir e remover perfis de usuários',
            ],
            [
                'name' => 'users.reset_password',
                'display_name' => 'Resetar Senhas',
                'module' => 'users',
                'action' => 'reset_password',
                'description' => 'Resetar senhas de usuários',
            ],
            [
                'name' => 'users.toggle_status',
                'display_name' => 'Ativar/Desativar Usuários',
                'module' => 'users',
                'action' => 'toggle_status',
                'description' => 'Ativar ou desativar usuários',
            ],

            // ==========================================
            // MÓDULO: RELATÓRIOS
            // ==========================================
            [
                'name' => 'reports.stock',
                'display_name' => 'Relatório Estoque',
                'module' => 'reports',
                'action' => 'view',
                'description' => 'Gerar relatórios de posição de estoque',
            ],
            [
                'name' => 'reports.movements',
                'display_name' => 'Relatório Movimentações',
                'module' => 'reports',
                'action' => 'view',
                'description' => 'Gerar relatórios de movimentações',
            ],
            [
                'name' => 'reports.entries',
                'display_name' => 'Relatório Entradas',
                'module' => 'reports',
                'action' => 'view',
                'description' => 'Gerar relatórios de entradas',
            ],
            [
                'name' => 'reports.outputs',
                'display_name' => 'Relatório Saídas',
                'module' => 'reports',
                'action' => 'view',
                'description' => 'Gerar relatórios de saídas',
            ],
            [
                'name' => 'reports.inventory',
                'display_name' => 'Relatório Inventário',
                'module' => 'reports',
                'action' => 'view',
                'description' => 'Gerar relatórios de inventários',
            ],
            [
                'name' => 'reports.financial',
                'display_name' => 'Relatório Financeiro',
                'module' => 'reports',
                'action' => 'view',
                'description' => 'Gerar relatórios financeiros',
            ],
            [
                'name' => 'reports.calls',
                'display_name' => 'Relatório Chamados',
                'module' => 'reports',
                'action' => 'view',
                'description' => 'Gerar relatórios de chamados',
            ],
            [
                'name' => 'reports.export',
                'display_name' => 'Exportar Relatórios',
                'module' => 'reports',
                'action' => 'export',
                'description' => 'Exportar relatórios em diferentes formatos',
            ],

            // ==========================================
            // MÓDULO: AUDITORIA E LOGS
            // ==========================================
            [
                'name' => 'audit.view_any',
                'display_name' => 'Listar Logs Auditoria',
                'module' => 'audit',
                'action' => 'view_any',
                'description' => 'Visualizar logs de auditoria',
            ],
            [
                'name' => 'audit.view',
                'display_name' => 'Visualizar Log Específico',
                'module' => 'audit',
                'action' => 'view',
                'description' => 'Ver detalhes de log específico',
            ],
            [
                'name' => 'audit.export',
                'display_name' => 'Exportar Logs Auditoria',
                'module' => 'audit',
                'action' => 'export',
                'description' => 'Exportar logs para auditoria externa',
            ],
            [
                'name' => 'audit.dashboard',
                'display_name' => 'Dashboard Auditoria',
                'module' => 'audit',
                'action' => 'view',
                'description' => 'Acessar dashboard de auditoria',
            ],
            [
                'name' => 'audit.notifications',
                'display_name' => 'Notificações Auditoria',
                'module' => 'audit',
                'action' => 'view',
                'description' => 'Ver notificações de auditoria',
            ],

            // ==========================================
            // MÓDULO: CONFIGURAÇÕES SISTEMA
            // ==========================================
            [
                'name' => 'settings.view',
                'display_name' => 'Ver Configurações',
                'module' => 'settings',
                'action' => 'view',
                'description' => 'Visualizar configurações do sistema',
            ],
            [
                'name' => 'settings.update',
                'display_name' => 'Alterar Configurações',
                'module' => 'settings',
                'action' => 'update',
                'description' => 'Modificar configurações do sistema',
            ],
            [
                'name' => 'backup.create',
                'display_name' => 'Criar Backup',
                'module' => 'backup',
                'action' => 'create',
                'description' => 'Executar backup do sistema',
            ],
            [
                'name' => 'backup.restore',
                'display_name' => 'Restaurar Backup',
                'module' => 'backup',
                'action' => 'restore',
                'description' => 'Restaurar backup do sistema',
            ],
        ];

        $permissions = [];
        foreach ($permissionsData as $permissionData) {
            $permissions[$permissionData['name']] = Permission::create($permissionData);
            echo "✓ Permission criada: {$permissionData['display_name']}\n";
        }

        return $permissions;
    }

    private function assignPermissionsToRoles($roles, $permissions)
    {
        // ==========================================
        // PERFIL: ALMOXARIFE (Operacional)
        // ==========================================
        $almoxarifePermissions = [
            // Dashboard e Navegação
            'dashboard.view',

            // Produtos
            'products.view_any',
            'products.view',
            'products.create',

            // Categorias (apenas visualização)
            'categories.view_any',
            'categories.view',
            'categories.update',
            'categories.create',

            // Fornecedores (apenas visualização)
            'suppliers.view_any',
            'suppliers.view',

            // Entradas
            'entries.view_any',
            'entries.view',
            'entries.create',
//            'entries.update',

            // Saídas
            'outputs.view_any',
            'outputs.view',
            'outputs.create',
            'outputs.finish',

            // Inventários
            'inventories.view_any',
            'inventories.view',

            // Chamados
            'calls.view_any',
            'calls.view',
            'calls.create',

            // Servidores (apenas visualização)
            'public_servants.view_any',
            'public_servants.view',

            // Relatórios básicos
            'reports.stock',
            'reports.movements',
            'reports.entries',
            'reports.outputs',
            'reports.inventory',
            'reports.calls',
        ];

        foreach ($almoxarifePermissions as $permissionName) {
            if (isset($permissions[$permissionName])) {
                $roles['almoxarife']->permissions()->attach($permissions[$permissionName]);
            }
        }
        echo "✓ Permissions atribuídas ao Almoxarife: " . count($almoxarifePermissions) . "\n";

        // ==========================================
        // PERFIL: ADMINISTRATIVO (Supervisão)
        // ==========================================
        $administrativoPermissions = [
            // Todas as permissões do almoxarife
            ...$almoxarifePermissions,

            // Dashboard e Navegação administrativa
            'navigation.reports',
            'navigation.admin',

            // Produtos - permissões administrativas
            'products.delete',
            'products.toggle_status',

            // Categorias - gestão completa
            'categories.create',
            'categories.update',
            'categories.delete',
            'categories.toggle_status',

            // Fornecedores - gestão completa
            'suppliers.create',
            'suppliers.update',
            'suppliers.delete',
            'suppliers.view_cnpj',

            // Entradas - permissões administrativas
//            'entries.delete',
            'entries.create',
            'entries.reject',
            'entries.view_values',
            'entries.view_all',

            // Saídas - permissões administrativas
//            'outputs.delete',
            'outputs.cancel',
            'outputs.approve',
            'outputs.view_all',

            // Inventários - permissões administrativas
            'inventories.delete',
            'inventories.close',
            'inventories.approve',

            // Chamados - permissões administrativas
            'calls.delete',
            'calls.view_personal_data',

            // Servidores - gestão completa
            'public_servants.create',
            'public_servants.update',
            'public_servants.delete',
            'public_servants.view_cpf',

            // Usuários e Acessos
            'users.view_any',
            'users.view',
            'users.create',
            'users.update',
            'users.assign_roles',
            'users.reset_password',
            'users.toggle_status',

            // Relatórios completos
            'reports.financial',
            'reports.export',

            // Auditoria
            'audit.view_any',
            'audit.view',
            'audit.dashboard',

            // Configurações
            'settings.view',
            'settings.update',
        ];

        foreach ($administrativoPermissions as $permissionName) {
            if (isset($permissions[$permissionName])) {
                $roles['administrativo']->permissions()->attach($permissions[$permissionName]);
            }
        }
        echo "✓ Permissions atribuídas ao Administrativo: " . count($administrativoPermissions) . "\n";

        // ==========================================
        // PERFIL: AUDITOR (Somente leitura)
        // ==========================================
        $auditorPermissions = [
            // Dashboard
            'dashboard.view',

            // Visualização geral
            'products.view_any',
            'products.view',
            'products.view_stock',
            'categories.view_any',
            'categories.view',
            'suppliers.view_any',
            'suppliers.view',
            'entries.view_any',
            'entries.view',
            'entries.view_values',
            'entries.view_all',
            'outputs.view_any',
            'outputs.view',
            'outputs.view_all',
            'inventories.view_any',
            'inventories.view',
            'calls.view_any',
            'calls.view',
            'public_servants.view_any',
            'public_servants.view',
            'users.view_any',
            'users.view',

            // Relatórios completos
            'reports.stock',
            'reports.movements',
            'reports.entries',
            'reports.outputs',
            'reports.inventory',
            'reports.financial',
            'reports.calls',
            'reports.export',

            // Auditoria completa
            'audit.view_any',
            'audit.view',
            'audit.export',
            'audit.dashboard',
            'audit.notifications',
        ];

        foreach ($auditorPermissions as $permissionName) {
            if (isset($permissions[$permissionName])) {
                $roles['auditor']->permissions()->attach($permissions[$permissionName]);
            }
        }
        echo "✓ Permissions atribuídas ao Auditor: " . count($auditorPermissions) . "\n";

        // ==========================================
        // PERFIL: CONSULTOR (Acesso limitado)
        // ==========================================
        $consultorPermissions = [
            // Dashboard
            'dashboard.view',

            // Visualização básica
            'products.view_any',
            'products.view',
            'products.view_stock',
            'categories.view_any',
            'categories.view',
            'suppliers.view_any',
            'suppliers.view',
            'entries.view_any',
            'entries.view',
            'outputs.view_any',
            'outputs.view',
            'inventories.view_any',
            'inventories.view',
            'calls.view_any',
            'calls.view',
            'public_servants.view_any',
            'public_servants.view',

            // Relatórios básicos
            'reports.stock',
            'reports.movements',
            'reports.entries',
            'reports.outputs',
            'reports.inventory',
            'reports.calls',
        ];

        foreach ($consultorPermissions as $permissionName) {
            if (isset($permissions[$permissionName])) {
                $roles['consultor']->permissions()->attach($permissions[$permissionName]);
            }
        }
        echo "✓ Permissions atribuídas ao Consultor: " . count($consultorPermissions) . "\n";
    }
}
