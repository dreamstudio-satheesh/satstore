<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User; // Adjust this to your User model's namespace
use Illuminate\Support\Facades\Hash;

class CreateUser extends Component
{
    public $name, $username, $mobile, $password, $role; // Updated fields

    protected $rules = [
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username',
        'mobile' => 'required|digits:10|unique:users,mobile',
        'password' => 'required|min:8',
        'role' => 'required|in:admin,staff',
    ];

    public function save()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'username' => $this->username,
            'mobile' => $this->mobile,
            'password' => Hash::make($this->password),
            'role' => $this->role,
        ]);

        session()->flash('message', 'User created successfully.');

        // Reset fields after saving
        $this->resetFields();
    }

    public function resetFields()
    {
        $this->name = '';
        $this->username = '';
        $this->mobile = '';
        $this->password = '';
        $this->role = '';
    }

    public function render()
    {
        return view('livewire.create-user');
    }
}
