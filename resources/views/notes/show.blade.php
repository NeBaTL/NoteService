@extends('layouts.app')

@section('title', $note->title)

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="h3 mb-0">{{ $note->title }}</h1>
            <small class="text-muted">
                Создано: {{ $note->created_at->format('d.m.Y H:i') }}
            </small>
        </div>
        
        <div class="card-body">
            <div class="note-content">
                {!! nl2br(e($note->content)) !!}
            </div>
        </div>
        
        <div class="card-footer">
            <div class="d-flex justify-content-between">
                <a href="{{ route('notes.index') }}" class="btn btn-secondary">
                    ← Назад к списку
                </a>
                <div>
                    <a href="{{ route('notes.edit', $note) }}" class="btn btn-primary">
                        Редактировать
                    </a>
                    <form action="{{ route('notes.destroy', $note) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Удалить заметку?')">
                            Удалить
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .note-content {
        font-size: 1.1rem;
        line-height: 1.6;
        white-space: pre-wrap;
    }
</style>
@endpush