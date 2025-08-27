<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo ao Sistema de Estoque</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #4f46e5;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #4f46e5;
            margin: 0;
            font-size: 28px;
        }
        .credentials-box {
            background-color: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .credential-item {
            margin: 10px 0;
            font-size: 16px;
        }
        .credential-label {
            font-weight: bold;
            color: #374151;
        }
        .credential-value {
            background-color: #ffffff;
            padding: 8px 12px;
            border-radius: 4px;
            border: 1px solid #d1d5db;
            font-family: 'Courier New', monospace;
            color: #1f2937;
        }
        .warning-box {
            background-color: #fef3cd;
            border: 1px solid #fbbf24;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
        }
        .warning-box strong {
            color: #92400e;
        }
        .login-button {
            display: inline-block;
            background-color: #4f46e5;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Bem-vindo ao Sistema de Estoque!</h1>
        </div>

        <p>Olá <strong>{{ $user->name }}</strong>,</p>

        <p>Sua conta foi criada com sucesso no Sistema de Estoque! Estamos muito felizes em tê-lo(a) em nossa equipe.</p>

        <div class="credentials-box">
            <h3 style="margin-top: 0; color: #374151;">📧 Suas Credenciais de Acesso</h3>
            
            <div class="credential-item">
                <div class="credential-label">Email:</div>
                <div class="credential-value">{{ $user->email }}</div>
            </div>
            
            <div class="credential-item">
                <div class="credential-label">Senha Temporária:</div>
                <div class="credential-value">{{ $temporaryPassword }}</div>
            </div>
        </div>

        <div class="warning-box">
            <strong>⚠️ Importante:</strong> Por motivos de segurança, recomendamos que você altere sua senha no primeiro acesso ao sistema. Acesse seu perfil e defina uma nova senha segura.
        </div>

        <div style="text-align: center;">
            <a href="{{ route('login') }}" class="login-button">
                🔐 Acessar o Sistema
            </a>
        </div>

        <h3>📋 Informações da sua conta:</h3>
        <ul>
            <li><strong>Nome:</strong> {{ $user->name }}</li>
            <li><strong>Email:</strong> {{ $user->email }}</li>
            @if($user->publicServant)
                <li><strong>Matrícula:</strong> {{ $user->publicServant->registration }}</li>
                <li><strong>Departamento:</strong> {{ $user->publicServant->department ?? 'Não informado' }}</li>
                <li><strong>Cargo:</strong> {{ $user->publicServant->position ?? 'Não informado' }}</li>
            @endif
        </ul>

        <h3>🚀 Próximos passos:</h3>
        <ol>
            <li>Faça login no sistema usando suas credenciais</li>
            <li>Altere sua senha temporária</li>
            <li>Complete seu perfil com informações adicionais</li>
            <li>Explore as funcionalidades do sistema</li>
        </ol>

        <p>Se você tiver alguma dúvida ou precisar de ajuda, não hesite em entrar em contato com nossa equipe de suporte.</p>

        <p>Bem-vindo(a) à bordo!</p>

        <div class="footer">
            <p>Este é um email automático do Sistema de Estoque.<br>
            Por favor, não responda a este email.</p>
            <p><small>© {{ date('Y') }} Sistema de Estoque. Todos os direitos reservados.</small></p>
        </div>
    </div>
</body>
</html>
