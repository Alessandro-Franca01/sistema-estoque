-- Criação das tabelas para o sistema de gestão de estoque.
-- BY: IAs Gemina / Chagtp

-- Tabela: OrgaoUnidadeGestora
-- Representa as unidades administrativas ou órgãos que podem requisitar ou gerenciar itens.
CREATE TABLE OrgaoUnidadeGestora (
                                     id SERIAL PRIMARY KEY, -- Identificador único auto-incrementável
                                     nome VARCHAR(255) NOT NULL, -- Nome completo do órgão/unidade
                                     sigla VARCHAR(50) UNIQUE NOT NULL, -- Sigla da unidade, deve ser única
                                     responsavel VARCHAR(255), -- Nome do responsável pela unidade (pode ser um texto simples)
                                     localizacao TEXT -- Descrição da localização física da unidade
);

-- Tabela: Usuario
-- Representa os usuários do sistema, com diferentes perfis de acesso.
CREATE TABLE Usuario (
                         id SERIAL PRIMARY KEY, -- Identificador único auto-incrementável
                         nome VARCHAR(255) NOT NULL, -- Nome completo do usuário
                         matricula VARCHAR(100) UNIQUE NOT NULL, -- Matrícula ou identificador único do usuário na organização
                         email VARCHAR(255) UNIQUE NOT NULL, -- Endereço de e-mail, deve ser único
                         perfil VARCHAR(100) NOT NULL -- Perfil de acesso (ex: 'almoxarife', 'requisitante', 'gestor', 'auditor')
);

-- Tabela: Almoxarifado
-- Representa os locais físicos onde os produtos são armazenados.
CREATE TABLE Almoxarifado (
                              id SERIAL PRIMARY KEY, -- Identificador único auto-incrementável
                              nome VARCHAR(255) NOT NULL, -- Nome do almoxarifado (ex: "Almoxarifado Central", "Depósito 1")
                              localizacao TEXT, -- Descrição da localização física do almoxarifado
                              responsavel_id INTEGER, -- Chave estrangeira para o usuário responsável pelo almoxarifado
                              FOREIGN KEY (responsavel_id) REFERENCES Usuario(id)
);

-- Tabela: Produto
-- Representa a definição de um item ou produto que será gerenciado no estoque.
-- Não rastreia itens individualmente, apenas o tipo de produto.
CREATE TABLE Produto (
                         id SERIAL PRIMARY KEY, -- Identificador único auto-incrementável
                         nome VARCHAR(255) NOT NULL, -- Nome do produto (ex: "Caneta Esferográfica Azul")
                         descricao TEXT, -- Descrição detalhada do produto
                         tipo VARCHAR(100) NOT NULL, -- Categoria do produto (ex: 'consumo', 'permanente', 'tecnologico')
                         unidade_medida VARCHAR(50) NOT NULL, -- Unidade de medida (ex: 'unidade', 'caixa', 'pacote')
                         valor_unitario DECIMAL(10, 2) NOT NULL, -- Valor unitário padrão do produto
                         data_validade DATE, -- Data de validade geral do produto (opcional, para produtos perecíveis)
                         patrimoniado BOOLEAN NOT NULL DEFAULT FALSE -- Indica se o produto é um bem patrimonial (TRUE/FALSE)
);

-- Tabela: Fornecedor
-- Representa as empresas ou indivíduos que fornecem os produtos.
CREATE TABLE Fornecedor (
                            id SERIAL PRIMARY KEY, -- Identificador único auto-incrementável
                            razao_social VARCHAR(255) NOT NULL, -- Nome legal ou razão social do fornecedor
                            cnpj VARCHAR(20) UNIQUE NOT NULL, -- CNPJ do fornecedor, deve ser único
                            inscricao_estadual VARCHAR(50), -- Inscrição Estadual do fornecedor (opcional)
                            telefone VARCHAR(50), -- Telefone de contato
                            email VARCHAR(255), -- Endereço de e-mail do fornecedor
                            endereco TEXT -- Endereço completo do fornecedor
);

-- Tabela: Estoque
-- **NOVA TABELA**
-- Representa o saldo atual de cada produto em um almoxarifado específico.
-- É a tabela que armazena a quantidade disponível de cada item.
CREATE TABLE Estoque (
                         id SERIAL PRIMARY KEY, -- Identificador único auto-incrementável
                         produto_id INTEGER NOT NULL, -- Chave estrangeira para o Produto
                         almoxarifado_id INTEGER NOT NULL, -- Chave estrangeira para o Almoxarifado onde o produto está
                         quantidade_atual INTEGER NOT NULL DEFAULT 0 CHECK (quantidade_atual >= 0), -- Quantidade atual em estoque, não pode ser negativa
                         data_ultima_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Data e hora da última atualização do saldo
                         valor_medio_unitario DECIMAL(10, 2), -- Opcional: Valor médio unitário para fins de custo
                         FOREIGN KEY (produto_id) REFERENCES Produto(id),
                         FOREIGN KEY (almoxarifado_id) REFERENCES Almoxarifado(id),
                         UNIQUE (produto_id, almoxarifado_id) -- Garante que cada produto só tem um registro de saldo por almoxarifado
);

