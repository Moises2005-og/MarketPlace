<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Nome *</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $category->name ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Slug</label>
        <input type="text" name="slug" class="form-control" value="{{ old('slug', $category->slug ?? '') }}" placeholder="Gerado automaticamente">
    </div>
    <div class="col-12 mb-3">
        <label class="form-label">Descrição</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description ?? '') }}</textarea>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Imagem</label>
        <input type="file" name="image" class="form-control" accept="image/*">
        @if(!empty($category?->image_url))
            <img src="{{ $category->image_url }}" class="mt-2 rounded" width="80">
        @endif
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Categoria Pai</label>
        <select name="parent_id" class="form-select">
            <option value="">Nenhuma</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" @selected(old('parent_id', $category->parent_id ?? '') == $cat->id)>{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12 mb-3">
        <div class="form-check">
            <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" @checked(old('is_active', $category->is_active ?? true))>
            <label class="form-check-label" for="is_active">Categoria ativa</label>
        </div>
    </div>
</div>
