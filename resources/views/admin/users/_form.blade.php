<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Nome *</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Email *</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Perfil *</label>
        <select name="role_id" class="form-select" required>
            @foreach($roles as $role)
                <option value="{{ $role->id }}" @selected(old('role_id', $user->role_id ?? '') == $role->id)>{{ $role->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Telefone</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone ?? '') }}">
    </div>
    <div class="col-12 mb-3">
        <label class="form-label">Morada</label>
        <textarea name="address" class="form-control" rows="2">{{ old('address', $user->address ?? '') }}</textarea>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Senha {{ isset($user) ? '(deixe vazio para manter)' : '*' }}</label>
        <input type="password" name="password" class="form-control" {{ isset($user) ? '' : 'required' }}>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Confirmar Senha</label>
        <input type="password" name="password_confirmation" class="form-control">
    </div>
</div>
