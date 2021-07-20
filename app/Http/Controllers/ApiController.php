<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Todo;

class ApiController extends Controller
{
  public function createTodo(Request $request) {
    $array = ['error' => ''];

    // Validar as informações
    $rules = [
      'title' => 'required|min:3'
    ];
    $validator = Validator::make($request->all(), $rules);

    if($validator->fails()) {
      $array['error'] = $validator->messages();
      return $array;
    }
    $title = $request->input('title');

    // Criando o registro
    $todo = new Todo();// Cria 
    $todo->title = $title;// Pega
    $todo->save();// Envia

    return $array;
  }

  public function readAllTodos() {
    $array = ['error' => ''];

    $todos = Todo::simplePaginate(2);// 2 items por página

    $array['list'] = $todos->items();
    $array['current_page'] = $todos->currentPage();// Pg atual

    return $array;
  }

  public function readTodo($id) {
    $array = ['error' => ''];
    
    $todo = Todo::find($id);

    if($todo) {
      $array['todo'] = $todo;
    } else {
      $array['error'] = 'A tarefa '.$id.' não existe!';
    }

    return $array;
  }

  public function updateTodo($id, Request $request) {
    $array = ['error' => ''];

    // Validar as informações
    $rules = [
      'title' => 'min:3',
      'done' => 'boolean'// true, false, 1, 0, '1', '0'
    ];
    $validator = Validator::make($request->all(), $rules);

    if($validator->fails()) {
      $array['error'] = $validator->messages();
      return $array;
    }
    $title = $request->input('title');
    $done = $request->input('done');

    //var_dump($done);

    // Atualizando o registro
    $todo = Todo::find($id);// Pega o item 
    if($todo) {

      if($title) {
        $todo->title = $title;
      }
      if($done !== NULL) {
        $todo->done = $done;
      }

      $todo->save();

    } else {
      $array['error'] = 'Tarefa '. $id.' não existe, logo, não pode ser atualizado.';
    }
    return $array;
  }

  public function deleteTodo($id) {
    $array = ['error' => ''];

    $todo = Todo::find($id);// Acha o ítem
    if($todo) {
    $todo->delete();// deleta o ítem
    } else {
      $array['error'] = 'Tarefa '. $id.' não existe, logo, não pode ser deletada.';
    }
    //$todo->destroy($id);
    return $array;
  }
}
