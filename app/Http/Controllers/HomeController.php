<?php
namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        // Obtener a quienes seguimos
        $ids = auth()->user()->followings->pluck('id')->toArray();
        $posts = Post::whereIn('user_id', $ids)->latest()->paginate(20);

        // Obtener todos los usuarios (limitado a 25)
        $allUsers = User::where('id', '!=', auth()->id())
            ->limit(25)
            ->get();

        // Buscar usuarios si hay un término de búsqueda
        $searchUsers = $request->has('search')
            ? User::where('username', 'LIKE', '%' . $request->search . '%')
                ->orWhere('name', 'LIKE', '%' . $request->search . '%')
                ->get()
            : null;

        return view('home', [
            'posts' => $posts,
            'allUsers' => $allUsers,
            'searchUsers' => $searchUsers
        ]);
    }
}
