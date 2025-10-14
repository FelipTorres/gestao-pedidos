<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyCouponRequest;
use App\Http\Requests\CouponRequest;
use App\Models\Coupon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class CouponController extends Controller
{
    public function index(): View|RedirectResponse
    {
        try {
            $coupons = Coupon::all();

            return view('coupons.index', [
                'coupons' => $coupons
            ]);
        } catch (\Exception $exception) {
            return redirect()
                ->route('coupons.index')
                ->with('error', 'Erro ao listar cupons: ' . $exception->getMessage())
            ;
        }
    }

    public function store(CouponRequest $request): RedirectResponse
    {
        try {
            $validated = $request->validated();
            Coupon::create($validated);

            return redirect()
                ->route('coupons.index')
                ->with('success', 'Cupom criado com sucesso!')
            ;
        } catch (\Exception $exception) {
            return redirect()
                ->route('coupons.index')
                ->with('error', 'Erro ao criar cupom: ' . $exception->getMessage())
            ;
        }
    }

    public function update(CouponRequest $request, int $id): RedirectResponse
    {
        try {
            $coupon = Coupon::findOrFail($id);

            $validated = $request->validated();
            $coupon->update($validated);

            return redirect()
                ->route('coupons.index')
                ->with('success', 'Cupom atualizado com sucesso!')
            ;
        } catch (\Exception $exception) {
            return redirect()
                ->route('coupons.index')
                ->with('error', 'Erro ao atualizar cupom: ' . $exception->getMessage())
            ;
        }
    }

    public function destroy(string $id): RedirectResponse
    {
        try {
            Coupon::destroy($id);

            return redirect()
                ->route('coupons.index')
                ->with('success', 'Cupom removido com sucesso!')
            ;
        } catch (\Exception $exception) {
            return redirect()
                ->route('coupons.index')
                ->with('error', 'Erro ao remover cupom: ' . $exception->getMessage())
            ;
        }
    }

    public function edit($id): View|RedirectResponse
    {
        try {
            $coupon = Coupon::findOrFail($id);

            return view('coupons.edit', [
                'coupon' => $coupon
            ]);
        } catch (\Exception $exception) {
            return redirect()
                ->route('coupons.index')
                ->with('error', 'Erro ao editar cupom: ' . $exception->getMessage())
            ;
        }
    }

    public function create(): View
    {
        return view('coupons.create');
    }

    public function applyCoupon(ApplyCouponRequest $request): RedirectResponse
    {
        try {
            $validated = $request->validated();

            $coupon = Coupon::validateCoupon($validated);
            Session::put('cart_coupon', $coupon->toArray());

            return redirect()
                ->route('cart.index')
                ->with('success', 'Cupom aplicado com sucesso!')
            ;
        } catch (\Exception $exception) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Erro ao aplicar cupom: ' . $exception->getMessage())
            ;
        }
    }

    public function removeCoupon(): RedirectResponse
    {
        Session::forget('cart_coupon');
        return redirect()
            ->route('cart.index')
            ->with('success', 'Cupom removido.')
        ;
    }
}
