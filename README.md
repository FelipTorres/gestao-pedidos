# 🛍️ Ecommerce ERP

Sistema de **E-commerce com funcionalidades de ERP**, desenvolvido em **Laravel 10+**.  
Permite o **gerenciamento de produtos, variações, estoques, cupons de desconto e pedidos**, além de um **fluxo completo de carrinho de compras e finalização de pedidos** com **cálculo de frete** e **aplicação de cupons**.

---

## 📦 Funcionalidades Principais

### 🧱 Gestão de Produtos
- Cadastro, edição, exclusão e listagem de produtos.
- Suporte a variações (ex: tamanho, cor).
- Controle de estoque por produto e por variação.

### 🎟️ Gestão de Cupons
- CRUD completo de cupons de desconto.
- Validação de data de validade e valor mínimo de compra.

### 🛒 Carrinho de Compras
- Adição e remoção de produtos e variações.
- Cálculo automático de subtotal, aplicação de cupons e frete.

### 📑 Pedidos
- Finalização com endereço de entrega.
- Validação automática de CEP via **API ViaCEP**.
- Atualização de estoque ao finalizar o pedido.
- Listagem e visualização de pedidos e seus detalhes.

### 🚚 Frete
Regras de frete aplicadas com base no subtotal:
| Faixa de valor | Frete |
|-----------------|--------|
| R$52,00 – R$166,59 | R$15,00 |
| Acima de R$200,00 | **Grátis** |
| Outros valores | R$20,00 |

---

## 🗂️ Estrutura do Projeto

| Diretório | Descrição |
|------------|------------|
| **app/Models** | Modelos Eloquent (Product, ProductVariation, Stock, Coupon, Order, OrderItems, User) |
| **app/Http/Controllers** | Controladores responsáveis pela lógica de cada recurso |
| **app/Http/Requests** | Classes de validação customizadas |
| **resources/views** | Views Blade organizadas por domínio (`products`, `orders`, `coupons`, `cart`) |
| **routes/web.php** | Rotas agrupadas por recurso |
| **database/migrations** | Estrutura e versionamento do banco de dados |
| **docker/** / **docker-compose.yml** | Arquivos de configuração Docker (opcional) |
| **vite.config.js** | Configuração de build de assets |

---

## ⚙️ CI/CD e Deploy

Este projeto possui uma **pipeline de integração contínua (CI)** configurada com **GitHub Actions**,  
responsável por realizar automaticamente os seguintes processos a cada push ou pull request:

- 🧪 Build e execução dos testes automatizados  
- 🧰 Verificação de dependências e ambiente  
- 🚀 Deploy automatizado no Render

O sistema está atualmente em produção e acessível publicamente em:

👉 **[https://gestao-pedidos-gpts.onrender.com/](https://gestao-pedidos-gpts.onrender.com/)**

### 🧩 Tecnologias envolvidas na pipeline:
- **GitHub Actions** → build e testes contínuos  
- **Docker** → empacotamento da aplicação  
- **Render** → ambiente de deploy automatizado e hospedagem web

---

## ⚙️ Instalação e Configuração

### 🔧 Pré-requisitos
- PHP ≥ 8.2  
- Composer  
- Node.js + NPM  
- MySQL  
- (Opcional) Docker + Docker Compose

### 🚀 Passos para rodar o projeto

1. **Clone o repositório**
   ```bash
   git clone https://github.com/FelipTorres/gestao-pedidos.git
   cd gestao-pedidos
   ```

2. **Instale as dependências**
   ```bash
   composer install
   npm install && npm run build
   ```

3. **Configure o ambiente**
   ```bash
   cp .env.example .env
   ```
   Ajuste as variáveis (DB, MAIL, APP_URL etc.)

4. **Gere a chave da aplicação**
   ```bash
   php artisan key:generate
   ```

5. **Execute as migrations e seeders (opcional)**
   ```bash
   php artisan migrate --seed
   ```

6. **Inicie o servidor**
   ```bash
   php artisan serve
   npm run dev
   ```

### 🐳 Rodando com Docker (opcional)
Se preferir usar Docker:
```bash
docker compose up -d
```
A aplicação ficará acessível em [http://localhost:8000](http://localhost:8000).

---

## 🧭 Fluxo de Uso

1. **Home** → navegação para produtos, cupons e pedidos.  
2. **Produtos** → cadastro e controle de variações e estoques.  
3. **Cupons** → criação e gestão de cupons com regras de uso.  
4. **Carrinho** → adição de itens, aplicação de cupons e cálculo de frete.  
5. **Checkout** → validação de CEP e finalização do pedido.  
6. **Pedidos** → listagem e visualização de pedidos realizados.

---

## 🖥️ Tecnologias Utilizadas

- **Laravel 10+** (backend)
- **Bootstrap 5** (frontend)
- **jQuery** (interatividade)
- **MySQL** (banco de dados)
- **Vite** (build de assets)
- **API ViaCEP** (validação de CEP)
- **Docker** (ambiente de contêiner opcional)
- **GitHub Actions** (CI/CD – testes e build)
- **Render** (deploy automatizado)

---

## 📏 Padrões e Boas Práticas

- Arquitetura **MVC**
- **Form Requests** para validação centralizada
- **Componentização** de views Blade
- **Models e Services** bem separados
- **Feedbacks claros** e mensagens de erro descritivas
- Código **organizado e legível**, seguindo PSR-12

---

## 🧪 Testes (se aplicável)
Para rodar testes:
```bash
php artisan test
```
---

## 📫 Contato

**Felip Torres**  
🔗 [GitHub](https://github.com/FelipTorres)  
✉️ Para dúvidas ou sugestões, abra uma *issue* no repositório.

---

## 🏗️ Badges

![Laravel](https://img.shields.io/badge/Laravel-10.x-red?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-%5E8.2-blue?style=flat-square&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.x-blue?style=flat-square&logo=mysql)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.x-purple?style=flat-square&logo=bootstrap)
![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)
