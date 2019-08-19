<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo;

class TodosController extends Controller
{
    public function index() {
        
        // fetch all todos from the database and display in view
        $todos = Todo::all();
        return view('todos.index')->with('todos', $todos);
    }


    public function show(Todo $todo) {

        //$todo = Todo::find($todoId);
        return view('todos.show')->with('todo',$todo);
    }

    public function create() {

        return view('todos.create');
    }

    public function store() {

        //dd(request());
        $this->validate(request(), [
            'name' => 'required|min:6|max:20',
            'description' => 'required'
        ]);

        $data = request()->all();

        $todo = new Todo();

        $todo->name = $data['name'];
        $todo->description = $data['description'];
        $todo->completed = false;
        $todo->save();

        session()->flash('success','Todo created successfully');

        return redirect('/todos');
    }


    public function edit(Todo $todo){

        //$todo = Todo::find($todosId);
        return view('todos.edit')->with('todo',$todo);
    }


    public function update(Todo $todo) {

        // validates data coming from the form
        $this->validate(request(), [
            'name' => 'required|min:6|max:20',
            'description' => 'required'
        ]);
        
        // get the data from the form
        $data = request()->all();
        // find the id that we are editing
        //$todo = Todo::find($todoId);

        // save the data
        $todo->name = $data['name'];
        $todo->description = $data['description'];
        $todo->save();
        //
        return redirect('/todos');
    }

    public function destroy(Todo $todo){

        //$todo = Todo::find($todoId);
        $todo->delete();
        return redirect('/todos');
    }

    public function complete(Todo $todo){

        $todo->completed = true;
        $todo->save();

        session()->flash('success', 'Todo Completed successfully');

        return redirect('/todos');
    }
}
