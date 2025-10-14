@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Detalhes do Pedido #{{ $order->id }}</h1>
    <div class="mb-3">
        <strong>Data:</strong> {{ $order->created_at->format('d/m/Y H:i') }}<br>
        <strong>Status:</strong> {{ ucfirst($order->status) }}<br>
        <strong>Total:</strong> R$ {{ number_format($order->total, 2, ',', '.') }}<br>
        <strong>Frete:</strong> R$ {{ number_format($order->freight, 2, ',', '.') }}<br>
        <strong>Subtotal:</strong> R$ {{ number_format($order->subtotal, 2, ',', '.') }}<br>
        <strong>Cupom:</strong> {{ $order->coupon ? $order->coupon->code : '-' }}<br>
        <strong>Endereço:</strong> {{ $order->address }}<br>
        <strong>CEP:</strong> {{ $order->cep ?? $order->zip_code }}
    </div>
    <h4>Itens do Pedido</h4>
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Variação</th>
                    <th>Quantidade</th>
                    <th>Preço Unitário</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product ? $item->product->name : $item->name }}</td>
                    <td>{{ $item->variation ? $item->variation->name : '-' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>R$ {{ number_format($item->price, 2, ',', '.') }}</td>
                    <td>R$ {{ number_format($item->total, 2, ',', '.') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <a href="{{ route('orders.index') }}" class="btn btn-secondary mt-3">Voltar para pedidos</a>
</div>
@endsection
