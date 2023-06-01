<x-layout title="Novo usuário">
    <form method="post" action="{{ route('users.store') }}" class="mt-3">
        @csrf

        <div class="form-group">
            <label for="name" class="form-label">
                Nome
            </label>
            <input type="text" name="name" id="name" class="form-group">
        </div>

        <div class="form-group">
            <label for="email" class="form-label">
                E-mail
            </label>
            <input type="text" name="email" id="email" class="form-group">
        </div>
        <div class="form-group">
            <label for="password" class="form-label">
                Senha
            </label>
            <input type="password" name="password" id="password" class="form-group">
        </div>
        <div class="form-group">
            <label for="password_confirmation" class="form-label">
                Confirmação de Senha
            </label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-group">
        </div>

        <button class="btn btn-primary mt-3">Registrar</button>
    </form>
</x-layout>