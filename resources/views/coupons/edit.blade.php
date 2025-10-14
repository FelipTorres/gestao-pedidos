@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Editar Cupom</div>
            <div class="card-body">
                @include('components.alert-errors')
                <form method="POST" action="{{ route('coupons.update', $coupon) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="code" class="form-label">Código do Cupom</label>
                        <input type="text" class="form-control" id="code" name="code" value="{{ old('code', $coupon->code) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="discount" class="form-label">Desconto (%)</label>
                        <input type="number" step="1" class="form-control" id="discount" name="discount" min="1" max="100" value="{{ old('discount', $coupon->discount) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="min_value" class="form-label">Valor Mínimo do Pedido</label>
                        <input type="number" step="0.01" class="form-control" id="min_value" name="min_value" value="{{ old('min_value', $coupon->min_value) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="validity" class="form-label">Validade</label>
                        <input type="date" class="form-control" id="validity" name="validity" value="{{ old('validity', $coupon->validity ? \Carbon\Carbon::parse($coupon->validity)->format('Y-m-d') : '') }}" required>
                    </div>
                    <button type="submit" class="btn btn-success">Salvar Alterações</button>
                    <a href="{{ route('coupons.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
