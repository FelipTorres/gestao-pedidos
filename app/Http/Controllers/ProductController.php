<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View|RedirectResponse
    {
        try {
            $products = Product::with([
                'variations',
                'stocks']
            )->get();
            $mainStocks = [];
            $variationStocks = [];

            foreach ($products as $product) {
                $mainStocks[$product->id] = $product->stocks->firstWhere('variation_id', null);
                $variationStocks[$product->id] = $product->variations->map(function($variation) use ($product) {
                    $stock = $product->stocks->firstWhere('variation_id', $variation->id);

                    return [
                        'id' => $variation->id,
                        'name' => $variation->name,
                        'quantity' => $stock ? $stock->quantity : 0
                    ];
                });
            }

            return view('products.index', [
                'products' => $products,
                'mainStocks' => $mainStocks,
                'variationStocks' => $variationStocks,
            ]);
        } catch (\Exception $exception) {
            return redirect()
                ->route('products.index')
                ->with('error', 'Erro ao listar produtos: ' . $exception->getMessage())
            ;
        }
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        try {
            $validated = $request->validated();
            Product::createWithVariationsAndStock($validated);

            return redirect()
                ->route('products.index')
                ->with('success', 'Produto criado com sucesso!')
            ;
        } catch (\Exception $exception) {
            return redirect()
                ->route('products.index')
                ->with('error', 'Erro ao criar produto: ' . $exception->getMessage())
            ;
        }
    }

    public function update(ProductRequest $request, $id): RedirectResponse
    {
        try {
            $product = Product::findOrFail($id);

            $validated = $request->validated();
            $product->update([
                'name' => $validated['name'],
                'price' => $validated['price'],
            ]);

            $product
                ->verifyIfRemovedVariations()
                ->updateVariationsAndStock($validated)
            ;

            return redirect()
                ->route('products.index')
                ->with('success', 'Produto atualizado com sucesso!');
        } catch (\Exception $exception) {
            return redirect()
                ->route('products.index')
                ->with('error', 'Erro ao atualizar produto: ' . $exception->getMessage())
            ;
        }
    }

    public function destroy($id): RedirectResponse
    {
        try {
            Product::destroy($id);

            return redirect()
                ->route('products.index')
                ->with('success', 'Produto removido com sucesso!')
            ;
        } catch (\Exception $exception) {
            return redirect()
                ->route('products.index')
                ->with('error', 'Erro ao remover produto: ' . $exception->getMessage())
            ;
        }
    }

    public function edit($id): View|RedirectResponse
    {
        try {
            $product = Product::findOrFail($id);

            return view('products.edit', [
                'product' => $product
            ]);
        } catch (\Exception $exception) {
            return redirect()
                ->route('products.index')
                ->with('error', 'Erro ao editar produto: ' . $exception->getMessage())
            ;
        }
    }

    public function create(): View
    {
        return view('products.create');
    }
}
