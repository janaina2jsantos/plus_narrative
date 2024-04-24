<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class Sidebar extends Component
{
    public $userName, $userRole, $notifications;

    public function mount()
    {   
        $this->userName = Auth::user()->first_name . " " . Auth::user()->last_name;
        $this->userRole = ucwords(Auth::user()->getRoleNames()->first());
        $this->notifications = Notification::where('notifiable_id', Auth::user()->id)->where('read_at', null)->orderBy('created_at', 'DESC')->get();
    }

    public function render()
    {
        return view('livewire.sidebar');
    }
}
