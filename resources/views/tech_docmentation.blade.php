<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GESTIN - Documentação Completa</title>
    <style>
        @page {
            size: A4;
            margin: 2cm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Calibri', 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background: #fff;
        }

        .page {
            width: 21cm;
            min-height: 29.7cm;
            margin: 0 auto;
            background: white;
            padding: 2cm;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            page-break-after: always;
        }

        .cover-page {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            min-height: 25.7cm;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
        }

        .cover-logo {
            width: 150px;
            height: 150px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 40px;
            font-size: 48px;
            color: #1e3c72;
            font-weight: bold;
        }

        .cover-title {
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .cover-subtitle {
            font-size: 24px;
            margin-bottom: 40px;
            font-weight: 300;
        }

        .cover-institution {
            font-size: 18px;
            margin-top: 60px;
            font-weight: 500;
        }

        .cover-date {
            font-size: 16px;
            margin-top: 20px;
            opacity: 0.9;
        }

        .header {
            border-bottom: 3px solid #1e3c72;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }

        .header-title {
            color: #1e3c72;
            font-size: 28px;
            font-weight: bold;
        }

        .header-subtitle {
            color: #666;
            font-size: 14px;
            margin-top: 5px;
        }

        h1 {
            color: #1e3c72;
            font-size: 32px;
            margin-bottom: 25px;
            border-bottom: 2px solid #2a5298;
            padding-bottom: 10px;
        }

        h2 {
            color: #2a5298;
            font-size: 24px;
            margin-top: 30px;
            margin-bottom: 15px;
        }

        h3 {
            color: #1e3c72;
            font-size: 18px;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        p {
            margin-bottom: 15px;
            text-align: justify;
            font-size: 12pt;
        }

        .section {
            margin-bottom: 40px;
        }

        .info-box {
            background: #f0f4ff;
            border-left: 4px solid #1e3c72;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }

        .info-box-title {
            color: #1e3c72;
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 14pt;
        }

        .feature-list {
            list-style: none;
            margin: 20px 0;
        }

        .feature-list li {
            padding: 12px 0;
            padding-left: 30px;
            position: relative;
            font-size: 12pt;
        }

        .feature-list li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #28a745;
            font-weight: bold;
            font-size: 16pt;
        }

        .table-container {
            margin: 25px 0;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 11pt;
        }

        th {
            background: #1e3c72;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: bold;
        }

        td {
            padding: 10px 12px;
            border-bottom: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background: #f8f9fa;
        }

        .tech-stack {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin: 20px 0;
        }

        .tech-item {
            background: #e8f4f8;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            border: 2px solid #1e3c72;
        }

        .tech-item-title {
            font-weight: bold;
            color: #1e3c72;
            margin-bottom: 5px;
        }

        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin: 25px 0;
        }

        .metric-card {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
        }

        .metric-number {
            font-size: 36px;
            font-weight: bold;
            display: block;
            margin-bottom: 10px;
        }

        .metric-label {
            font-size: 14px;
            opacity: 0.9;
        }

        .kpi-section {
            background: #fff;
            padding: 25px;
            border: 2px solid #1e3c72;
            border-radius: 10px;
            margin: 25px 0;
        }

        .kpi-title {
            color: #1e3c72;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .kpi-row {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 15px;
            margin: 10px 0;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
        }

        .kpi-label {
            font-weight: 600;
            color: #2a5298;
        }

        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 2px solid #1e3c72;
            text-align: center;
            font-size: 10pt;
            color: #666;
        }

        .print-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #1e3c72;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(30,60,114,0.4);
            z-index: 1000;
        }

        .print-btn:hover {
            background: #2a5298;
        }

        @media print {
            body {
                background: white;
            }
            .page {
                box-shadow: none;
                margin: 0;
                padding: 0;
            }
            .print-btn {
                display: none;
            }
        }

        .objective-section {
            background: #f8f9fa;
            padding: 20px;
            margin: 20px 0;
            border-left: 5px solid #2a5298;
            border-radius: 5px;
        }

        .code-block {
            background: #f4f4f4;
            padding: 15px;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            font-size: 11pt;
            margin: 15px 0;
            border-left: 3px solid #1e3c72;
        }
    </style>
</head>
<body>
<!-- PÁGINA DE CAPA -->
<div class="page cover-page">
    <div class="cover-logo">📦</div>
    <div class="cover-title">GESTIN</div>
    <div class="cover-subtitle">Sistema de Gestão de Estoque e Controle de Equipamentos de TI</div>
    <div style="margin-top: 80px;">
        <div class="cover-institution">Secretaria Municipal de Ciência, Tecnologia e Inovação</div>
        <div class="cover-institution" style="font-size: 16px; margin-top: 10px;">Prefeitura Municipal de Cabedelo - PB</div>
        <div class="cover-date">Versão 0.0.2 | Novembro de 2025</div>
    </div>
</div>

