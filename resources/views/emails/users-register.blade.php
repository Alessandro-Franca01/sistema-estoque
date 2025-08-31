<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Bem-vindo ao Sistema</title>
</head>
<body style="margin:0;padding:0;background:#f5f7fb;font-family:Arial,Helvetica,sans-serif;color:#111827;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f5f7fb;padding:24px 0;">
    <tr>
        <td align="center">
            <table role="presentation" width="600" cellspacing="0" cellpadding="0" style="background:#ffffff;border-radius:8px;overflow:hidden;border:1px solid #e5e7eb;">
                <tr>
                    <td style="background:#1f2937;padding:20px 24px;color:#ffffff;">
                        <h1 style="margin:0;font-size:20px;line-height:1.2;">Bem-vindo ao Sistema de Estoque</h1>
                    </td>
                </tr>
                <tr>
                    <td style="padding:24px;">
                        <p style="margin:0 0 12px 0;font-size:14px;">
                            Olá, <strong>{{ $data['name'] ?? 'Usuário' }}</strong>!
                        </p>
                        <p style="margin:0 0 12px 0;font-size:14px;">
                            Esse é um e-mail de cadastro no GestIn.
                        </p>

                        <table role="presentation" cellspacing="0" cellpadding="0" style="width:100%;margin:16px 0;border:1px solid #e5e7eb;border-radius:6px;">
                            <tr>
                                <td style="padding:12px;border-bottom:1px solid #e5e7eb;background:#fafafa;width:180px;"><strong>E-mail</strong></td>
                                <td style="padding:12px;border-bottom:1px solid #e5e7eb;">{{ $data['email'] ?? '' }}</td>
                            </tr>
                            <tr>
                                <td style="padding:12px;background:#fafafa;"><strong>Perfil</strong></td>
                                <td style="padding:12px;">{{ $data['role'] ?? 'Não informado' }}</td>
                            </tr>
                            @if(!empty($data['registration']))
                                <tr>
                                    <td style="padding:12px;background:#fafafa;border-top:1px solid #e5e7eb;"><strong>Matrícula</strong></td>
                                    <td style="padding:12px;border-top:1px solid #e5e7eb;">{{ $data['registration'] }}</td>
                                </tr>
                            @endif
                        </table>

                        <p style="margin:0 0 12px 0;font-size:14px;">
                            Para acessar o formulário de cadastro, utilize o botão abaixo:
                        </p>

                        <p style="margin:16px 0;">
                            <a href="{{ url('/register') }}"
                               style="display:inline-block;background:#4f46e5;color:#ffffff;text-decoration:none;padding:10px 16px;border-radius:6px;font-size:14px;">
                                Cadastre-se
                            </a>
                        </p>

                        <p style="margin:16px 0 0 0;font-size:12px;color:#6b7280;">
                            Se você não reconhece está mensagem, por favor entre em contato com o suporte..
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="background:#f9fafb;padding:16px 24px;color:#6b7280;font-size:12px;text-align:center;border-top:1px solid #e5e7eb;">
                        © {{ date('Y') }} Sistema de Estoque. Todos os direitos reservados.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
