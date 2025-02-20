<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Accountant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ReviewsController extends Controller
{
    public function index()
    {
        // Obtener todas las reseñas con los datos del usuario y contador asociados
        $reviews = Review::with(['user', 'accountant'])->get();

        // Pasar las reseñas a la vista
        return view('reviews.reviews', compact('reviews'));
    }
    
    public function myReviews()
    {
        $reviews = Review::with('accountant')
                        ->where('user_id', Auth::id())
                        ->get();
    
        $accountants = Accountant::all(); // Obtener todos los contadores disponibles
    
        return view('reviews.list', compact('reviews', 'accountants'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'accountant_id' => 'required|exists:accountants,id',
            'rating' => 'required|in:1,2,3,4,5',
            'comment' => 'nullable|string',
        ]);
    
        $review = new Review();
        $review->user_id = Auth::id(); // Asigna el ID del usuario autenticado
        $review->accountant_id = $request->accountant_id;
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->save();
    
        return redirect()->back()->with('success', 'Reseña añadida correctamente.');
    }    

    public function show($id)
    {
        $review = Review::with(['user', 'accountant'])->findOrFail($id);
        return response()->json($review);
    }

    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        $review->update($request->all());
        return response()->json($review);
    }

    public function destroy($id)
    {
        Review::destroy($id);
        return response()->json(null, 204);
    }
}