<!-- PÁGINA 1: VISÃO GERAL -->
<div class="page">
    <div class="header">
        <div class="header-title">GESTIN - Documentação Técnica</div>
        <div class="header-subtitle">Sistema de Gestão de Estoque</div>
    </div>

    <h1>1. Visão Geral do Sistema</h1>

    <div class="section">
        <h2>1.1. Apresentação</h2>
        <p>
            O GESTIN (Gestão de Estoque e Inventário) é um sistema web desenvolvido para automatizar e modernizar o controle de entrada e saída de equipamentos de Tecnologia da Informação da Prefeitura Municipal de Cabedelo. A solução foi projetada para substituir processos manuais baseados em planilhas, proporcionando maior confiabilidade, rastreabilidade e eficiência na gestão do almoxarifado municipal.
        </p>

        <h2>1.2. Objetivo do Sistema</h2>
        <p>
            Desenvolver um software robusto e intuitivo para controle completo de entrada e saída de equipamentos de TI, permitindo gestão eficiente de produtos, fornecedores, movimentações e inventários, com total rastreabilidade e conformidade com requisitos de auditoria pública.
        </p>

        <div class="info-box">
            <div class="info-box-title">🎯 Problema Resolvido</div>
            <p>
                Antes do GESTIN, o controle de estoque era realizado manualmente através de planilhas e documentos físicos, gerando inconsistências, perda de informações, dificuldade de rastreamento e ausência de dados consolidados para tomada de decisão.
            </p>
        </div>

        <h2>1.3. Público-Alvo</h2>
        <ul class="feature-list">
            <li><strong>Almoxarifes:</strong> Responsáveis pelo controle diário de entradas e saídas</li>
            <li><strong>Administrativo:</strong> Gestores que necessitam de relatórios e visão estratégica</li>
            <li><strong>Servidores Públicos:</strong> Solicitantes de materiais e equipamentos</li>
            <li><strong>Auditoria:</strong> Acesso aos logs e histórico completo de movimentações</li>
        </ul>
    </div>

    <div class="footer">
        GESTIN - Sistema de Gestão de Estoque | Prefeitura de Cabedelo | Página 1
    </div>
</div>

<!-- PÁGINA 2: OBJETIVOS E INDICADORES -->
<div class="page">
    <div class="header">
        <div class="header-title">GESTIN - Documentação Técnica</div>
        <div class="header-subtitle">Objetivos e Indicadores</div>
    </div>

    <h1>2. Objetivos Táticos e KPIs</h1>

    <div class="section">
        <h2>2.1. Objetivo Tático Principal</h2>
        <div class="objective-section">
            <h3>Desenvolver software para controle de entrada e saída de equipamentos de TI (GESTIN)</h3>
            <p style="margin-top: 10px;">
                Criar sistema completo de gestão de almoxarifado com foco em equipamentos de tecnologia, permitindo rastreabilidade total, controle de inventário e geração de relatórios gerenciais.
            </p>
        </div>

        <h2>2.2. Resultados-Chave (KR) e Indicadores (KPI)</h2>

        <div class="kpi-section">
            <div class="kpi-title">KR 1: Elaboração da minuta de proposição</div>
            <div class="kpi-row">
                <div><span class="kpi-label">KPI:</span> Minuta elaborada</div>
                <div><span class="kpi-label">Unidade:</span> nº</div>
                <div><span class="kpi-label">Meta Q4/2025:</span> 1</div>
            </div>
            <p style="margin-top: 10px; font-size: 11pt;">
                Documentação técnica completa do sistema, incluindo especificações funcionais, arquitetura e manual de uso.
            </p>
        </div>

        <div class="kpi-section">
            <div class="kpi-title">KR 2: Análise de usuários capacitados</div>
            <div class="kpi-row">
                <div><span class="kpi-label">KPI:</span> Usuários capacitados</div>
                <div><span class="kpi-label">Unidade:</span> nº</div>
                <div><span class="kpi-label">Meta Q4/2025:</span> X</div>
            </div>
            <p style="margin-top: 10px; font-size: 11pt;">
                Treinamento de servidores para utilização plena do sistema, garantindo adoção e uso correto das funcionalidades.
            </p>
        </div>

        <div class="kpi-section">
            <div class="kpi-title">KR 3: Teste e Validação</div>
            <div class="kpi-row">
                <div><span class="kpi-label">KPI:</span> Teste de funcionalidades</div>
                <div><span class="kpi-label">Unidade:</span> %</div>
                <div><span class="kpi-label">Meta Q4/2025:</span> 100%</div>
            </div>
            <p style="margin-top: 10px; font-size: 11pt;">
                Validação completa de todas as funcionalidades com testes de aceitação e casos de uso reais.
            </p>
        </div>

        <div class="kpi-section">
            <div class="kpi-title">KR 4: Capacitação de usuários</div>
            <div class="kpi-row">
                <div><span class="kpi-label">KPI:</span> Capacitações realizadas</div>
                <div><span class="kpi-label">Unidade:</span> nº</div>
                <div><span class="kpi-label">Meta Q4/2025:</span> 1</div>
            </div>
            <p style="margin-top: 10px; font-size: 11pt;">
                Treinamento prático com os usuários finais, incluindo almoxarifes e administrativo.
            </p>
        </div>
    </div>

    <div class="footer">
        GESTIN - Sistema de Gestão de Estoque | Prefeitura de Cabedelo | Página 2
    </div>
</div>

