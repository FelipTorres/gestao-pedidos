@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Editar Produto</div>
            <div class="card-body">
                @include('components.alert-errors')
                <form method="POST" action="{{ route('products.update', $product) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome do Produto</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Preço</label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price', $product->price) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Variações <small class="text-muted">(opcional)</small></label>
                        <div id="variations-list">
                            @foreach($product->variations as $i => $variation)
                                <div class="row mb-2 variation-row">
                                    <div class="col-md-5">
                                        <input type="text" name="variations[{{ $i }}][name]" class="form-control" value="{{ $variation->name }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" name="variations[{{ $i }}][stock]" class="form-control" value="{{ optional($product->stocks->where('variation_id', $variation->id)->first())->quantity ?? 0 }}" required>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger btn-sm remove-variation">Remover</button>
                                    </div>
                                    <input type="hidden" name="variations[{{ $i }}][id]" value="{{ $variation->id }}">
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addVariation()">Adicionar Variação</button>
                    </div>
                    <div class="mb-3" id="stock-main-group">
                        <label for="stock" class="form-label">Estoque</label>
                        <input type="number" class="form-control" id="stock" name="stock" value="{{ optional($product->stocks->where('variation_id', null)->first())->quantity ?? 0 }}">
                        <div class="form-text" id="stock-main-help">Preencha este campo apenas se não houver variações.</div>
                    </div>
                    <button type="submit" class="btn btn-success">Salvar Alterações</button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
function addVariation() {
    const list = $('#variations-list');
    const idx = list.children().length;
    const div = $('<div class="row mb-2 variation-row"></div>');

    div.html(`
        <div class="col-md-5">
            <input type="text" name="variations[${idx}][name]" class="form-control" placeholder="Nome da Variação" required>
        </div>
        <div class="col-md-4">
            <input type="number" name="variations[${idx}][stock]" class="form-control" placeholder="Estoque" required>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger btn-sm remove-variation">Remover</button>
        </div>
    `);
    list.append(div);
    updateStockField();
}

function updateStockField() {
    const list = $('#variations-list');
    const stockGroup = $('#stock-main-group');
    const stockInput = $('#stock');

    if (list.children().length > 0) {
        stockGroup.hide();
        stockInput.prop('required', false);
    } else {
        stockGroup.show();
        stockInput.prop('required', true);
    }
}

$(document).on('click', '.remove-variation', function() {
    $(this).closest('.variation-row').remove();
    updateStockField();
});

$(function() {
    updateStockField();
});
</script>
