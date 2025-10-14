@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">Produtos</h1>
        <a href="{{ route('products.create') }}" class="btn btn-primary">Novo Produto</a>
    </div>
    <div class="card">
        <ul class="list-group list-group-flush">
            @forelse($products as $product)
                <li class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $product->name }}</strong>
                            <span class="text-muted ms-2">R$ {{ number_format($product->price, 2, ',', '.') }}</span>
                        </div>
                        <div>
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                            </form>
                            <form action="{{ route('cart.add') }}" method="POST" class="d-inline ms-2">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                @if($variationStocks[$product->id]->count())
                                    <select name="variation_id" class="form-select form-select-sm d-inline-block w-auto" required>
                                        <option value="">Variação</option>
                                        @foreach($variationStocks[$product->id] as $v)
                                            <option value="{{ $v['id'] }}">{{ $v['name'] }}</option>
                                        @endforeach
                                    </select>
                                @endif
                                <input type="number" name="quantity" value="1" min="1" class="form-control form-control-sm d-inline-block w-auto" style="width: 70px;">
                                <button type="submit" class="btn btn-sm btn-success">Adicionar ao Carrinho</button>
                            </form>
                        </div>
                    </div>
                    <div class="mt-2 ms-3">
                        @if($variationStocks[$product->id]->count())
                            <div><strong>Variações:</strong></div>
                            <ul class="mb-1">
                                @foreach($variationStocks[$product->id] as $v)
                                    <li>
                                        {{ $v['name'] }}
                                        <span class="badge bg-info text-dark ms-2">Estoque: {{ $v['quantity'] }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @elseif($mainStocks[$product->id])
                            <span class="badge bg-info text-dark">Estoque: {{ $mainStocks[$product->id]->quantity }}</span>
                        @else
                            <span class="badge bg-secondary">Sem estoque cadastrado</span>
                        @endif
                    </div>
                </li>
            @empty
                <li class="list-group-item text-center">Nenhum produto cadastrado.</li>
            @endforelse
        </ul>
    </div>
@endsection
