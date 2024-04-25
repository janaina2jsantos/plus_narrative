<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\UserRequest;

class Users extends Component
{
    public $userId, $roleId, $firstName, $lastName, $email, $password, $passwordConfirm, $title, $editUrl;

    protected function rules()
    {
        return (new UserRequest())->rules($this->editUrl, $this->userId);
    }

    protected function messages()
    {
        return (new UserRequest())->messages();
    }

    public function mount($id=null)
    {
        if ($id) {
            $user = User::findOrFail($id);
            $this->userId = $user->id;
            $this->firstName = $user->first_name;
            $this->lastName = $user->last_name;
            $this->email = $user->email;
            $this->roleId = $user->roles->pluck('id')[0];
            $this->editUrl = $_SERVER['REQUEST_URI'];
        }
    }

    public function store()
    {
        $this->validate();
        $this->dispatchBrowserEvent('scrollToTop');

        try {
            $user = User::create([
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'email' => $this->email,
                'email_verified_at' => now(),
                'password' => bcrypt($this->password),
                'remember_token' => Str::random(10)
            ]);

            $user->assignRole($this->roleId);
            return redirect()->route('dashboard')->with('success', 'User created successfully.');
        }
        catch(\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong while creating the user! '.$e->getMessage());
        }
        // reset form fields
        $this->reset(['firstName', 'lastName', 'email', 'password', 'passwordConfirm']);
    }

    public function update()
    {
        if (Gate::allows('update', Auth::user())) {
            $this->validate();
            $this->dispatchBrowserEvent('scrollToTop');

            try {
                $user = User::findOrFail($this->userId);
                $user->update([
                    'first_name' => $this->firstName,
                    'last_name' => $this->lastName,
                    'email' => $this->email,
                    'password' => isset($this->password) ? bcrypt($this->password) : $user->password
                ]);

                $user->syncRoles([$this->roleId]);
                return redirect()->back()->with('success', 'User updated successfully.');
            }
            catch(\Exception $e) {
                return redirect()->back()->with('error', 'Something went wrong while updating the user!');
            }
        }
        else {
            return redirect()->back()->with('error', 'You are not authorized to update this user!');
        }
    
        $this->mount();
    }

    public function render()
    {
        $roles = Role::all();
        return view('livewire.users', ['roles' => $roles]);
    }
}
