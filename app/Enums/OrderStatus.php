<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Processing = 'processing';
    case Shipped = 'shipped';
    case Delivered = 'delivered';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pendente',
            self::Confirmed => 'Confirmado',
            self::Processing => 'Em processamento',
            self::Shipped => 'Enviado',
            self::Delivered => 'Entregue',
            self::Cancelled => 'Cancelado',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Pending => 'bg-warning text-dark',
            self::Confirmed => 'bg-info',
            self::Processing => 'bg-primary',
            self::Shipped => 'bg-secondary',
            self::Delivered => 'bg-success',
            self::Cancelled => 'bg-danger',
        };
    }

    public function canCancel(): bool
    {
        return in_array($this, [self::Pending, self::Confirmed, self::Processing]);
    }
}