<!-- PÁGINA 3: ARQUITETURA E TECNOLOGIAS -->
<div class="page">
    <div class="header">
        <div class="header-title">GESTIN - Documentação Técnica</div>
        <div class="header-subtitle">Arquitetura e Tecnologias</div>
    </div>

    <h1>3. Arquitetura e Stack Tecnológica</h1>

    <div class="section">
        <h2>3.1. Arquitetura do Sistema</h2>
        <p>
            O GESTIN foi desenvolvido utilizando o padrão arquitetural MVC (Model-View-Controller), proporcionando separação clara de responsabilidades, facilidade de manutenção e escalabilidade.
        </p>

        <div class="info-box">
            <div class="info-box-title">🏗️ Camadas da Arquitetura</div>
            <ul class="feature-list" style="margin-top: 15px;">
                <li><strong>Model:</strong> Eloquent ORM para manipulação de dados e regras de negócio</li>
                <li><strong>View:</strong> Blade Templates com Tailwind CSS para interface responsiva</li>
                <li><strong>Controller:</strong> Lógica de aplicação e orquestração de requisições</li>
                <li><strong>Middleware:</strong> Autenticação, autorização e logs de auditoria</li>
            </ul>
        </div>

        <h2>3.2. Tecnologias Utilizadas</h2>

        <div class="tech-stack">
            <div class="tech-item">
                <div class="tech-item-title">Laravel 11</div>
                <div>Framework PHP</div>
            </div>
            <div class="tech-item">
                <div class="tech-item-title">PHP 8.2+</div>
                <div>Linguagem Backend</div>
            </div>
            <div class="tech-item">
                <div class="tech-item-title">MySQL</div>
                <div>Banco de Dados</div>
            </div>
            <div class="tech-item">
                <div class="tech-item-title">Blade Templates</div>
                <div>Engine de Views</div>
            </div>
            <div class="tech-item">
                <div class="tech-item-title">Tailwind CSS</div>
                <div>Framework CSS</div>
            </div>
            <div class="tech-item">
                <div class="tech-item-title">Vite</div>
                <div>Build Tool</div>
            </div>
        </div>

        <h2>3.3. Requisitos do Sistema</h2>

        <h3>Servidor</h3>
        <ul class="feature-list">
            <li>PHP 8.2 ou superior</li>
            <li>Composer para gerenciamento de dependências</li>
            <li>MySQL 8.0 ou superior / PostgreSQL 13+</li>
            <li>Servidor web Apache ou Nginx</li>
        </ul>

        <h3>Cliente (Navegador)</h3>
        <ul class="feature-list">
            <li>Navegadores modernos (Chrome, Firefox, Edge, Safari)</li>
            <li>JavaScript habilitado</li>
            <li>Resolução mínima de 1280x720</li>
        </ul>
    </div>

    <div class="footer">
        GESTIN - Sistema de Gestão de Estoque | Prefeitura de Cabedelo | Página 3
    </div>
</div>

<!-- PÁGINA 4: FUNCIONALIDADES -->
<div class="page">
    <div class="header">
        <div class="header-title">GESTIN - Documentação Técnica</div>
        <div class="header-subtitle">Funcionalidades do Sistema</div>
    </div>

    <h1>4. Módulos e Funcionalidades</h1>

    <div class="section">
        <h2>4.1. Gestão de Produtos</h2>
        <ul class="feature-list">
            <li><strong>Cadastro completo:</strong> Nome, descrição, código único, categoria e unidade de medida</li>
            <li><strong>Controle de estoque:</strong> Quantidade disponível atualizada automaticamente</li>
            <li><strong>Categorização:</strong> Organização por categorias customizáveis</li>
            <li><strong>Busca e filtros:</strong> Localização rápida de produtos</li>
            <li><strong>Histórico:</strong> Rastreamento completo de movimentações</li>
        </ul>

        <h2>4.2. Controle de Entradas</h2>
        <ul class="feature-list">
            <li><strong>Registro de compras:</strong> Nota fiscal, fornecedor, data e responsável</li>
            <li><strong>Múltiplos produtos:</strong> Entrada de diversos itens em uma única operação</li>
            <li><strong>Validação automática:</strong> Verificação de dados e incremento de estoque</li>
            <li><strong>Anexo de documentos:</strong> Upload de notas fiscais e comprovantes</li>
            <li><strong>Auditoria completa:</strong> Registro automático de todas as ações</li>
        </ul>

        <h2>4.3. Controle de Saídas</h2>
        <ul class="feature-list">
            <li><strong>Requisição de materiais:</strong> Solicitação por servidor responsável</li>
            <li><strong>Operador identificado:</strong> Servidor que recebe o material</li>
            <li><strong>Justificativa obrigatória:</strong> Motivo da retirada documentado</li>
            <li><strong>Devolução de materiais:</strong> Processo de retorno ao estoque</li>
            <li><strong>Decremento automático:</strong> Atualização instantânea do estoque</li>
        </ul>

        <h2>4.4. Gestão de Fornecedores</h2>
        <ul class="feature-list">
            <li><strong>Dados completos:</strong> CNPJ, razão social, contatos e endereço</li>
            <li><strong>Histórico de compras:</strong> Todas as entradas relacionadas</li>
            <li><strong>Avaliação:</strong> Controle de qualidade e pontualidade</li>
            <li><strong>Status ativo/inativo:</strong> Gestão de fornecedores ativos</li>
        </ul>

        <h2>4.5. Sistema de Inventários</h2>
        <ul class="feature-list">
            <li><strong>Contagem física:</strong> Registro de inventários periódicos</li>
            <li><strong>Ajuste de estoque:</strong> Correção de divergências</li>
            <li><strong>Relatório de diferenças:</strong> Identificação de perdas e ganhos</li>
            <li><strong>Histórico de inventários:</strong> Consulta de contagens anteriores</li>
        </ul>
    </div>

    <div class="footer">
        GESTIN - Sistema de Gestão de Estoque | Prefeitura de Cabedelo | Página 4
    </div>
</div>

