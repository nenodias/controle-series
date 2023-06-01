<x-layout title="Séries" :mensagem-sucesso="$mensagemSucesso">
    @auth
    <a class="btn btn-dark mb-2" href="{{ route('series.create') }}">Adicionar</a>
    @endauth

    <ul class="list-group">
        @forelse ($series as $serie)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            @if($serie->cover != null)
            <div class="d-flex justify-content-center align-items-center">
                <img style="width: 100px;" src="{{ asset('storage/'.$serie->cover) }}" alt="capa série" class="me-3">
            </div>
            @else
            <div class="d-flex justify-content-center align-items-center">
                <img style="width: 100px;" src="{{ asset('img/not_found.png') }}" alt="capa série" class="me-3">
            </div>
            @endif
            @auth <a href="{{route('seasons.index', $serie->id)}}"> @endauth
                {{ $serie->nome }}
            @auth</a>@endauth
            @auth
            <span class="d-flex">
                <a class="btn btn-warning btn-sm mx-1" href="{{ route('series.edit', $serie->id) }}">E</a>

                <form action="{{ route('series.destroy', $serie->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">X</button>
                </form>
            </span>
            @endauth
        </li>
        @empty
        <p>Nenhuma série foi encontrada</p>
        @endforelse
    </ul>
    <script>
        const teste = '@{{teste}}';
        const series = {{ Js::from($series) }};
    </script>
</x-layout>