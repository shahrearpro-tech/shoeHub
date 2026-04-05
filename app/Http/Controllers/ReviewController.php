<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|between:1,5',
            'review_text' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'product_id' => $request->product_id,
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'review_text' => $request->review_text,
            'status' => 'pending',
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Review submitted for approval']);
        }
        return back()->with('success', 'Review submitted for approval');
    }
}