<!-- PÁGINA 5: SEGURANÇA E AUDITORIA -->
<div class="page">
    <div class="header">
        <div class="header-title">GESTIN - Documentação Técnica</div>
        <div class="header-subtitle">Segurança e Auditoria</div>
    </div>

    <h1>5. Segurança e Controle de Acesso</h1>

    <div class="section">
        <h2>5.1. Autenticação</h2>
        <p>
            Sistema de autenticação robusto implementado com Laravel Breeze, garantindo segurança no acesso ao sistema.
        </p>
        <ul class="feature-list">
            <li><strong>Hash de senhas:</strong> Bcrypt para criptografia de senhas</li>
            <li><strong>Recuperação de senha:</strong> Processo seguro via e-mail</li>
            <li><strong>Sessões seguras:</strong> Tokens CSRF e proteção contra ataques</li>
            <li><strong>Logout automático:</strong> Inatividade prolongada desconecta usuário</li>
        </ul>

        <h2>5.2. Sistema de Permissões</h2>
        <p>
            Controle granular de acesso baseado em roles (papéis) e permissões específicas.
        </p>

        <div class="table-container">
            <table>
                <thead>
                <tr>
                    <th>Role</th>
                    <th>Permissões</th>
                    <th>Descrição</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><strong>Almoxarife</strong></td>
                    <td>Entradas, Saídas, Produtos, Inventários</td>
                    <td>Controle operacional completo do estoque</td>
                </tr>
                <tr>
                    <td><strong>Administrativo</strong></td>
                    <td>Todas as permissões + Usuários + Relatórios</td>
                    <td>Gestão completa e acesso a todos os módulos</td>
                </tr>
                <tr>
                    <td><strong>Servidor</strong></td>
                    <td>Visualização, Solicitações</td>
                    <td>Consulta de estoque e requisição de materiais</td>
                </tr>
                </tbody>
            </table>
        </div>

        <h2>5.3. Sistema de Auditoria</h2>
        <p>
            Rastreabilidade completa de todas as operações realizadas no sistema, garantindo conformidade com normas de auditoria pública.
        </p>

        <ul class="feature-list">
            <li><strong>Log de ações:</strong> Registro de todas as operações (criar, editar, excluir)</li>
            <li><strong>Histórico de alterações:</strong> Before/After de cada modificação</li>
            <li><strong>Identificação de usuário:</strong> Quem realizou cada ação</li>
            <li><strong>Timestamp completo:</strong> Data e hora exatas de cada operação</li>
            <li><strong>IP e User Agent:</strong> Rastreamento de origem das ações</li>
            <li><strong>Imutabilidade:</strong> Logs não podem ser alterados ou excluídos</li>
        </ul>

        <div class="info-box">
            <div class="info-box-title">🔒 Conformidade Legal</div>
            <p>
                O sistema atende aos requisitos de auditoria pública, mantendo registros completos e inalteráveis de todas as movimentações, possibilitando rastreamento completo para fiscalização e prestação de contas.
            </p>
        </div>
    </div>

    <div class="footer">
        GESTIN - Sistema de Gestão de Estoque | Prefeitura de Cabedelo | Página 5
    </div>
</div>

<!-- PÁGINA 6: FLUXOS DE TRABALHO -->
<div class="page">
    <div class="header">
        <div class="header-title">GESTIN - Documentação Técnica</div>
        <div class="header-subtitle">Fluxos de Trabalho</div>
    </div>

    <h1>6. Processos e Fluxos Operacionais</h1>

    <div class="section">
        <h2>6.1. Fluxo de Entrada de Materiais</h2>

        <div class="info-box">
            <div class="info-box-title">Etapa 1: Recebimento</div>
            <p>
                Almoxarife acessa o módulo de entradas e registra o recebimento de materiais, informando fornecedor, nota fiscal e data de entrada.
            </p>
        </div>

        <div class="info-box">
            <div class="info-box-title">Etapa 2: Seleção de Produtos</div>
            <p>
                Sistema permite adicionar múltiplos produtos em uma única entrada, especificando quantidades, lotes e valores unitários.
            </p>
        </div>

        <div class="info-box">
            <div class="info-box-title">Etapa 3: Validação</div>
            <p>
                O sistema valida os dados inseridos, verifica se os produtos existem no cadastro e calcula automaticamente os totais.
            </p>
        </div>

        <div class="info-box">
            <div class="info-box-title">Etapa 4: Confirmação</div>
            <p>
                Ao confirmar, o sistema incrementa automaticamente o estoque de todos os produtos, registra a entrada e gera log de auditoria.
            </p>
        </div>

        <h2>6.2. Fluxo de Saída de Materiais</h2>

        <div class="info-box">
            <div class="info-box-title">Etapa 1: Requisição</div>
            <p>
                Servidor solicita materiais através de chamado ou diretamente ao almoxarife, especificando itens necessários e justificativa.
            </p>
        </div>

        <div class="info-box">
            <div class="info-box-title">Etapa 2: Autorização</div>
            <p>
                Almoxarife verifica disponibilidade em estoque, valida a justificativa e autoriza a retirada dos materiais solicitados.
            </p>
        </div>

        <div class="info-box">
            <div class="info-box-title">Etapa 3: Registro da Saída</div>
            <p>
                Sistema registra a saída com identificação do servidor responsável, produtos, quantidades e motivo da retirada.
            </p>
        </div>

        <div class="info-box">
            <div class="info-box-title">Etapa 4: Atualização Automática</div>
            <p>
                O estoque é decrementado automaticamente, gerando histórico completo e notificação caso algum produto atinja nível crítico.
            </p>
        </div>

        <h2>6.3. Fluxo de Inventário</h2>

        <div class="info-box">
            <div class="info-box-title">Etapa 1: Programação</div>
            <p>
                Gestor programa inventário periódico (mensal, trimestral ou anual) e define produtos a serem inventariados.
            </p>
        </div>

        <div class="info-box">
            <div class="info-box-title">Etapa 2: Contagem Física</div>
            <p>
                Equipe realiza contagem física dos itens e registra no sistema as quantidades encontradas.
            </p>
        </div>

        <div class="info-box">
            <div class="info-box-title">Etapa 3: Comparação</div>
            <p>
                Sistema compara estoque físico com estoque registrado, identificando divergências positivas ou negativas.
            </p>
        </div>

        <div class="info-box">
            <div class="info-box-title">Etapa 4: Ajuste</div>
            <p>
                Após análise das divergências, sistema permite ajuste do estoque com justificativa obrigatória e registro em auditoria.
            </p>
        </div>
    </div>

    <div class="footer">
        GESTIN - Sistema de Gestão de Estoque | Prefeitura de Cabedelo | Página 6
    </div>
