@extends('layouts.app')

@section('content')
<div class="text-center mt-5">
    <h1 class="mb-4">Bem-vindo ao Ecommerce ERP</h1>
    <p class="lead mb-5">Escolha uma das opções abaixo para começar a gerenciar seu sistema:</p>
    <div class="d-flex justify-content-center gap-3">
        <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">Produtos</a>
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-lg">Pedidos</a>
        <a href="{{ route('coupons.index') }}" class="btn btn-success btn-lg">Cupons</a>
    </div>
</div>
@endsection