-- Tabela: EntradaEstoque
-- Registra as operações de entrada de produtos no estoque.
CREATE TABLE EntradaEstoque (
                                id SERIAL PRIMARY KEY, -- Identificador único auto-incrementável
                                data_entrada TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Data e hora da entrada
                                quantidade INTEGER NOT NULL CHECK (quantidade > 0), -- Quantidade de produtos que entraram
                                valor_total DECIMAL(10, 2) NOT NULL, -- Valor total da entrada (quantidade * valor_unitario)
                                nota_fiscal VARCHAR(100), -- Número da nota fiscal ou documento de entrada
                                fornecedor_id INTEGER NOT NULL, -- Chave estrangeira para o Fornecedor
                                produto_id INTEGER NOT NULL, -- Chave estrangeira para o Produto que entrou
                                responsavel_id INTEGER NOT NULL, -- Chave estrangeira para o Usuário responsável pela entrada
                                almoxarifado_destino_id INTEGER NOT NULL, -- Chave estrangeira para o Almoxarifado onde o produto foi recebido
                                FOREIGN KEY (fornecedor_id) REFERENCES Fornecedor(id),
                                FOREIGN KEY (produto_id) REFERENCES Produto(id),
                                FOREIGN KEY (responsavel_id) REFERENCES Usuario(id),
                                FOREIGN KEY (almoxarifado_destino_id) REFERENCES Almoxarifado(id)
);

-- Tabela: SaidaEstoque
-- Registra as operações de saída de produtos do estoque.
CREATE TABLE SaidaEstoque (
                              id SERIAL PRIMARY KEY, -- Identificador único auto-incrementável
                              data_saida TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Data e hora da saída
                              quantidade INTEGER NOT NULL CHECK (quantidade > 0), -- Quantidade de produtos que saíram
                              destino_id INTEGER NOT NULL, -- Chave estrangeira para a Unidade Gestora que requisitou o produto
                              produto_id INTEGER NOT NULL, -- Chave estrangeira para o Produto que saiu
                              responsavel_id INTEGER NOT NULL, -- Chave estrangeira para o Usuário responsável pela saída
                              finalidade VARCHAR(100) NOT NULL, -- Propósito da saída (ex: 'uso interno', 'descarte', 'transferência')
                              almoxarifado_origem_id INTEGER NOT NULL, -- Chave estrangeira para o Almoxarifado de onde o produto saiu
                              FOREIGN KEY (destino_id) REFERENCES OrgaoUnidadeGestora(id),
                              FOREIGN KEY (produto_id) REFERENCES Produto(id),
                              FOREIGN KEY (responsavel_id) REFERENCES Usuario(id),
                              FOREIGN KEY (almoxarifado_origem_id) REFERENCES Almoxarifado(id)
);

-- Tabela: Inventario
-- Representa o cabeçalho de um processo de inventário (contagem física).
-- Agrupa os itens contados em um evento específico de inventário.
CREATE TABLE Inventario (
                            id SERIAL PRIMARY KEY, -- Identificador único auto-incrementável
                            data DATE NOT NULL, -- Data em que o inventário foi realizado
                            status VARCHAR(50) NOT NULL, -- Status do inventário (ex: 'aberto', 'em andamento', 'fechado')
                            observacoes TEXT, -- Observações gerais sobre o inventário
                            almoxarifado_id INTEGER, -- Chave estrangeira para o Almoxarifado que foi inventariado (opcional, se o inventário for geral)
                            responsavel_id INTEGER NOT NULL, -- Chave estrangeira para o Usuário responsável pelo inventário
                            FOREIGN KEY (almoxarifado_id) REFERENCES Almoxarifado(id),
                            FOREIGN KEY (responsavel_id) REFERENCES Usuario(id)
);

-- Tabela: ItemInventario
-- Detalha cada produto contado dentro de um processo de inventário específico.
CREATE TABLE ItemInventario (
                                id SERIAL PRIMARY KEY, -- Identificador único auto-incrementável
                                inventario_id INTEGER NOT NULL, -- Chave estrangeira para o Inventario ao qual este item pertence
                                produto_id INTEGER NOT NULL, -- Chave estrangeira para o Produto que foi contado
                                quantidade_registrada INTEGER NOT NULL, -- Quantidade esperada do produto no sistema antes da contagem
                                quantidade_fisica INTEGER NOT NULL, -- Quantidade real do produto contada fisicamente
                                diferenca INTEGER NOT NULL, -- Diferença entre a quantidade física e a registrada (física - registrada)
                                observacoes TEXT, -- Observações específicas sobre este item no inventário
                                FOREIGN KEY (inventario_id) REFERENCES Inventario(id),
                                FOREIGN KEY (produto_id) REFERENCES Produto(id)
);

-- Tabela: LogMovimentacao
-- Registra todas as movimentações importantes no estoque para fins de auditoria e rastreabilidade.
CREATE TABLE LogMovimentacao (
                                 id SERIAL PRIMARY KEY, -- Identificador único auto-incrementável
                                 produto_id INTEGER NOT NULL, -- Chave estrangeira para o Produto envolvido na movimentação
                                 acao VARCHAR(100) NOT NULL, -- Tipo de ação (ex: 'entrada', 'saida', 'inventario_ajuste', 'transferencia_origem', 'transferencia_destino')
                                 quantidade INTEGER NOT NULL, -- Quantidade de produtos envolvida na ação
                                 data TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Data e hora da movimentação
                                 usuario_id INTEGER NOT NULL, -- Chave estrangeira para o Usuário que realizou a ação
                                 descricao TEXT, -- Descrição detalhada da movimentação
                                 referencia_transacao_id INTEGER, -- Opcional: ID da transação de origem (EntradaEstoque.id, SaidaEstoque.id, Inventario.id)
                                 FOREIGN KEY (produto_id) REFERENCES Produto(id),
                                 FOREIGN KEY (usuario_id) REFERENCES Usuario(id)
);