</div>

<!-- PÁGINA 7: INSTALAÇÃO E CONFIGURAÇÃO -->
<div class="page">
    <div class="header">
        <div class="header-title">GESTIN - Documentação Técnica</div>
        <div class="header-subtitle">Instalação e Configuração</div>
    </div>

    <h1>7. Guia de Instalação</h1>

    <div class="section">
        <h2>7.1. Requisitos Prévios</h2>
        <p>Antes de iniciar a instalação, certifique-se de ter os seguintes componentes instalados:</p>

        <ul class="feature-list">
            <li>PHP 8.2 ou superior com extensões: OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON</li>
            <li>Composer (gerenciador de dependências PHP)</li>
            <li>MySQL 8.0+ ou PostgreSQL 13+</li>
            <li>Node.js 18+ e NPM (para compilação de assets)</li>
            <li>Servidor web Apache ou Nginx</li>
        </ul>

        <h2>7.2. Passos de Instalação</h2>

        <h3>Passo 1: Clonar o Repositório</h3>
        <div class="code-block">
            git clone https://github.com/Alessandro-Franca01/sistema-estoque.git<br>
            cd sistema-estoque
        </div>

        <h3>Passo 2: Instalar Dependências PHP</h3>
        <div class="code-block">
            composer install
        </div>

        <h3>Passo 3: Configurar Ambiente</h3>
        <div class="code-block">
            cp .env.example .env<br>
            php artisan key:generate
        </div>

        <h3>Passo 4: Configurar Banco de Dados</h3>
        <p>Edite o arquivo <code>.env</code> com as credenciais do seu banco:</p>
        <div class="code-block">
            DB_CONNECTION=mysql<br>
            DB_HOST=127.0.0.1<br>
            DB_PORT=3306<br>
            DB_DATABASE=gestin<br>
            DB_USERNAME=seu_usuario<br>
            DB_PASSWORD=sua_senha
        </div>

        <h3>Passo 5: Executar Migrations</h3>
        <div class="code-block">
            php artisan migrate
        </div>

        <h3>Passo 6: Popular Banco (Opcional)</h3>
        <div class="code-block">
            php artisan db:seed
        </div>

        <h3>Passo 7: Compilar Assets</h3>
        <div class="code-block">
            npm install<br>
            npm run build
        </div>

        <h3>Passo 8: Iniciar Servidor</h3>
        <div class="code-block">
            php artisan serve
        </div>

        <div class="info-box">
            <div class="info-box-title">✅ Sistema Pronto</div>
            <p>
                O sistema estará disponível em <strong>http://127.0.0.1:8000</strong>
            </p>
        </div>
    </div>

    <div class="footer">
        GESTIN - Sistema de Gestão de Estoque | Prefeitura de Cabedelo | Página 7
    </div>
</div>

<!-- PÁGINA 8: BENEFÍCIOS E RESULTADOS -->
<div class="page">
    <div class="header">
        <div class="header-title">GESTIN - Documentação Técnica</div>
        <div class="header-subtitle">Benefícios e Resultados Esperados</div>
    </div>

    <h1>8. Benefícios e Impactos</h1>

    <div class="section">
        <h2>8.1. Benefícios Operacionais</h2>

        <div class="metrics-grid">
            <div class="metric-card">
                <span class="metric-number">100%</span>
                <span class="metric-label">Rastreabilidade de Movimentações</span>
            </div>
            <div class="metric-card">
                <span class="metric-number">80%</span>
                <span class="metric-label">Redução de Erros Manuais</span>
            </div>
            <div class="metric-card">
                <span class="metric-number">90%</span>
                <span class="metric-label">Automatização de Processos</span>
            </div>
        </div>

        <ul class="feature-list">
            <li><strong>Eliminação de planilhas manuais:</strong> Todo controle centralizado no sistema</li>
            <li><strong>Redução de tempo:</strong> Processos que levavam horas agora são instantâneos</li>
            <li><strong>Minimização de perdas:</strong> Controle rigoroso previne extravios e desperdícios</li>
            <li><strong>Agilidade nas operações:</strong> Busca rápida e processos otimizados</li>
            <li><strong>Disponibilidade 24/7:</strong> Acesso ao sistema a qualquer momento</li>
        </ul>

        <h2>8.2. Benefícios Estratégicos</h2>

        <ul class="feature-list">
            <li><strong>Tomada de decisão baseada em dados:</strong> Relatórios precisos e atualizados</li>
            <li><strong>Controle orçamentário:</strong> Visão clara de gastos com materiais</li>
            <li><strong>Planejamento de compras:</strong> Identificação de padrões de consumo</li>
            <li><strong>Conformidade legal:</strong> Atendimento a requisitos de auditoria</li>
            <li><strong>Transparência:</strong> Histórico completo e acessível de todas as operações</li>
        </ul>

        <h2>8.3. Benefícios para Auditoria</h2>

        <ul class="feature-list">
            <li><strong>Logs inalteráveis:</strong> Registros imutáveis de todas as ações</li>
            <li><strong>Rastreamento completo:</strong> Identificação de responsáveis por cada operação</li>
            <li><strong>Relatórios de conformidade:</strong> Documentação pronta para fiscalização</li>
            <li><strong>Histórico de alterações:</strong> Before/After de todas as modificações</li>
            <li><strong>Exportação de dados:</strong> Geração de relatórios em diversos formatos</li>
        </ul>

        <h2>8.4. Resultados Esperados</h2>

        <div class="info-box">
            <div class="info-box-title">📈 Metas de Curto Prazo (6 meses)</div>
            <ul class="feature-list" style="margin-top: 10px;">
                <li>Migração completa do controle manual para digital</li>
                <li>Capacitação de 100% dos usuários</li>
                <li>Redução de 50% no tempo de processos operacionais</li>
                <li>Zero divergências não justificadas em inventários</li>
            </ul>
        </div>

        <div class="info-box">
            <div class="info-box-title">🎯 Metas de Médio Prazo (1 ano)</div>
            <ul class="feature-list" style="margin-top: 10px;">
                <li>Redução de 30% nos custos operacionais do almoxarifado</li>
                <li>Implementação de análises preditivas de consumo</li>
                <li>Integração com sistemas de compras e financeiro</li>
                <li>Expansão para outros departamentos da prefeitura</li>
            </ul>
        </div>
    </div>

    <div class="footer">
        GESTIN - Sistema de Gestão de Estoque | Prefeitura de Cabedelo | Página 8
    </div>
