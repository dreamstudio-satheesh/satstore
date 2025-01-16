<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User; // Adjust this to your User model's namespace
use Illuminate\Support\Facades\Hash;

class UserManagement extends Component
{
    use WithPagination;

    public $userId; // To hold the ID of the user being edited
    public $name, $username, $mobile, $role; // Updated fields for editing
    public $confirmingDelete = false; // Flag for delete confirmation

    protected $rules = [
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username',
        'mobile' => 'required|digits:10|unique:users,mobile',
        'role' => 'required|in:admin,staff',
    ];

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->username = $user->username;
        $this->mobile = $user->mobile;
        $this->role = $user->role;
    }

    public function save()
    {
        $this->validate();

        if ($this->userId) {
            $user = User::findOrFail($this->userId);
            $user->update([
                'name' => $this->name,
                'username' => $this->username,
                'mobile' => $this->mobile,
                'role' => $this->role,
            ]);
        }

        $this->resetFields();
        session()->flash('message', 'User updated successfully.');
    }

    public function delete($id)
    {
        // User::findOrFail($id)->delete();
        session()->flash('message', 'User deleted successfully.');
    }

    public function resetFields()
    {
        $this->userId = null;
        $this->name = '';
        $this->username = '';
        $this->mobile = '';
        $this->role = '';
    }

    public function render()
    {
        return view('livewire.user-management', [
            'users' => User::paginate(10),
        ]);
    }
}
