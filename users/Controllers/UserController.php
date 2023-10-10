<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index( ) {
        return view( 'user.create');
    }

    public function create()
    {
        $validatedData = $this->validateUser();
        $validatedData['password'] =  Hash::make( $validatedData['password'] );

        User::create($validatedData);

        return redirect('user/view')->with('success', 'User created successfully.');
    }
    public function view( ) {
        $users = User::paginate(5);

        if ($users->isEmpty()) {
            return redirect('user/create')->with('success', 'No user found. Please create a user.');
        }

        return view('user.index', compact('users'));
    }

    public function edit(User $user) {
        return view('user.edit', [
            'user' => $user
        ]);
    }

    public function delete(User $user) {
        $user->delete();

        return back()->with('success', 'User Deleted!');
    }

    public function update(User $user) {
        $attributes = $this->validateUser($user);
        $user->update($attributes);

        return redirect('user/view')->with('success', 'User has been updated' );
    }

    protected function validateUser(?User $user = null): array {
        $user ??= new User();

        return request()->validate([
            'name'     => 'required|min:3|max:255',
            'username' => ['required', 'min:7', Rule::unique('users', 'username')->ignore($user)],
            'email'    => ['required', Rule::unique('users', 'email')->ignore($user)],
            'role'     => 'required',
            'password' => $user->exists ? ['nullable', 'min:7', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]+$/'] : ['required', 'min:7', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]+$/'],
        ]);
        
    }
}
