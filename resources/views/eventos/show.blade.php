@extends('layouts.app')

@section('title', $evento->titulo . ' — FalaQ')

@section('content')
<div class="row">
    <!-- Formularço de envio de Pergunta -->
    <div class="col-md-5 mb-4">
        <div class="card shadow-sm p-3">
            <h4 class="fw-bold mb-3">💬 Faça sua Pergunta</h4>
            <form action="{{ route('eventos.perguntas.store', $evento->id) }}" method="POST">
                @csrf
                <input type="hidden" name="evento_id" value="{{ $evento->id }}">
                <div class="mb-3">
                    <label for="texto" class="form-label text-secondary">Texto da Pergunta</label>

                    <textarea name="texto" id="texto" rows="4" 
                              class="form-control bg-dark text-white border-secondary @error('texto') is-invalid @enderror"
                              placeholder="Digite sua dúvida ou comentário para o palestrante..."></textarea>

                    @error('texto')
                        <div class="invalid-feedback fw-bold">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100 fw-bold">Enviar Pergunta</button>
            </form>
        </div>
    </div>

    <!-- Lista de Perguntas (TICKET #002) -->
    <div class="col-md-7">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold m-0">📋 Perguntas do Evento</h4>
            <span class="text-secondary small">Total no Banco: {{ $evento->perguntas->count() }}</span>
        </div>

        @error('motivo')
            <p class="text-red-500 text-sm mb-3">{{ $message }}</p>
        @enderror

        @can('moderate', $evento)
            <a href="{{ route('moderacoes.index', $evento) }}" class="btn btn-primary btn-sm mb-3">🛡️ Fila de Moderação</a>
        @endcan

        @forelse($perguntas as $pergunta)
            <div class="card mb-3 shadow-sm border-start border-4 border-primary">
                <div class="card-body">
                    <p class="fs-5 mb-2 text-white">{{ $pergunta->texto }}</p>
                    <div class="d-flex justify-content-between align-items-center text-secondary small">
                        <span>Enviado por: <strong>{{ $pergunta->user->name ?? 'Anônimo' }}</strong></span>
                        <span>Status: <span class="badge bg-success">{{ $pergunta->status }}</span></span>
                        <span>{{ $pergunta->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex items-center gap-4 mt-2">
                        <span class="text-sm font-semibold bg-blue-100 text-blue-800 px-3 py-1 rounded-full">
                            ⭐ {{ $pergunta->votos_count }} votos
                        </span>
                        @auth
                            <form action="{{ route('perguntas.votar', $pergunta) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-4 py-2 text-sm font-medium rounded-md {{ $pergunta->votos->contains(auth()->user()) ? 'bg-red-600 hover:bg-red-700 text-white' : 'bg-green-600 hover:bg-green-700 text-white' }}">
                                    {{ $pergunta->votos->contains(auth()->user()) ? 'Remover Voto' : '👍 Votar' }}
                                </button>
                            </form>
                        @endauth
                    </div>
                    @auth
                        <form action="{{ route('moderacoes.store', $pergunta) }}" method="POST" class="mt-2">
                            @csrf
                            <input type="text" name="motivo" placeholder="Motivo da denúncia (mín. 10 letras)"
                                   class="w-full mt-1 p-2 border rounded-md text-gray-800 @error('motivo') border-red-500 @else border-gray-300 @enderror">
                            <button type="submit" class="mt-1 bg-gray-800 text-gray-200 px-4 py-2 rounded-md hover:bg-gray-700">🚩 Denunciar</button>
                        </form>
                    @endauth
                    @can('delete', $pergunta)
                        <form action="{{ route('perguntas.destroy', $pergunta) }}" method="POST" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <x-danger-button type="submit">Excluir Pergunta</x-danger-button>
                        </form>
                    @endcan
                </div>
            </div>
        @empty
            <div class="alert alert-dark text-center p-4">
                Nenhuma pergunta enviada ainda. Seja o primeiro!
            </div>
        @endforelse

        <!-- TICKET #002: Renderização dos Botões de Paginação -->
        @if(method_exists($perguntas, 'links'))
            <div class="d-flex justify-content-center mt-4">
                {{ $perguntas->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
