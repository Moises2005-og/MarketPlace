@extends('layouts.admin')

@section('title', 'Categorias')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Categorias</h1>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Nova</a>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr><th></th><th>Nome</th><th>Slug</th><th>Produtos</th><th>Estado</th><th></th></tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>
                            @if($category->image_url)
                                <img src="{{ $category->image_url }}" alt="" width="48" height="48" class="rounded object-fit-cover">
                            @else
                                <span class="badge bg-light text-muted">—</span>
                            @endif
                        </td>
                        <td>{{ $category->name }}</td>
                        <td><code>{{ $category->slug }}</code></td>
                        <td>{{ $category->products_count }}</td>
                        <td>
                            @if($category->is_active)
                                <span class="badge bg-success">Ativa</span>
                            @else
                                <span class="badge bg-secondary">Inativa</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" data-confirm="Eliminar esta categoria?"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $categories->links() }}</div>
@endsection