</div>

<!-- PÁGINA 9: ESTRUTURA DO BANCO DE DADOS -->
<div class="page">
    <div class="header">
        <div class="header-title">GESTIN - Documentação Técnica</div>
        <div class="header-subtitle">Estrutura de Dados</div>
    </div>

    <h1>9. Modelo de Dados</h1>

    <div class="section">
        <h2>9.1. Principais Entidades</h2>

        <h3>Tabela: users</h3>
        <p>Armazena dados dos usuários do sistema</p>
        <div class="table-container">
            <table>
                <thead>
                <tr>
                    <th>Campo</th>
                    <th>Tipo</th>
                    <th>Descrição</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>id</td>
                    <td>BIGINT</td>
                    <td>Identificador único</td>
                </tr>
                <tr>
                    <td>name</td>
                    <td>VARCHAR</td>
                    <td>Nome completo</td>
                </tr>
                <tr>
                    <td>email</td>
                    <td>VARCHAR</td>
                    <td>E-mail (único)</td>
                </tr>
                <tr>
                    <td>password</td>
                    <td>VARCHAR</td>
                    <td>Senha criptografada</td>
                </tr>
                <tr>
                    <td>role</td>
                    <td>VARCHAR</td>
                    <td>Papel (almoxarife/administrativo)</td>
                </tr>
                </tbody>
            </table>
        </div>

        <h3>Tabela: products</h3>
        <p>Cadastro de produtos e equipamentos</p>
        <div class="table-container">
            <table>
                <thead>
                <tr>
                    <th>Campo</th>
                    <th>Tipo</th>
                    <th>Descrição</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>id</td>
                    <td>BIGINT</td>
                    <td>Identificador único</td>
                </tr>
                <tr>
                    <td>code</td>
                    <td>VARCHAR</td>
                    <td>Código único do produto</td>
                </tr>
                <tr>
                    <td>name</td>
                    <td>VARCHAR</td>
                    <td>Nome do produto</td>
                </tr>
                <tr>
                    <td>description</td>
                    <td>TEXT</td>
                    <td>Descrição detalhada</td>
                </tr>
                <tr>
                    <td>quantity</td>
                    <td>INTEGER</td>
                    <td>Quantidade em estoque</td>
                </tr>
                <tr>
                    <td>category_id</td>
                    <td>BIGINT</td>
                    <td>Categoria do produto</td>
                </tr>
                <tr>
                    <td>unit</td>
                    <td>VARCHAR</td>
                    <td>Unidade de medida</td>
                </tr>
                </tbody>
            </table>
        </div>

        <h3>Tabela: entries (Entradas)</h3>
        <p>Registra entradas de materiais no estoque</p>
        <div class="table-container">
            <table>
                <thead>
                <tr>
                    <th>Campo</th>
                    <th>Tipo</th>
                    <th>Descrição</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>id</td>
                    <td>BIGINT</td>
                    <td>Identificador único</td>
                </tr>
                <tr>
                    <td>supplier_id</td>
                    <td>BIGINT</td>
                    <td>Fornecedor</td>
                </tr>
                <tr>
                    <td>invoice_number</td>
                    <td>VARCHAR</td>
                    <td>Número da nota fiscal</td>
                </tr>
                <tr>
                    <td>entry_date</td>
                    <td>DATE</td>
                    <td>Data de entrada</td>
                </tr>
                <tr>
                    <td>user_id</td>
                    <td>BIGINT</td>
                    <td>Usuário responsável</td>
                </tr>
                </tbody>
            </table>
        </div>

        <h3>Tabela: outputs (Saídas)</h3>
        <p>Registra saídas de materiais do estoque</p>
        <div class="table-container">
            <table>
                <thead>
                <tr>
                    <th>Campo</th>
                    <th>Tipo</th>
                    <th>Descrição</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>id</td>
                    <td>BIGINT</td>
                    <td>Identificador único</td>
                </tr>
                <tr>
                    <td>operator_id</td>
                    <td>BIGINT</td>
                    <td>Servidor que recebeu</td>
                </tr>
                <tr>
                    <td>output_date</td>
                    <td>DATE</td>
                    <td>Data de saída</td>
                </tr>
                <tr>
                    <td>reason</td>
                    <td>TEXT</td>
                    <td>Justificativa</td>
                </tr>
                <tr>
                    <td>user_id</td>
                    <td>BIGINT</td>
                    <td>Usuário que autorizou</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="footer">
        GESTIN - Sistema de Gestão de Estoque | Prefeitura de Cabedelo | Página 9
    </div>
