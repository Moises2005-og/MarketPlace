<?php

namespace App\Http\Controllers\Auth;

use App\Enums\RoleSlug;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SellerRegisterRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SellerRegisterController extends Controller
{
    public function create(): View
    {
        return view('auth.seller-register');
    }

    public function store(SellerRegisterRequest $request): RedirectResponse
    {
        $sellerRole = Role::where('slug', RoleSlug::Seller->value)->firstOrFail();

        User::create([
            ...$request->validated(),
            'role_id' => $sellerRole->id,
            'status' => UserStatus::Pending,
            'password' => $request->password,
        ]);

        return redirect()->route('login')
            ->with('success', 'Registo enviado! Aguarde a aprovação do administrador para aceder à plataforma.');
    }
}
