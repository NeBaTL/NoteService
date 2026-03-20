@extends('layouts.app')

@section('title', 'Мои заметки')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Мои заметки</h1>
        {{-- Временно убираем кнопку создания, пока нет маршрута --}}
        {{-- <a href="{{ route('notes.create') }}" class="btn btn-primary">+ Новая заметка</a> --}}
        
        @if($notes->isEmpty())
            <div class="alert alert-info text-center">
                <p class="mb-2">У вас пока нет заметок.</p>
                {{-- Временно убираем ссылку --}}
                {{-- <a href="{{ route('notes.create') }}" class="btn btn-outline-primary">Создать первую заметку</a> --}}
                <p class="mb-0">Добавьте заметки через админ-панель или Tinker</p>
            </div>
        @endif
    </div>
    
    @if(!$notes->isEmpty())
        <div class="row">
            @foreach($notes as $note)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $note->title }}</h5>
                            <p class="card-text text-muted">
                                {{ Str::limit($note->content, 120) }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    {{ $note->created_at->format('d.m.Y H:i') }}
                                </small>
                                <a href="{{ route('notes.show', $note) }}" class="btn btn-sm btn-outline-primary">
                                    Читать →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-4">
            {{ $notes->links() }}
        </div>
    @endif
</div>
@endsection