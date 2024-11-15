<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewPetNotification;

class PetController extends Controller
{
    public function index(Request $request)
    {
        $pets = Pet::query();

        if ($request->has('type')) {
            $pets->where('type', $request->type);
        }

        return view('pets.index', ['pets' => $pets->get()]);
    }

    public function show($id)
    {
        $pet = Pet::findOrFail($id);
        return view('pets.show', ['pet' => $pet]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'age' => 'required|integer',
        ]);

        $pet = Pet::create($request->all());
        $this->notifyUsersAboutNewPet($pet);
        return redirect()->route('pets.index');
    }

    public function markAsAdopted($id)
    {
        $pet = Pet::findOrFail($id);
        $pet->status = 'adopted';
        $pet->save();

        AdoptionLog::create([
            'pet_id' => $pet->id,
            'user_id' => auth()->id(),
            'adopted_at' => now(),
            'status' => 'adopted',
        ]);

        return redirect()->route('pets.index');
    }

    protected function notifyUsersAboutNewPet(Pet $pet)
    {
        $subscribedUsers = Subscription::where('animal_type', $pet->type)->get();
        foreach ($subscribedUsers as $subscription) {
            Mail::to($subscription->user->email)->send(new NewPetNotification($pet));
        }
    }
}
