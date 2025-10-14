@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3">Cupons</h1>
    <a href="{{ route('coupons.create') }}" class="btn btn-primary">Novo Cupom</a>
</div>
<div class="card">
    <ul class="list-group list-group-flush">
        @forelse($coupons as $coupon)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <strong>{{ $coupon->code }}</strong>
                    <span class="text-muted ms-2">Desconto: {{ $coupon->discount }}%</span>
                    <span class="ms-2">Mínimo: R$ {{ number_format($coupon->min_value, 2, ',', '.') }}</span>
                    <span class="ms-2">Validade: {{ \Carbon\Carbon::parse($coupon->validity)->format('d/m/Y') }}</span>
                </div>
                <div>
                    <a href="{{ route('coupons.edit', $coupon) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                    <form action="{{ route('coupons.destroy', $coupon) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este cupom?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                    </form>
                </div>
            </li>
        @empty
            <li class="list-group-item text-center">Nenhum cupom cadastrado.</li>
        @endforelse
    </ul>
</div>
@endsection
