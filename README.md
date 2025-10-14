# Ecommerce ERP 🚀

Sistema de E-commerce com funcionalidades de ERP, desenvolvido em Laravel. O projeto permite o gerenciamento de produtos, variações, estoques, cupons de desconto e pedidos, além de um fluxo completo de carrinho de compras e finalização de pedidos com cálculo de frete e aplicação de cupons.

## Funcionalidades 🛠️

- **Gestão de Produtos** 📦
    - Cadastro, edição, exclusão e listagem de produtos.
    - Suporte a variações de produtos (ex: tamanho, cor).
    - Controle de estoque por produto e por variação.

- **Gestão de Cupons** 🎟️
    - CRUD de cupons de desconto.
    - Validação de data de validade e valor mínimo para uso.

- **Carrinho de Compras** 🛒
    - Adição e remoção de produtos/variações ao carrinho.
    - Cálculo automático de subtotal, aplicação de cupons e cálculo de frete.

- **Pedidos** 📑
    - Finalização de pedidos com endereço de entrega.
    - Validação de CEP via API ViaCEP.
    - Controle de estoque ao finalizar pedido.
    - Visualização de pedidos e detalhes.

- **Frete** 🚚
    - Regras de frete baseadas no subtotal do pedido:
        - Entre R$52,00 e R$166,59: R$15,00
        - Acima de R$200,00: Frete grátis
        - Outros valores: R$20,00

## Estrutura do Projeto 🗂️

- **app/Models**: Modelos Eloquent (Product, ProductVariation, Stock, Coupon, Order, OrderItems, User)
- **app/Http/Controllers**: Controladores responsáveis pela lógica de cada recurso.
- **app/Http/Requests**: Classes de validação customizadas.
- **resources/views**: Blades organizadas por domínio (`products`, `orders`, `coupons`, `cart`).
- **routes/web.php**: Rotas agrupadas por recurso.
- **database/migrations**: Migrations para estruturação do banco de dados.

## Instalação ⚙️

1. Clone o repositório:
   ```
   git clone https://github.com/FelipTorres/ecommerce-erp.git
   cd ecommerce-erp
   ```

2. Instale as dependências:
   ```
   composer install
   npm install && npm run dev
   ```

3. Configure o `.env`:
    - Copie `.env.example` para `.env` e ajuste as variáveis de ambiente (DB, etc).

4. Gere a chave da aplicação:
   ```
   php artisan key:generate
   ```

5. Execute as migrations:
   ```
   php artisan migrate
   ```

6. (Opcional) Popule o banco com seeders:
   ```
   php artisan db:seed
   ```

7. Inicie o servidor:
   ```
   php artisan serve
   ```

## Fluxo de Uso 🧭

1. **Acesse a Home**: Tela inicial com navegação para produtos, cupons e pedidos.
2. **Produtos**: Cadastre produtos, variações e estoques.
3. **Cupons**: Crie cupons com regras de uso.
4. **Carrinho**: Adicione produtos/variações, aplique cupons e calcule o frete.
5. **Finalização**: Informe o endereço, valide o CEP e conclua o pedido.
6. **Pedidos**: Visualize todos os pedidos realizados e seus detalhes.

## Tecnologias Utilizadas 🖥️

- Laravel 10+
- Bootstrap 5 (front-end)
- jQuery (interatividade)
- MySQL (banco de dados)
- API ViaCEP (validação de CEP)

## Padrões e Boas Práticas 📏

- Estrutura MVC.
- Validações centralizadas em Form Requests.
- Componentização de trechos de Blade.
- Lógica de negócio segregada em Models e Services.
- Mensagens de erro descritivas e feedback ao usuário.
