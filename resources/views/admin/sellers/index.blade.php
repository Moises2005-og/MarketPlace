@extends('layouts.admin')

@section('title', 'Vendedores')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Gestão de Vendedores</h1>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Produtos</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($sellers as $seller)
                    <tr>
                        <td>{{ $seller->name }}</td>
                        <td>{{ $seller->email }}</td>
                        <td>{{ $seller->phone ?? '—' }}</td>
                        <td>{{ $seller->products_count }}</td>
                        <td><span class="badge {{ $seller->status->badgeClass() }}">{{ $seller->status->label() }}</span></td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('admin.sellers.show', $seller) }}" class="btn btn-sm btn-outline-secondary" title="Histórico">
                                <i class="bi bi-clock-history"></i>
                            </a>
                            @if($seller->status->value === 'pending')
                                <form action="{{ route('admin.sellers.approve', $seller) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-success" title="Aprovar"><i class="bi bi-check-lg"></i></button>
                                </form>
                                <form action="{{ route('admin.sellers.reject', $seller) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-outline-danger" data-confirm="Reprovar este vendedor?" title="Reprovar"><i class="bi bi-x-lg"></i></button>
                                </form>
                            @elseif($seller->status->value === 'approved')
                                <form action="{{ route('admin.sellers.suspend', $seller) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-outline-warning" data-confirm="Suspender esta conta?" title="Suspender"><i class="bi bi-pause-circle"></i></button>
                                </form>
                            @elseif($seller->status->value === 'suspended')
                                <form action="{{ route('admin.sellers.reactivate', $seller) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-outline-success" title="Reativar"><i class="bi bi-play-circle"></i></button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-muted text-center py-4">Nenhum vendedor registado</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $sellers->links() }}</div>
@endsection
