<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Notification extends Component
{
    public $notification;
    public $title = "Notification";

    public function mount($slug)
    {   
        $this->notification = \App\Models\Notification::where('data', 'LIKE', '%'.$slug.'%')->get();
        $this->markAsRead($this->notification[0]);
        $this->notification = json_decode($this->notification[0]->data, true);
    }

    public function markAsRead($notification)
    {
        $notification->update(['read_at' => now()]);
    }

    public function render()
    {
        return view('livewire.notification');
    }
}
