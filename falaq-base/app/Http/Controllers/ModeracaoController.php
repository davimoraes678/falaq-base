<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreModeracaoRequest;
use App\Models\Evento;
use App\Models\Moderacao;
use App\Models\Pergunta;
use Illuminate\Http\Request;

class ModeracaoController extends Controller
{
    public function store(StoreModeracaoRequest $request, Pergunta $pergunta)
    {
        $pergunta->moderacoes()->create($request->validated());

        return back()->with('sucesso', 'Denúncia enviada para moderação!');
    }

    public function index(Evento $evento)
    {
        // Apenas o dono/moderador do evento vê a fila
        $this->authorize('moderate', $evento);

        $moderacoes = Moderacao::with('pergunta')->latest()->paginate(15);

        return view('moderacoes.index', compact('evento', 'moderacoes'));
    }

    public function updateStatus(Request $request, Moderacao $moderacao)
    {
        $this->authorize('moderate', $moderacao->pergunta->evento);

        $request->validate([
            'status' => 'required|in:analisando,aprovado,rejeitado',
        ]);

        $moderacao->update([
            'status' => $request->status,
        ]);

        return back()->with('sucesso', 'Status da moderação atualizado com sucesso!');
    }
}
