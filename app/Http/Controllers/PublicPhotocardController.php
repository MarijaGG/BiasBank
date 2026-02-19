<?php

namespace App\Http\Controllers;

use App\Models\Photocard;
use App\Models\UserPhotocard;
use Illuminate\Http\Request;

class PublicPhotocardController extends Controller
{
    public function show(Photocard $photocard)
    {
        $photocard->load(['member', 'album']);

        $ownedCount = 0;
        $want = false;
        if (auth()->check()) {
            $ownedCount = auth()->user()->userPhotocards()->where('photocard_id', $photocard->id)->where('status', 'have')->count();
            $want = auth()->user()->userPhotocards()->where('photocard_id', $photocard->id)->where('status', 'want')->exists();
        }

        return view('photocards.show', compact('photocard', 'ownedCount', 'want'));
    }

    public function collect(Request $request, Photocard $photocard)
    {
        $request->validate([
            'condition' => 'required|string|max:255',
            'purchase_price' => 'nullable|numeric',
        ]);

        $user = $request->user();

        UserPhotocard::create([
            'user_id' => $user->id,
            'photocard_id' => $photocard->id,
            'purchase_price' => $request->input('purchase_price'),
            'condition' => $request->input('condition'),
            'status' => 'have',
        ]);

        $purchasePrice = $request->input('purchase_price');
        if (!is_null($purchasePrice)) {
            $avg = UserPhotocard::where('photocard_id', $photocard->id)
                ->whereNotNull('purchase_price')
                ->avg('purchase_price');

            $photocard->average_price = $avg !== null ? round($avg, 2) : null;
            $photocard->save();
        }

        return redirect()->route('dashboard')->with('status', 'Photocard added to your collection.');
    }

    public function want(Request $request, Photocard $photocard)
    {
        $user = $request->user();
        
        $exists = UserPhotocard::where('user_id', $user->id)
            ->where('photocard_id', $photocard->id)
            ->exists();

        if (!$exists) {
            UserPhotocard::create([
                'user_id' => $user->id,
                'photocard_id' => $photocard->id,
                'status' => 'want',
            ]);
        }

        return back()->with('status', 'Added to your want list.');
    }
}
