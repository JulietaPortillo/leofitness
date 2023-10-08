<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $users = user::excludeArchive()->paginate(10);
        return view('user.index', compact('users'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $user = user::findOrFail($request->id);
        return response()->json($user);
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, ['email' => 'unique:users,email']);

        $user = ['name'=>$request->name,
                    'email'=> $request->email,
                    'password' => bcrypt($request->password),
                    'status'=> $request->status, ];
        $user = new User($user);
        $user->save();

        if ($user->id) {
            flash()->success('User was successfully registered');

            return redirect('users');
        } else {
            flash()->error('Error while user registration');

            return redirect('users');
        }
    }

    public function edit($id)
    {
        $user = user::findOrFail($id);

        return view('users.edit', compact('user'));
    }

    public function archive($id, Request $request)
    {
        $user = user::findOrFail($id);
        $user->status = \constStatus::Archive;
        $user->save();
        flash()->error('User was successfully deleted');

        return redirect('users');
    }
}