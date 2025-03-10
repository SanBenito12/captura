<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;

class UserSearch extends Component
{
    public $search = '';

    public function render()
    {
        $users = $this->search
            ? User::where('name', 'LIKE', "%{$this->search}%")
                ->orWhere('username', 'LIKE', "%{$this->search}%")
                ->limit(10)
                ->get()
            : collect();

        return view('livewire.user-search', [
            'users' => $users
        ]);
    }
}
