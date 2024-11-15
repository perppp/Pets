<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'animal_type' => 'required',
        ]);

        $subscription = Subscription::firstOrCreate([
            'user_id' => auth()->id(),
            'animal_type' => $request->animal_type,
        ]);

        return back()->with('message', 'You are now subscribed to notifications for ' . $request->animal_type);
    }

    public function unsubscribe($id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->delete();

        return back()->with('message', 'You have unsubscribed from notifications');
    }
}