<?php

namespace App\Enums;

enum RoleSlug: string
{
    case Admin = 'admin';
    case Seller = 'seller';
    case Customer = 'customer';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrador',
            self::Seller => 'Vendedor',
            self::Customer => 'Cliente',
        };
    }
}
