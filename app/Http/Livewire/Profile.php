<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Profile extends Component
{
    public $userId, $firstName, $lastName, $email, $password, $passwordConfirm;
    public $title01 = "Update profile";
    public $title02 = "Delete Account";
    protected $listeners = ['delete'];

     protected $rules = [
        'firstName' => 'required|string|min:3',
        'lastName' => 'required|string|min:3',
        'email' => 'required|email',
        'password' => 'nullable|min:8',
        'passwordConfirm' => 'same:password'
    ];

    public function mount()
    {
        $user = Auth()->user();
        $this->userId = $user->id;
        $this->firstName = $user->first_name;
        $this->lastName = $user->last_name;
        $this->email = $user->email;
    }

    public function submit()
    {
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
            return redirect()->back()->with('success', 'Your profile has been updated successfully.');
        }
        catch(\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong while updating the user!');
        }

        $this->mount($user);
        $this->reset(['password', 'passwordConfirm']);
    }
    
    public function deleteConfirm($id)
    {
        $this->dispatchBrowserEvent('swal:confirm', [
            'type' => 'warning',
            'title' => 'Are you sure?',
            'text' => 'You are about to delete this account permanently.',
            'id' => $id
        ]);
    }

    public function delete($id)
    {   
        try {
            // Delete the user 
            $user = User::findOrFail($id);

            if ($user->notifications()->count()) {
                $user->notifications()->delete();
            }

            $user->delete();
            // Log the user out
            Auth::logout();
            return redirect()->route('login')->with('success', 'Your account has been deleted successfully.');
        }
        catch(\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong while deleting your account!');
        }
    }

    public function render()
    {
        return view('livewire.profile');
    }
}
