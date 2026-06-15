<div class="row">
    <div class="col-md-8 mb-3">
        <label class="form-label">Nome *</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name ?? '') }}" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">SKU *</label>
        <input type="text" name="sku" class="form-control" value="{{ old('sku', $product->sku ?? '') }}" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Categoria *</label>
        <select name="category_id" class="form-select" required>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" @selected(old('category_id', $product->category_id ?? '') == $cat->id)>{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Preço (Kz) *</label>
        <input type="number" name="price" step="0.01" min="0.01" class="form-control" value="{{ old('price', $product->price ?? '') }}" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Stock *</label>
        <input type="number" name="stock" min="0" class="form-control" value="{{ old('stock', $product->stock ?? 0) }}" required>
    </div>
    <div class="col-12 mb-3">
        <label class="form-label">Descrição *</label>
        <textarea name="description" class="form-control" rows="4" required>{{ old('description', $product->description ?? '') }}</textarea>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Imagem Principal</label>
        <input type="file" name="main_image" class="form-control" accept="image/*">
        @if(!empty($product?->main_image))
            <img src="{{ $product->main_image_url }}" class="mt-2 rounded" width="80">
        @endif
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Galeria</label>
        <input type="file" name="gallery[]" class="form-control" accept="image/*" multiple>
    </div>
    <div class="col-12 mb-3">
        <div class="form-check">
            <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" @checked(old('is_active', $product->is_active ?? true))>
            <label class="form-check-label" for="is_active">Produto ativo (visível após aprovação)</label>
        </div>
        @if(!empty($product))
            <div class="mt-2">
                <span class="badge {{ $product->approval_status->badgeClass() }}">{{ $product->approval_status->label() }}</span>
                @if($product->approval_status->value === 'approved')
                    <span class="small text-muted ms-2">Alterações serão reenviadas para aprovação.</span>
                @endif
            </div>
        @else
            <div class="form-text">Novos produtos ficam pendentes até o administrador aprovar.</div>
        @endif
    </div>
</div>
