<?php

namespace App\Enums;

enum UserStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Suspended = 'suspended';
    case Rejected = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pendente',
            self::Approved => 'Aprovado',
            self::Suspended => 'Suspenso',
            self::Rejected => 'Reprovado',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Pending => 'bg-warning text-dark',
            self::Approved => 'bg-success',
            self::Suspended => 'bg-danger',
            self::Rejected => 'bg-secondary',
        };
    }

    public function canLogin(): bool
    {
        return $this === self::Approved;
    }
}
