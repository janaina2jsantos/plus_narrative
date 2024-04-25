<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class Dashboard extends Component
{
    public $usersCount, $income, $invoices, $filter;
    private $users;
    protected $listeners = ['delete', 'searchUsers'];

    public function mount()
    {   
        $this->loadUsers();
        $this->usersCount = User::all()->count();
        $this->income = "2,873.88";
        $this->invoices = "75";
        $this->entries = Auth::user()->login_count;
        $this->notificationsCount = Notification::where('notifiable_id', Auth::user()->id)->where('read_at', null)->count();
    }

    public function deleteConfirm($id)
    {
        $this->mount();
        
        if (Gate::allows('delete', Auth::user())) {
            $this->dispatchBrowserEvent('swal:confirm', [
                'type' => 'warning',
                'title' => 'Are you sure?',
                'text' => 'You are about to delete this user.',
                'id' => $id
            ]);
        }
        else {
            return redirect()->back()->with('error', 'You are not authorized to delete this user!');
        }
    }

    public function delete($id)
    {  
        try {
            $user = User::findOrFail($id);

            if (Gate::allows('delete', Auth::user())) {
                $user->delete();
                $this->dispatchBrowserEvent('scrollToTop');
                $this->mount();
                return redirect()->back()->with('success', 'User deleted successfully.');
            }
            else {
                return redirect()->back()->with('error', 'You are not authorized to delete this user!');
            }
        }
        catch(\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong while deleting the user!');
        }
    }

    public function loadUsers()
    {
        $this->users = User::orderBy('id', 'DESC')->paginate(5); 
    }

    public function searchUsers()
    {
        if (!isset($this->filter) || empty($this->filter)) {
            $this->loadUsers();
            return;
        }

        $this->users = User::where('first_name', 'like', '%' . $this->filter . '%')
            ->orWhere('last_name', 'like', '%' . $this->filter . '%')->paginate(5); 
    }

    public function render()
    {
        $users = $this->users;
        return view('livewire.dashboard', ['users' => $users]);
    }
}
