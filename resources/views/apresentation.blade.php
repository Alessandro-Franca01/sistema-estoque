<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GestIn</title>
    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
        }

        body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #333;
            overflow: hidden;
        }

        .slideshow-container {
    position: relative;
    width: 100%;
    height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .slide {
    display: none;
    width: 90%;
    max-width: 1000px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            padding: 40px;
            text-align: center;
            animation: slideIn 0.5s ease-in-out;
        }

        .slide.active {
    display: block;
}

        @keyframes slideIn {
    from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h1 {
    color: #667eea;
    margin-bottom: 30px;
            font-size: 2.5em;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        h2 {
    color: #764ba2;
    margin-bottom: 25px;
            font-size: 2em;
            font-weight: 600;
        }

        h3 {
    color: #667eea;
    margin-bottom: 20px;
            font-size: 1.5em;
            font-weight: 500;
        }

        .subtitle {
    font-size: 1.3em;
            color: #666;
            margin-bottom: 30px;
            font-style: italic;
        }

        .features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }

        .feature-card {
    background: linear-gradient(45deg, #f8f9ff, #e8eeff);
            padding: 25px;
            border-radius: 15px;
            border-left: 5px solid #667eea;
            text-align: left;
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
    transform: translateY(-5px);
        }

        .feature-card h4 {
    color: #667eea;
    margin-bottom: 10px;
            font-size: 1.2em;
        }

        .tech-stack {
    display: flex;
    flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin: 30px 0;
        }

        .tech-item {
    background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            padding: 12px 20px;
            border-radius: 25px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            transition: transform 0.3s ease;
        }

        .tech-item:hover {
    transform: scale(1.05);
}

        .navigation {
    position: fixed;
    bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 15px;
        }

        .nav-btn {
    background: rgba(255,255,255,0.2);
    border: 2px solid white;
            color: white;
            padding: 12px 20px;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .nav-btn:hover {
    background: white;
    color: #667eea;
}

        .slide-counter {
    position: fixed;
    top: 30px;
            right: 30px;
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            font-weight: 600;
            backdrop-filter: blur(10px);
        }

        .architecture-diagram {
    display: flex;
    justify-content: space-around;
            align-items: center;
            margin: 30px 0;
            flex-wrap: wrap;
        }

        .layer {
    background: linear-gradient(45deg, #f8f9ff, #e8eeff);
            padding: 20px;
            border-radius: 15px;
            margin: 10px;
            border: 2px solid #667eea;
            min-width: 200px;
        }

        .layer h4 {
    color: #667eea;
    margin-bottom: 10px;
        }

        .benefits-list {
    text-align: left;
            max-width: 600px;
            margin: 0 auto;
        }

        .benefits-list li {
    margin: 15px 0;
            padding-left: 30px;
            position: relative;
            font-size: 1.1em;
        }

        .benefits-list li:before {
    content: "✓";
    position: absolute;
    left: 0;
    color: #28a745;
    font-weight: bold;
            font-size: 1.2em;
        }

        .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }

        .stat-card {
    background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
        }

        .stat-number {
    font-size: 2.5em;
            font-weight: bold;
            display: block;
        }

        .stat-label {
    font-size: 1.1em;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="slideshow-container">
        <!-- Slide 0: Marketing -->
        <div class="slide active">
            <div class="system-header" style="text-align: center; margin-bottom: 30px;">
                <div style="display: inline-flex; align-items: center; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 15px 25px; border-radius: 50px; color: white; box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);">
                    <span style="font-size: 28px; margin-right: 10px;">🚀</span>
                    <h2 style="margin: 0; font-size: 28px; font-weight: bold; letter-spacing: 0.5px; color: #e3f2fd;">GestIn</h2>
                    <span style="margin: 0 10px; font-weight: 300;">|</span>
                    <span style="font-size: 16px; opacity: 0.9;">Gestão + Inovação</span>
                </div>
            </div>

            <div class="slogan-container" style="text-align: center; margin: 25px 0;">
                <p class="subtitle" style="font-size: 20px; color: #6c757d; font-style: italic; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; font-weight: 600; padding: 10px; border-radius: 10px;">
    💡 “Organização inteligente para um futuro eficiente.”
</p>
            </div>

            <div class="description-card" style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 35px rgba(0,0,0,0.1); border: 1px solid #e3f2fd; margin: 20px 0;">
                <div style="display: flex; align-items: flex-start; margin-bottom: 20px;">
                    <div style="font-size: 32px; margin-right: 15px;">🧠</div>
                    <h3 style="margin: 0; color: #2c5282; font-size: 22px; font-weight: 600;">Descrição do Sistema</h3>
                </div>

                <p style="color: #4a5568; line-height: 1.8; font-size: 16px; margin: 0; text-align: justify; background: linear-gradient(135deg, #f7f9fc 0%, #ffffff 100%); padding: 20px; border-radius: 15px; border-left: 4px solid #667eea; margin-bottom: 10px">
    O <strong style="color: #667eea;">GestIn</strong> é um sistema desenvolvido especialmente pela
<strong>Secretaria de Inovação e Tecnologia</strong>, focado na gestão eficiente e moderna de
                    estoques públicos. Ele incorpora <strong>automação</strong>, <strong>rastreabilidade</strong>
e <strong>transparência</strong>, promovendo inovação e eficiência na administração de recursos.
                </p>
Desenvolvido por: <strong>Alessandro de França Silva</strong><br>
Por meio: <strong>SECTIN</strong> - Secretaria de Tecnologia, Ciência e Inovação.
            </div>
        </div>

        <!-- Slide 1: Título -->
        <div class="slide">
            <h1> Imformações Gerais do Sistema</h1>
            <p class="subtitle">Subdividido por modulos, cada modulo possui suas funcionalidades e suas permissoes.</p>
            <div class="stats-grid">
                <div class="stat-card">
                    <span class="stat-number">9+</span>
                    <span class="stat-label">Módulos</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number">36+</span>
                    <span class="stat-label">Funcionalidades</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number">20+</span>
                    <span class="stat-label">Permissões de Acesso</span>
                </div>
            </div>
        </div>

        <!-- Slide 2: Visão Geral -->
        <div class="slide">
            <h2>Visão Geral do Sistema</h2>
            <p class="subtitle">Sistema web desenvolvido para automatizar e controlar processos de almoxarifado</p>
            <div class="benefits-list">
                <ul>
                    <li>Controle completo de estoque e movimentações</li>
                    <li>Gestão de fornecedores e categorias</li>
                    <li>Rastreabilidade completa com auditoria</li>
                    <li>Sistema de permissões e roles</li>
                    <li>Interface moderna e responsiva</li>
                    <li>Relatórios e inventários automatizados</li>
                </ul>
            </div>
        </div>

        <!-- Slide 3: Arquitetura -->
        <div class="slide">
            <h2>Arquitetura do Sistema</h2>
            <div class="architecture-diagram">
                <div class="layer">
                    <h4>Frontend</h4>
                    <p>Blade Templates<br>Tailwind CSS<br>JavaScript</p>
                </div>
                <div class="layer">
                    <h4>Backend</h4>
                    <p>Laravel 11<br>PHP 8.2+<br>MVC Pattern</p>
                </div>
                <div class="layer">
                    <h4>Banco de Dados</h4>
                    <p>MySQL<br>Migrations<br>Eloquent ORM</p>
                </div>
                <div class="layer">
                    <h4>Segurança</h4>
                    <p>Autenticação<br>Autorização<br>Auditoria</p>
                </div>
            </div>
        </div>

        <!-- Slide 4: Tecnologias -->
        <div class="slide">
            <h2>Stack Tecnológica</h2>
            <div class="tech-stack">
                <span class="tech-item">Laravel 11</span>
                <span class="tech-item">PHP 8.2+</span>
                <span class="tech-item">MySQL</span>
                <span class="tech-item">Blade Templates</span>
                <span class="tech-item">Tailwind CSS</span>
                <span class="tech-item">JavaScript</span>
                <span class="tech-item">Eloquent ORM</span>
                <span class="tech-item">Laravel Breeze</span>
            </div>
            <p style="margin-top: 30px; font-size: 1.1em; color: #666;">
    Framework moderno e robusto garantindo performance, segurança e escalabilidade
</p>
        </div>

        <!-- Slide 5: Módulos Principais -->
        <div class="slide">
            <h2>Módulos do Sistema</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <h4>📦 Gestão de Produtos</h4>
                    <p>Cadastro, categorização e controle de produtos com código único e unidades de medida</p>
                </div>
                <div class="feature-card">
                    <h4>🏢 Fornecedores</h4>
                    <p>Controle completo de fornecedores com dados fiscais e comerciais</p>
                </div>
                <div class="feature-card">
                    <h4>📥 Entradas</h4>
                    <p>Registro de compras, alimentação de estoque e controle de lotes</p>
                </div>
                <div class="feature-card">
                    <h4>📤 Saídas</h4>
                    <p>Controle de retiradas, operadores responsáveis e devolução de materiais</p>
                </div>
            </div>
        </div>

        <!-- Slide 6: Funcionalidades Avançadas -->
        <div class="slide">
            <h2>Funcionalidades Avançadas</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <h4>🔍 Sistema de Auditoria</h4>
                    <p>Rastreamento completo de todas as ações no sistema com logs detalhados</p>
                </div>
                <div class="feature-card">
                    <h4>👥 Gestão de Usuários</h4>
                    <p>Sistema de roles (Almoxarife, Administrativo) com permissões específicas</p>
                </div>
                <div class="feature-card">
                    <h4>📊 Inventários</h4>
                    <p>Controle de inventários com conferência física e ajustes automáticos</p>
                </div>
                <div class="feature-card">
                    <h4>📞 Chamados</h4>
                    <p>Sistema de solicitações integrado com controle de saídas</p>
                </div>
            </div>
        </div>

        <!-- Slide 7: Segurança -->
        <div class="slide">
            <h2>Segurança e Controle</h2>
            <div class="benefits-list">
                <ul>
                    <li><strong>Autenticação Segura:</strong> Laravel Breeze com hash de senhas</li>
                    <li><strong>Sistema de Permissões:</strong> Roles e permissões granulares</li>
                    <li><strong>Log de Acessos:</strong> Registro de IP e User Agent</li>
                    <li><strong>Auditoria Completa:</strong> Tracking de todas as alterações</li>
                    <li><strong>Validação de Dados:</strong> Form Requests customizados</li>
                    <li><strong>Proteção CSRF:</strong> Tokens de segurança em formulários</li>
                    <li><strong>Sanitização:</strong> Validação e limpeza de inputs</li>
                </ul>
            </div>
        </div>

        <!-- Slide 8: Modelos de Dados -->
        <div class="slide">
            <h2>Estrutura de Dados</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <h4>👤 Usuários e Servidores</h4>
                    <p>User, PublicServant, Role, Permission</p>
                </div>
                <div class="feature-card">
                    <h4>📦 Produtos e Categorias</h4>
                    <p>Product, Category, Supplier</p>
                </div>
                <div class="feature-card">
                    <h4>📊 Movimentações</h4>
                    <p>Entry, Output, ProductEntry, ProductOutput</p>
                </div>
                <div class="feature-card">
                    <h4>🔍 Controles</h4>
                    <p>AuditLog, LoginLog, Inventory, Call</p>
                </div>
            </div>
        </div>

        <!-- Slide 9: Fluxo de Trabalho -->
        <div class="slide">
            <h2>Fluxo de Trabalho</h2>
            <div style="text-align: left; max-width: 700px; margin: 0 auto;">
                <h3 style="text-align: center; margin-bottom: 30px;">Processo de Entrada</h3>
                <div style="background: #f8f9ff; padding: 20px; border-radius: 10px; margin: 15px 0;">
                    <strong>1. Recebimento:</strong> Cadastro da entrada com fornecedor e nota fiscal
</div>
                <div style="background: #f8f9ff; padding: 20px; border-radius: 10px; margin: 15px 0;">
                    <strong>2. Conferência:</strong> Validação de produtos, quantidades e lotes
</div>
                <div style="background: #f8f9ff; padding: 20px; border-radius: 10px; margin: 15px 0;">
                    <strong>3. Atualização:</strong> Incremento automático do estoque
</div>
                <div style="background: #f8f9ff; padding: 20px; border-radius: 10px; margin: 15px 0;">
                    <strong>4. Auditoria:</strong> Registro automático da operação
</div>
            </div>
        </div>

        <!-- Slide 10: Benefícios -->
        <div class="slide">
            <h2>Benefícios da Implementação</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <span class="stat-number">100%</span>
                    <span class="stat-label">Rastreabilidade</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number">80%</span>
                    <span class="stat-label">Redução de Erros</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number">90%</span>
                    <span class="stat-label">Automatização</span>
                </div>
            </div>
            <div class="benefits-list" style="margin-top: 30px;">
                <ul>
                    <li>Eliminação de controles manuais em planilhas</li>
                    <li>Redução significativa de perdas e desperdícios</li>
                    <li>Controle rigoroso de custos e orçamento (TCE)</li>
                    <li>Relatórios automáticos, personalizados e periódicos</li>
                    <li>Conformidade com normas de auditoria</li>
                </ul>
            </div>
        </div>

        <!-- Slide 11: Futuras Implementações -->
        <div class="slide">
            <h2>Roadmap de Melhorias</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <h4>📈 Relatórios </h4>
                    <p>Relatórios detalhados solicitados para TCE</p>
                </div>
                <div class="feature-card">
                    <h4>🔔 Notificações</h4>
                    <p>Alertas automáticos de estoque baixo</p>
                </div>
                <div class="feature-card">
                    <h4>📱 Mobile App </h4>
                    <p>Aplicativo mobile para operações em campo</p>
                </div>
                <div class="feature-card">
                    <h4>📊 Dashboard Avançado</h4>
                    <p>Uso de Gráficos e indicadores </p>
                </div>
            </div>
        </div>

        <!-- Slide 12: Conclusão -->
        <div class="slide">
            <h1>Obrigado!</h1>
            <p class="subtitle">Vamos iniciar o treinamento!</p>
            <div style="margin: 40px 0;">
                <h3>Agradecimento a Secretaria de Tecnologia, Ciência e Inovação</h3>
                <p style="font-size: 1.2em; color: #666; margin-top: 20px;">
    Em especial ao Secretario: <strong> Sr. Herlón Cabral de Medeiros </strong>
                </p>
            </div>
            <div style="background: linear-gradient(45deg, #f8f9ff, #e8eeff); padding: 30px; border-radius: 15px; margin-top: 30px;">
                <p style="font-size: 1.1em; color: #667eea; font-weight: 600;">
    "Transformando processos antigos em soluções digitais eficientes"
                </p>
            </div>
        </div>
    </div>

    <div class="slide-counter">
        <span id="current-slide">1</span> / <span id="total-slides">12</span>
    </div>

    <div class="navigation">
        <button class="nav-btn" onclick="changeSlide(-1)">← Anterior</button>
        <button class="nav-btn" onclick="changeSlide(1)">Próximo →</button>
    </div>

    <script>
let currentSlide = 0;
        const slides = document.querySelectorAll('.slide');
        const totalSlides = slides.length;

        document.getElementById('total-slides').textContent = totalSlides;

        function showSlide(n) {
            slides[currentSlide].classList.remove('active');
            currentSlide = (n + totalSlides) % totalSlides;
            slides[currentSlide].classList.add('active');
            document.getElementById('current-slide').textContent = currentSlide + 1;
        }

        function changeSlide(direction) {
            showSlide(currentSlide + direction);
        }

        // Navegação por teclado
        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowRight' || e.key === ' ') {
                changeSlide(1);
            } else if (e.key === 'ArrowLeft') {
                changeSlide(-1);
            }
        });

        // Auto-play opcional (descomentado se desejar)
        // setInterval(() => changeSlide(1), 10000);
    </script>
</body>
</html>
