@extends('layouts.app')

@section('title', 'Все заметки')

@section('content')
<div class="container">
    <h1 class="mb-4">Мои заметки</h1>
    
    {{-- Фильтр по категориям --}}
    <form method="GET" action="{{ route('notes.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <select name="category" class="form-select">
                    <option value="">Все категории</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" 
                            {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Фильтр</button>
            </div>
        </div>
    </form>

    {{-- Список заметок --}}
    <div class="row">
        @forelse($notes as $note)
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $note->title }}</h5>
                        
                        {{-- Категории --}}
                        <div class="mb-2">
                            @forelse($note->categories as $category)
                                <span class="badge me-1" style="background-color: #6f42c1;">
                                    {{ $category->name }}
                                </span>
                            @empty
                                <span class="badge bg-secondary">Без категории</span>
                            @endforelse
                        </div>
                        
                        <p class="card-text">{{ Str::limit($note->content, 150) }}</p>
                        
                        <a href="{{ route('notes.show', $note) }}" class="btn btn-outline-primary btn-sm">
                            Читать далее
                        </a>
                    </div>
                    <div class="card-footer text-muted">
                        <small>Создано: {{ $note->created_at->format('d.m.Y') }}</small>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    Заметок пока нет. 
                    <a href="/admin">Создать в админке</a>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection