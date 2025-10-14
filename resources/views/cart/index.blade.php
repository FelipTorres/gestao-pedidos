@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3">Carrinho de Compras</h1>
            <form action="{{ route('cart.clear') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">Limpar Carrinho</button>
            </form>
        </div>
        <div class="card">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if(empty($cart))
                    <div class="alert alert-info">Seu carrinho está vazio.</div>
                @else
                    <div class="mb-3">
                        @if(session('cart_coupon'))
                            <div class="alert alert-success">
                                Cupom aplicado: <strong>{{ session('cart_coupon.code') }}</strong> - Desconto: {{ session('cart_coupon.discount') }}% <br>
                                <form action="{{ route('coupons.removeCoupon') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-sm mt-2">Remover cupom</button>
                                </form>
                            </div>
                        @else
                            <form action="{{ route('coupons.applyCoupon') }}" method="POST" class="row g-2 align-items-center">
                                @csrf
                                <div class="col-auto">
                                    <input type="text" name="code" class="form-control form-control-sm" placeholder="Código do cupom" required>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-success btn-sm">Aplicar cupom</button>
                                </div>
                            </form>
                        @endif
                    </div>
                    <table class="table table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Variação</th>
                                <th>Quantidade</th>
                                <th>Preço Unitário</th>
                                <th>Subtotal</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach($cart as $key => $item)
                                @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                                <tr>
                                    <td>{{ $item['name'] }}</td>
                                    <td>{{ $item['variation_id'] ?: '-' }}</td>
                                    <td>
                                        <form action="{{ route('cart.update') }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="key" value="{{ $key }}">
                                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control form-control-sm d-inline-block w-auto" style="width: 70px;">
                                            <button type="submit" class="btn btn-sm btn-outline-primary">Atualizar</button>
                                        </form>
                                    </td>
                                    <td>R$ {{ number_format($item['price'], 2, ',', '.') }}</td>
                                    <td>R$ {{ number_format($subtotal, 2, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('cart.remove') }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="key" value="{{ $key }}">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Remover</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-end">Subtotal</th>
                                <th colspan="2">R$ {{ number_format($total, 2, ',', '.') }}</th>
                            </tr>
                            @if(session('cart_coupon'))
                                @php
                                    $discount = $total * (session('cart_coupon.discount') / 100);
                                    $totalWithDiscount = $total - $discount;
                                @endphp
                                <tr>
                                    <th colspan="4" class="text-end">Desconto ({{ session('cart_coupon.discount') }}%)</th>
                                    <th colspan="2">- R$ {{ number_format($discount, 2, ',', '.') }}</th>
                                </tr>
                                <tr>
                                    <th colspan="4" class="text-end">Total com desconto</th>
                                    <th colspan="2">R$ {{ number_format($totalWithDiscount, 2, ',', '.') }}</th>
                                </tr>
                            @endif
                        </tfoot>
                    </table>
                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route('orders.checkoutForm') }}" class="btn btn-success">
                            Finalizar Pedido
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
