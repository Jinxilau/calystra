<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggle($id)
    {
        $user = Auth::user();

        $favorite = Favorite::where('user_id', $user->id)
                            ->where('image_id', $id)
                            ->first();

        if ($favorite) {
            $favorite->delete();
            return back()->with('success', 'Removed from favorites');
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'image_id' => $id
            ]);
            return back()->with('success', 'Added to favorites');
        }
    }

    public function myFavorites()
    {
        $favorites = Favorite::with('image')->where('user_id', Auth::id())->get();
        return view('favorites.index', compact('favorites'));
    }
}
