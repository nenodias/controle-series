<x-layout title="Login">
    <form method="post" action="{{ route('signin') }}" class="mt-3">
        @csrf

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

        <button class="btn btn-primary mt-3">Entrar</button>
        <a  href="{{ route('users.create') }}" class="btn btn-secondary mt-3">Registrar</a>
    </form>
</x-layout>