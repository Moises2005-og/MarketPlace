<?php

namespace App\Http\Controllers\Auth;

use App\Enums\RoleSlug;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use App\Services\CartService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function __construct(
        protected CartService $cartService
    ) {}

    public function create(): View
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request): RedirectResponse
    {
        $customerRole = Role::where('slug', RoleSlug::Customer->value)->firstOrFail();

        $user = User::create([
            ...$request->validated(),
            'role_id' => $customerRole->id,
            'password' => $request->password,
        ]);

        event(new Registered($user));

        Auth::login($user);
        $this->cartService->mergeGuestCart($user->id);

        return redirect()->route('verification.notice');
    }
}
