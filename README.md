<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Sobre o Sistema de Estoque

Este é um sistema de gerenciamento de estoque robusto e intuitivo, desenvolvido utilizando o framework Laravel. Ele foi criado para simplificar o controle de produtos, entradas e saídas, e para fornecer uma visão clara do seu inventário. Nosso objetivo é tornar o gerenciamento de estoque uma experiência eficiente e sem complicações.

### Funcionalidades Principais

- **Gerenciamento de Produtos:** Cadastre, edite e visualize detalhes de todos os seus produtos.
- **Controle de Entrada e Saída:** Registre movimentações de estoque com facilidade, mantendo um histórico detalhado.
- **Dashboard Intuitivo:** Obtenha uma visão geral rápida do status do seu estoque.
- **Autenticação de Usuários:** Sistema de login seguro para múltiplos usuários.

## Tecnologias Utilizadas

Este projeto é construído com as seguintes tecnologias:

- **Laravel Framework:** Um framework PHP poderoso para desenvolvimento web.
- **PHP:** A linguagem de programação do lado do servidor.
- **MySQL/PostgreSQL:** Para gerenciamento de banco de dados.
- **HTML, CSS, JavaScript:** Para a interface do usuário.
- **Tailwind CSS:** Um framework CSS para design rápido e responsivo.
- **Vite:** Ferramenta de build de frontend para desenvolvimento rápido.

## Instalação

Para configurar o projeto localmente, siga os passos abaixo:

1. Clone o repositório:
   ```bash
   git clone https://github.com/Alessandro-Franca01/sistema-estoque.git
   cd sistema-de-estoque
   ```
2. Instale as dependências do Composer:
   ```bash
   composer install
   ```
3. Copie o arquivo de ambiente e configure-o:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Configure as informações do seu banco de dados no arquivo `.env` a seguir um exemplo.
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=laravel
   DB_USERNAME=root
   DB_PASSWORD=
   ```
5. Execute as migrações do banco de dados:
   ```bash
   php artisan migrate
   ```
6. (Opcional) Popule o banco de dados com dados de exemplo:
   ```bash
   php artisan db:seed
   ```
7. Instale as dependências do NPM e compile os assets:
   ```bash
   npm install
   npm run dev
   ```
8. Inicie o servidor local:
   ```bash
   php artisan serve
   ```

O sistema estará acessível em `http://127.0.0.1:8000`.

## Contribuição

Contribuições são bem-vindas! Se você deseja contribuir, por favor, abra uma issue ou envie um pull request.

## Licença

Este projeto está licenciado sob a [Licença MIT](https://opensource.org/licenses/MIT).

## 📌 Versão

Versão 1.0.0

## ✒️ Autor & Mantedor

**Alessandro França** - *Desenvolvedor Full Stack* - [Github](https://github.com/Alessandro-Franca01)

## 🎁 Agradecimentos
* Agradeço ao Senhor pela oportunidade de mostrar meu trabalho 🙏
* Agradeço a Secretaria de Tecnologia de Desenvolvimento de Cabedelo 🫂;
* Agradeço a minha esposa por todo o apoio ❤️