</div>

<!-- PÁGINA 10: SUPORTE E MANUTENÇÃO -->
<div class="page">
    <div class="header">
        <div class="header-title">GESTIN - Documentação Técnica</div>
        <div class="header-subtitle">Suporte e Manutenção</div>
    </div>

    <h1>10. Suporte Técnico e Manutenção</h1>

    <div class="section">
        <h2>10.1. Canais de Suporte</h2>

        <div class="info-box">
            <div class="info-box-title">📧 Contato Técnico</div>
            <ul class="feature-list" style="margin-top: 10px;">
                <li><strong>Desenvolvedor:</strong> Alessandro França</li>
                <li><strong>GitHub:</strong> github.com/Alessandro-Franca01</li>
                <li><strong>E-mail:</strong> Secretaria de Tecnologia de Cabedelo</li>
                <li><strong>Horário:</strong> Segunda a Sexta, 8h às 17h</li>
            </ul>
        </div>

        <h2>10.2. Plano de Manutenção</h2>

        <h3>Manutenção Corretiva</h3>
        <ul class="feature-list">
            <li>Correção de bugs reportados</li>
            <li>Resolução de problemas de performance</li>
            <li>Ajustes de segurança</li>
            <li>Tempo de resposta: até 24h para problemas críticos</li>
        </ul>

        <h3>Manutenção Preventiva</h3>
        <ul class="feature-list">
            <li>Backup automático diário do banco de dados</li>
            <li>Atualização de dependências e bibliotecas</li>
            <li>Monitoramento de performance e disponibilidade</li>
            <li>Testes periódicos de funcionalidades</li>
        </ul>

        <h3>Manutenção Evolutiva</h3>
        <ul class="feature-list">
            <li>Implementação de novas funcionalidades</li>
            <li>Melhorias de interface e usabilidade</li>
            <li>Otimizações de performance</li>
            <li>Integração com novos sistemas</li>
        </ul>

        <h2>10.3. Atualizações do Sistema</h2>

        <div class="info-box">
            <div class="info-box-title">🔄 Versionamento</div>
            <p style="margin-top: 10px;">
                <strong>Versão Atual:</strong> 0.0.2<br><br>
                O sistema segue o padrão de versionamento semântico (MAJOR.MINOR.PATCH):
            </p>
            <ul class="feature-list" style="margin-top: 10px;">
                <li><strong>MAJOR:</strong> Mudanças incompatíveis na API</li>
                <li><strong>MINOR:</strong> Novas funcionalidades compatíveis</li>
                <li><strong>PATCH:</strong> Correções de bugs</li>
            </ul>
        </div>

        <h2>10.4. Backup e Recuperação</h2>

        <h3>Estratégia de Backup</h3>
        <ul class="feature-list">
            <li><strong>Backup Diário:</strong> Banco de dados completo</li>
            <li><strong>Backup Semanal:</strong> Arquivos e configurações</li>
            <li><strong>Retenção:</strong> 30 dias de backups incrementais</li>
            <li><strong>Armazenamento:</strong> Local e nuvem (redundância)</li>
        </ul>

        <h3>Procedimento de Recuperação</h3>
        <div class="code-block">
            # Restaurar backup do banco<br>
            mysql -u usuario -p gestin < backup_YYYY-MM-DD.sql<br><br>
            # Limpar cache<br>
            php artisan cache:clear<br>
            php artisan config:clear
        </div>

        <h2>10.5. Troubleshooting Comum</h2>

        <div class="table-container">
            <table>
                <thead>
                <tr>
                    <th>Problema</th>
                    <th>Solução</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Erro ao fazer login</td>
                    <td>Verificar credenciais e limpar cache do navegador</td>
                </tr>
                <tr>
                    <td>Estoque não atualiza</td>
                    <td>Verificar logs de erros e validar migrations</td>
                </tr>
                <tr>
                    <td>Página não carrega</td>
                    <td>Verificar conexão com banco e permissões de arquivo</td>
                </tr>
                <tr>
                    <td>Relatório não gera</td>
                    <td>Verificar permissões de escrita na pasta storage</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="footer">
        GESTIN - Sistema de Gestão de Estoque | Prefeitura de Cabedelo | Página 10
    </div>
</div>

