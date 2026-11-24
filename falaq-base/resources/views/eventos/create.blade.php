@extends('layouts.app')

@section('title', 'Criar Evento — FalaQ')

@section('content')
<div class="max-w-2xl mx-auto bg-white text-gray-800 p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4">📅 Criar Evento</h2>
    <form action="{{ route('eventos.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="titulo">Título do Evento</label>
            <input type="text" name="titulo" id="titulo" value="{{ old('titulo') }}"
                   class="w-full mt-1 p-2 border rounded-md @error('titulo') border-red-500 @else border-gray-300 @enderror">
            @error('titulo')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="descricao">Descrição do Evento</label>
            <textarea name="descricao" id="descricao" rows="4"
                      class="w-full mt-1 p-2 border rounded-md @error('descricao') border-red-500 @else border-gray-300 @enderror">{{ old('descricao') }}</textarea>
            @error('descricao')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="data_evento">Data</label>
            <input type="date" name="data_evento" id="data_evento" value="{{ old('data_evento') }}"
                   class="w-full mt-1 p-2 border rounded-md @error('data_evento') border-red-500 @else border-gray-300 @enderror">
            @error('data_evento')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Criar Evento</button>
    </form>
</div>
@endsection
