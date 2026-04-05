<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $subscriber = NewsletterSubscriber::firstOrCreate(
            ['email' => $request->email],
            ['status' => 'active']
        );

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you for subscribing!'
            ]);
        }

        return back()->with('success', 'Thank you for subscribing!');
    }
}
