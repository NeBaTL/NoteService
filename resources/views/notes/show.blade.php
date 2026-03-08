@extends('layouts.app')

@section('title', $note->title)

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('notes.index') }}">Заметки</a></li>
            <li class="breadcrumb-item active">{{ $note->title }}</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header">
            <h1>{{ $note->title }}</h1>
        </div>
        <div class="card-body">
            {{-- Категории --}}
            <div class="mb-3">
                <strong>Категории:</strong><br>
                @forelse($note->categories as $category)
                    <span class="badge me-1 mt-1" style="background-color: #6f42c1;">
                        {{ $category->name }}
                    </span>
                @empty
                    <span class="badge bg-secondary">Без категории</span>
                @endforelse
            </div>
            
            {{-- Контент --}}
            <div class="note-content mt-4">
                {!! nl2br(e($note->content)) !!}
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('notes.index') }}" class="btn btn-secondary">Назад к списку</a>
            <small class="text-muted float-end">
                Создано: {{ $note->created_at->format('d.m.Y H:i') }}
            </small>
        </div>
    </div>
</div>
@endsection