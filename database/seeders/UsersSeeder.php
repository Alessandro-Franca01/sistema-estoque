<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesPermissionsSeeder extends Seeder
{
    public function run()
    {
        DB::transaction(function () {
            // Criando os users
            $users = $this->createUsers();
        });
    }

    private function createUsers()
    {
        $userData = [
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
        ];

        $users = [];
        foreach ($userData as $user) {
            $users[$user['name']] = User::create($user);
            echo "✓ User criado: {$user['name']}\n";
        }

        return $users;
    }
}