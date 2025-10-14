<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderCheckoutRequest;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Stock;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View|RedirectResponse
    {
        try {
            $orders = Order::with(['items', 'coupon'])
                ->orderByDesc('created_at')
                ->paginate(15)
            ;

            return view('orders.index', [
                'orders' => $orders,
            ]);
        } catch (\Exception $exception) {
            return redirect()
                ->route('orders.index')
                ->with('error', 'Erro ao listar pedidos: ' . $exception->getMessage())
            ;
        }
    }

    public function show(string $id): View|RedirectResponse
    {
        try {
            $order = Order::with([
                'items.product',
                'items.variation',
                'coupon'
            ])->findOrFail($id);

            return view('orders.show', compact('order'));
        } catch (\Exception $exception) {
            return redirect()
                ->route('orders.index')
                ->with('error', 'Erro ao exibir pedido: ' . $exception->getMessage())
            ;
        }
    }

    public function checkoutForm(): View|RedirectResponse
    {
        try {
            $cart = Session::get('cart', []);
            $coupon = Session::get('cart_coupon');

            if (empty($cart)) {
                return redirect()
                    ->route('cart.index')
                    ->with('error', 'Seu carrinho está vazio.')
                ;
            }

            return view('cart.checkout', [
                'cart' => $cart,
                'coupon' => $coupon
            ]);
        } catch (\Exception $exception) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Erro ao carregar checkout: ' . $exception->getMessage())
            ;
        }
    }

    public function checkout(OrderCheckoutRequest $request): RedirectResponse
    {
        try {
            $validated = $request->validated();

            $cart = Session::get('cart', []);
            $coupon = Session::get('cart_coupon');

            $subtotal = Coupon::getSubtotalAddedToCart($cart);
            $subtotalWithDiscount = Coupon::calculateDiscount($coupon, $subtotal);
            $freight = Order::applyFreight($subtotalWithDiscount);
            $total = $subtotalWithDiscount + $freight;

            $address = Order::buildAddress($validated);

            $order = Order::create([
                'subtotal' => $subtotal,
                'freight' => $freight,
                'total' => $total,
                'status' => 'novo',
                'cep' => $validated['cep'],
                'address' => $address,
                'coupon_id' => $coupon['id'] ?? null,
            ]);

            foreach ($cart as $item) {
                OrderItems::createItems($item, $order->id);
            }

            foreach ($cart as $item) {
                Stock::updateStock($item);
            }

            Session::forget('cart');
            Session::forget('cart_coupon');

            return redirect()
                ->route('orders.index')
                ->with('success', 'Pedido realizado com sucesso!')
            ;
        } catch (\Exception $exception) {
            return redirect()
                ->route('cart.checkout')
                ->with('error', 'Erro ao realizar o pedido: ' . $exception->getMessage())
            ;
        }
    }
}
