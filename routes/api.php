<?php
/* Comandos para instalar SANCTUM */
/* composer require laravel/sanctum */
/* php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider" */

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;

Route::get('/ping', function(){
  return ['pong' => true];
});

Route::post('/user', [AuthController::class, 'create']);

Route::post('/todo', [ApiController::class, 'createTodo']);
Route::get('/todos', [ApiController::class, 'readAllTodos']);
Route::get('todo/{id}', [ApiController::class, 'readTodo']);
Route::put('todo/{id}', [ApiController::class, 'updateTodo']);
Route::delete('/todo/{id}', [ApiController::class, 'deleteTodo']);

// CRUD do todo
// Create = métodos para criar uma tarefa
// Read = métodos para ler uma ou todas as tarefas
// Update = métodos para atualizar
// Delete = métodos para excluir uma tarefa

// POST /todo = inserir uma tarefa no sistema
// GET /todos = Ler todas as tarefas no sistema
// GET /todo/{id} = Ler uma tarefa específica no sistema
// PUT /todo/{id} = Atualizar uma tarefa no sistema
// DELETE /todo/{id} = Deletar uma tarefa no sistema

/*
Autenticação via API
- Em uma API bem criada, não existe sessão.

- Funciona através de TOKEN:
-- Usuário faz o login e acertaq as credenciais.
-- O sistema gera um token e associa ao usuário.
-- O token é retornado pela API.
-- A partir daí:
--- Toda requisição, será acompanhada pelo token.

- O token é enviado de duas formas:
-- No corpo da requisição (ou nos parâmetros).
-- Nos cabeçalhos da requisição. Bearer
*/