<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCartRequest;
use App\Http\Requests\RemoveCartRequest;
use App\Http\Requests\UpdateCartRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Product;
use App\Models\ProductVariation;

class CartController extends Controller
{
    public function index(): View|RedirectResponse
    {
        try {
            $cart = Session::get('cart', []);

            return view('cart.index', [
                'cart' => $cart
            ]);
        } catch (\Exception $exception) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Erro ao listar carrinho: ' . $exception->getMessage())
            ;
        }
    }

    public function add(AddCartRequest $request): RedirectResponse
    {
        try {
            $validated = $request->validated();

            $product = Product::findOrFail($validated['product_id']);
            $variation = ProductVariation::find($validated['variation_id'] ?? null);

            $key = "{$product->id}-" . ($variation?->id ?? 'no-variation');

            $cart = Session::get('cart', []);
            $cart[$key] = [
                'product_id'   => $product->id,
                'variation_id' => $variation?->id,
                'name'         => $product->name . ($variation ? " - {$variation->name}" : ''),
                'quantity'     => $validated['quantity'],
                'price'        => $variation->price ?? $product->price,
            ];

            Session::put('cart', $cart);

            return redirect()
                ->route('cart.index')
                ->with('success', 'Produto adicionado ao carrinho!')
            ;
        } catch (\Exception $exception) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Erro ao adicionar produto ao carrinho: ' . $exception->getMessage())
            ;
        }
    }

    public function update(UpdateCartRequest $request): RedirectResponse
    {
        try {
            $validated = $request->validated();

            $cart = Session::get('cart', []);
            if (isset($cart[$validated['key']])) {
                $cart[$validated['key']]['quantity'] = $validated['quantity'];
                Session::put('cart', $cart);
            }

            return redirect()->route('cart.index');
        } catch (\Exception $exception) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Erro ao atualizar carrinho: ' . $exception->getMessage())
            ;
        }
    }

    public function remove(RemoveCartRequest $request): RedirectResponse
    {
        try {
            $validated = $request->validated();

            $cart = Session::get('cart', []);
            unset($cart[$validated['key']]);
            Session::put('cart', $cart);

            return redirect()->route('cart.index');
        } catch (\Exception $exception) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Erro ao remover produto do carrinho: ' . $exception->getMessage())
            ;
        }
    }

    public function clear(): RedirectResponse
    {
        try {
            Session::forget('cart');
            return redirect()->route('cart.index');
        } catch (\Exception $exception) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Erro ao limpar carrinho: ' . $exception->getMessage())
            ;
        }
    }
}
