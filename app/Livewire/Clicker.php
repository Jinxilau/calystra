<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class Clicker extends Component
{
    public $count = 0;

    public function increment()
    {
        dump('clicked');
    }
    
    public function render()
    {
        $title = 'test';

        $user = User::all();

        return view('livewire.clicker', [
            'title' => $title,
            'user' => $user,
        ]);
    }
}
