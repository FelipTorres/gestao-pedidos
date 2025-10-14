@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Pedidos</h1>
    @if($orders->count() === 0)
        <div class="alert alert-info">Nenhum pedido encontrado.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Data</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Detalhes</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>R$ {{ number_format($order->total, 2, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-sm">
                                Detalhes
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
