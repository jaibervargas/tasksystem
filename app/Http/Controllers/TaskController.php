<?php

namespace App\Http\Controllers;

use App\Models\task;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Mail\TaskCreated;
use App\Mail\TaskComplete;
use Illuminate\Support\Facades\Mail;

class TaskController extends Controller
{
    public function index(){

        $tasks = task::where('user_id', Auth::id())
        ->where('complete', 0)
        ->orderBy('expiration_date', 'asc')
        ->get();
        
        return view('task.index', compact('tasks'));
    }
    

    public function edit(task $task)
    {     
        return view('task.edit', compact('task'));
    }

    public function create()
    {
        return view('task.create');
    }

    public function store(Request $request)
    {
       
        $request->validate([
            'title' => 'required|string|max:255',
            'expiration_date' => 'required|date',
        ]);

        // $completed = $request->has('completed') ? 1 : 0;
        try {
            $task = task::create([
                'title' => $request->title,
                'user_id' => Auth::id(),
                'description' => $request->description,
                'expiration_date' => $request->expiration_date,
                // 'completed' => $completed,
            ]);

            
            Mail::to(Auth::user()->email)->send(new TaskCreated($task)); 

            return redirect()->route('task.index')->with('success', 'Tarea creada con éxito.');
        } catch (\Exception $e) {
            
            return redirect()->route('task.index')->with('error', 'Ocurrió un error: ' . $e->getMessage());
        }
    }

    public function complete(Request $request, $id)
    {
        try {
            $is_completed = $request->has('is_completed') ? 1 : 0;

            $task = task::findOrFail($id);
            $task->complete = $is_completed;
            $task->save();

            Mail::to(Auth::user()->email)->send(new TaskComplete($task));

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            
            return response()->json(['error' => true]);
        }
    }

        
    public function update(Request $request, task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'expiration_date' => 'required|date',
        ]);

        $task->update($request->all());

        return redirect()->route('task.index')->with('success', 'Tarea actualizada con éxito.');
    }

    public function destroy(task $task)
    {
        $task->delete();
        return response()->json(['success' => 'Tarea eliminada con éxito.']);
    }
}

