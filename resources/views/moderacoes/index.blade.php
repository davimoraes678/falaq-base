@extends('layouts.app')

@section('title', 'Fila de Moderação — FalaQ')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="fw-bold m-0">🛡️ Fila de Moderação</h2>
    <a href="{{ route('eventos.show', $evento->id) }}" class="btn btn-primary btn-sm">&larr; Voltar ao Evento</a>
</div>

@forelse($moderacoes as $moderacao)
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <p class="fs-5 mb-2 text-white">{{ $moderacao->pergunta->texto }}</p>
            <p class="text-secondary mb-2">Motivo: {{ $moderacao->motivo }}</p>
            <div class="flex items-center gap-4">
                <span>Status: <span class="badge bg-secondary">{{ $moderacao->status }}</span></span>

                <form action="{{ route('moderacoes.status', $moderacao) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="aprovado">
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Aprovar</button>
                </form>

                <form action="{{ route('moderacoes.status', $moderacao) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="rejeitado">
                    <x-danger-button type="submit">Rejeitar</x-danger-button>
                </form>
            </div>
        </div>
    </div>
@empty
    <div class="alert alert-dark text-center p-4">
        Nenhuma denúncia na fila.
    </div>
@endforelse

<div class="d-flex justify-content-center mt-4">
    {{ $moderacoes->links() }}
</div>
@endsection
