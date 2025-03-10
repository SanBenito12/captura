<?php
namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ListarPost extends Component
{
    public $posts;
    public $users;

    public function __construct($posts, $users = null)
    {
        $this->posts = $posts;
        $this->users = $users;
    }

    public function render(): View|Closure|string
    {
        return view('components.listar-post', [
            'users' => $this->users
        ]);
    }
}
