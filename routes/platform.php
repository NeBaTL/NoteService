<?php

declare(strict_types=1);
//use Orchid\Platform\Screen\UserListScreen;
//use Orchid\Platform\Screen\UserEditScreen;
//use Orchid\Platform\Screen\RoleListScreen;
//use Orchid\Platform\Screen\RoleEditScreen;
use App\Orchid\Screens\Note\NoteEditScreen;
use App\Orchid\Screens\Note\NoteListScreen;
use App\Orchid\Screens\Category\CategoryEditScreen;
use App\Orchid\Screens\Category\CategoryListScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

// !!! ВРЕМЕННО ЗАКОММЕНТИРУЙТЕ ЭТИ СТРОКИ !!!
// Route::screen('main', \Orchid\Screen\Components\EmptyScreen::class)
//     ->name('platform.main');

// Route::screen('example', \Orchid\Press\Screen\ExampleScreen::class)
//     ->name('platform.example');

// Route::screen('examples/forms', \Orchid\Press\Screen\ExampleScreen::class)
//     ->name('platform.example.forms');

// Route::screen('examples/layouts', \Orchid\Press\Screen\ExampleScreen::class)
//     ->name('platform.example.layouts');

// Ваши маршруты (эти оставьте)
Route::screen('notes', NoteListScreen::class)
    ->name('platform.note.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Заметки', route('platform.note.list')));

Route::screen('notes/create', NoteEditScreen::class)
    ->name('platform.note.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.note.list')
        ->push('Создание заметки', route('platform.note.create')));

Route::screen('notes/{note}/edit', NoteEditScreen::class)
    ->name('platform.note.edit')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.note.list')
        ->push('Редактирование заметки'));

Route::screen('categories', CategoryListScreen::class)
    ->name('platform.category.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Категории', route('platform.category.list')));

Route::screen('categories/create', CategoryEditScreen::class)
    ->name('platform.category.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.category.list')
        ->push('Создание категории', route('platform.category.create')));

Route::screen('categories/{category}/edit', CategoryEditScreen::class)
    ->name('platform.category.edit')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.category.list')
        ->push('Редактирование категории'));
//Route::screen('users', \Orchid\Platform\Screen\UserListScreen::class)
    //->name('platform.systems.users')
    //->permission('platform.systems.users');

//Route::screen('users/create', \Orchid\Platform\Screen\UserEditScreen::class)
    //->name('platform.systems.users.create')
    //->permission('platform.systems.users');

//Route::screen('users/{user}/edit', \Orchid\Platform\Screen\UserEditScreen::class)
    //->name('platform.systems.users.edit')
    //->permission('platform.systems.users');

//Route::screen('roles', \Orchid\Platform\Screen\RoleListScreen::class)
    //->name('platform.systems.roles')
    //->permission('platform.systems.roles');

//Route::screen('roles/create', \Orchid\Platform\Screen\RoleEditScreen::class)
    //->name('platform.systems.roles.create')
    //->permission('platform.systems.roles');

//Route::screen('roles/{role}/edit', \Orchid\Platform\Screen\RoleEditScreen::class)
    //->name('platform.systems.roles.edit')
    //->permission('platform.systems.roles');