<!-- PÁGINA 11: ROADMAP E EVOLUÇÃO -->
<div class="page">
    <div class="header">
        <div class="header-title">GESTIN - Documentação Técnica</div>
        <div class="header-subtitle">Roadmap e Evolução</div>
    </div>

    <h1>11. Planejamento Futuro</h1>

    <div class="section">
        <h2>11.1. Roadmap de Desenvolvimento</h2>

        <div class="objective-section">
            <h3>Fase 1 - Q4/2025 (Atual)</h3>
            <ul class="feature-list">
                <li>✅ Desenvolvimento do core do sistema</li>
                <li>✅ Módulos de produtos, entradas e saídas</li>
                <li>✅ Sistema de autenticação e permissões</li>
                <li>🔄 Testes e validação com usuários</li>
                <li>🔄 Capacitação da equipe</li>
                <li>🔄 Documentação completa</li>
            </ul>
        </div>

        <div class="objective-section">
            <h3>Fase 2 - Q1/2026</h3>
            <ul class="feature-list">
                <li>📱 Desenvolvimento de aplicativo mobile</li>
                <li>📊 Dashboard com gráficos e indicadores</li>
                <li>🔔 Sistema de notificações por e-mail</li>
                <li>📄 Geração avançada de relatórios (PDF/Excel)</li>
                <li>🔍 Busca avançada com filtros múltiplos</li>
            </ul>
        </div>

        <div class="objective-section">
            <h3>Fase 3 - Q2/2026</h3>
            <ul class="feature-list">
                <li>🤖 Alertas automáticos de estoque mínimo</li>
                <li>📈 Análise preditiva de consumo</li>
                <li>🔗 Integração com sistema de compras</li>
                <li>📸 Leitura de código de barras/QR Code</li>
                <li>💳 Controle de patrimônio integrado</li>
            </ul>
        </div>

        <div class="objective-section">
            <h3>Fase 4 - Q3-Q4/2026</h3>
            <ul class="feature-list">
                <li>☁️ Migração para arquitetura em nuvem</li>
                <li>🔄 API REST para integrações externas</li>
                <li>📊 Business Intelligence (BI) integrado</li>
                <li>🌐 Sistema multi-secretarias</li>
                <li>🤝 Portal do fornecedor</li>
            </ul>
        </div>

        <h2>11.2. Melhorias Planejadas</h2>

        <h3>Interface do Usuário</h3>
        <ul class="feature-list">
            <li>Modo escuro (dark mode)</li>
            <li>Personalização de dashboard</li>
            <li>Atalhos de teclado</li>
            <li>Tour guiado para novos usuários</li>
        </ul>

        <h3>Performance</h3>
        <ul class="feature-list">
            <li>Implementação de cache Redis</li>
            <li>Otimização de queries pesadas</li>
            <li>Lazy loading de imagens</li>
            <li>Compressão de assets</li>
        </ul>

        <h3>Segurança</h3>
        <ul class="feature-list">
            <li>Autenticação de dois fatores (2FA)</li>
            <li>Política de senhas fortes</li>
            <li>Criptografia de dados sensíveis</li>
            <li>Monitoramento de tentativas de invasão</li>
        </ul>
    </div>

    <div class="footer">
        GESTIN - Sistema de Gestão de Estoque | Prefeitura de Cabedelo | Página 11
    </div>
</div>

<!-- PÁGINA 12: CONCLUSÃO -->
<div class="page">
    <div class="header">
        <div class="header-title">GESTIN - Documentação Técnica</div>
        <div class="header-subtitle">Considerações Finais</div>
    </div>

    <h1>12. Conclusão</h1>

    <div class="section">
        <h2>12.1. Resumo Executivo</h2>
        <p>
            O GESTIN representa um marco significativo na modernização dos processos da Secretaria Municipal de Ciência, Tecnologia e Inovação de Cabedelo. Através de uma solução tecnológica robusta e bem estruturada, o sistema elimina gargalos operacionais, reduz erros manuais e proporciona total rastreabilidade das movimentações de estoque.
        </p>

        <p>
            Desenvolvido com tecnologias modernas e seguindo as melhores práticas de desenvolvimento de software, o GESTIN atende não apenas às necessidades operacionais imediatas, mas também está preparado para evolução e expansão futuras.
        </p>

        <h2>12.2. Diferenciais do Sistema</h2>

        <div class="metrics-grid">
            <div class="metric-card">
                <span class="metric-number">🎯</span>
                <span class="metric-label">Foco no Usuário</span>
            </div>
            <div class="metric-card">
                <span class="metric-number">🔒</span>
                <span class="metric-label">Segurança Robusta</span>
            </div>
            <div class="metric-card">
                <span class="metric-number">📈</span>
                <span class="metric-label">Escalabilidade</span>
            </div>
        </div>

        <ul class="feature-list">
            <li><strong>Interface Intuitiva:</strong> Desenvolvida pensando na experiência do usuário final</li>
            <li><strong>Código Aberto:</strong> Disponível no GitHub para transparência e colaboração</li>
            <li><strong>Conformidade Legal:</strong> Atende requisitos de auditoria pública</li>
            <li><strong>Suporte Local:</strong> Desenvolvido e mantido pela própria prefeitura</li>
            <li><strong>Custo Zero:</strong> Sem licenças ou mensalidades de software</li>
        </ul>

        <h2>12.3. Impacto Esperado</h2>

        <div class="info-box">
            <div class="info-box-title">💡 Transformação Digital</div>
            <p style="margin-top: 10px;">
                O GESTIN não é apenas um sistema de controle de estoque, mas um agente de transformação digital na gestão pública municipal. Ao digitalizar processos, gerar dados confiáveis e promover transparência, o sistema contribui para uma administração mais eficiente, responsável e moderna.
            </p>
        </div>

        <h2>12.4. Agradecimentos</h2>

        <div class="info-box">
            <p style="text-align: center; font-size: 13pt; line-height: 1.8;">
                <strong>Agradecemos:</strong><br><br>
                🙏 Ao Senhor pela oportunidade de realizar este trabalho<br>
                🤝 À Secretaria de Tecnologia e Desenvolvimento de Cabedelo<br>
                ❤️ À família pelo apoio incondicional<br>
            </p>
        </div>
    </div>
</div>
