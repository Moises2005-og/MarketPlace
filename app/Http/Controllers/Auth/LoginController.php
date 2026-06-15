<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function create(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect($this->redirectPath());
        }

        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Email ou senha incorretos.'])->onlyInput('email');
        }

        $user = Auth::user();

        if (! $user->isAdmin() && ! $user->isSeller()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'Acesso permitido apenas para Administradores e Vendedores.',
            ])->onlyInput('email');
        }

        if ($user->isSeller() && ! $user->status->canLogin()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $message = match ($user->status) {
                UserStatus::Pending => 'A sua conta está pendente de aprovação pelo administrador.',
                UserStatus::Suspended => 'A sua conta foi suspensa. Contacte o suporte.',
                UserStatus::Rejected => 'O seu registo foi reprovado.',
                default => 'Não tem permissão para aceder.',
            };

            return back()->withErrors(['email' => $message])->onlyInput('email');
        }

        $request->session()->regenerate();

        if ($user->must_change_password) {
            return redirect()->route('profile.edit')
                ->with('warning', 'Por segurança, altere a sua senha antes de continuar.');
        }

        return redirect()->intended($this->redirectPath())
            ->with('success', 'Bem-vindo, '.$user->name.'!');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    protected function redirectPath(): string
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return route('admin.dashboard');
        }

        return route('seller.dashboard');
    }
}
