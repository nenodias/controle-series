<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Autenticador;
use App\Http\Requests\SeriesFormRequest;
use App\Events\SeriesCreated;
use App\Events\SeriesDeletedEvent;
use Illuminate\Http\Request;
use App\Models\Series;
use App\Models\User;
use App\Repositories\SeriesRepository;
use Illuminate\Support\Facades\Mail;

class SeriesController extends Controller
{
    public function __construct(private SeriesRepository $repository)
    {
        $this->middleware(Autenticador::class)->except(['index']);
    }

    public function index(Request $request)
    {
        $series = Series::with(['seasons'])->get();
        $mensagemSucesso = session('mensagem.sucesso');
        return view('series.index', compact('series','mensagemSucesso'));
        //return view('series/index')->with('series', $series);
    }

    public function create(Request $request)
    {
        return view('series.create');
    }

    public function store(SeriesFormRequest $request)
    {   
        if($request->hasFile('cover')){
            $coverpath = $request->file('cover')->store('series_cover', 'public');
            $request->coverPath = $coverpath;
        }
        
        $serie = $this->repository->add($request);

        $seriesCreatedEvent = new SeriesCreated(
            $serie->nome,
            $serie->id,
            $request->seasonsQty *1,
            $request->episodesPerSeason *1,
        );
        event($seriesCreatedEvent);

        return to_route('series.index')
            ->with('mensagem.sucesso',"Série '{$serie->nome}' adicionada com sucesso");
    }

    public function destroy(Series $series)
    {
        $series->delete();
        $seriesDeletedEvent = new SeriesDeletedEvent(
            $series->nome,
            $series->id,
            $series->cover != null ? $series->cover : "",
        );
        event($seriesDeletedEvent);
        return to_route('series.index')
            ->with('mensagem.sucesso',"Série '{$series->nome}' removida com sucesso");
    }

    public function edit(Series $series)
    {
        return view('series/edit')->with('serie', $series);
    }

    public function update(Series $series, SeriesFormRequest $request)
    {
        $series->fill($request->all());
        $series->save();
        return to_route('series.index')
            ->with('mensagem.sucesso',"Série '{$series->nome}' atualizada com sucesso");
    }

}
