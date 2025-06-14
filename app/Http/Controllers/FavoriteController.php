<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function addFavorite($id)
    {
        $user = Auth::user();

        $favorite = Favorite::where('user_id', $user->id)
            ->where('image_id', $id)
            ->first();

        if ($favorite) {
            return back()->with('success', 'Already in favorites');
        }

        Favorite::create([
            'user_id' => $user->id,
            'image_id' => $id
        ]);
        return back()->with('success', 'Added to favorites');
    }

    public function deleteFavorite($id)
    {
        $user = Auth::user();

        $favorite = Favorite::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return back()->with('success', 'Removed from favorites');
        } else {
            return back()->with('error', 'Favorite not found');
        }
    }

    public function myFavorites()
    {
        $favorites = Favorite::with('image')->where('user_id', Auth::id())->get();
        return view('favorite', compact('favorites'));
    }
}
