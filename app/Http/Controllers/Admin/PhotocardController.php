<?php

namespace App\Http\Controllers\Admin;

use App\Models\Photocard;
use App\Models\Member;
use App\Models\Album;
use App\Models\Group;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PhotocardController extends Controller
{
    public function index()
    {
        $photocards = Photocard::with(['member.group', 'album'])->get();

        return view('admin.photocards.index', compact('photocards'));
    }

    public function create()
    {
        return view('admin.photocards.create', [
            'groups' => Group::all(),
            'members' => Member::all(),
            'albums' => Album::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'album_id' => 'required|exists:albums,id',
            'version' => 'nullable|string|max:255',
            'average_price' => 'nullable|numeric|min:0',
            'photo' => 'required|image|max:2048',
        ]);

        $path = $request->file('photo')->store('photocards', 'public');

        Photocard::create([
            'member_id' => $request->member_id,
            'album_id' => $request->album_id,
            'version' => $request->version,
            'average_price' => $request->average_price,
            'photo' => $path,
        ]);

        return redirect()->route('admin.photocards.index');
    }

    public function edit(Photocard $photocard)
    {
        return view('admin.photocards.edit', [
            'photocard' => $photocard,
            'groups' => Group::all(),
            'members' => Member::all(),
            'albums' => Album::all(),
        ]);
    }

    public function update(Request $request, Photocard $photocard)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'album_id' => 'required|exists:albums,id',
            'version' => 'nullable|string|max:255',
            'average_price' => 'nullable|numeric|min:0',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($photocard->photo) {
                Storage::disk('public')->delete($photocard->photo);
            }

            $photocard->photo = $request->file('photo')->store('photocards', 'public');
        }

        $photocard->update([
            'member_id' => $request->member_id,
            'album_id' => $request->album_id,
            'version' => $request->version,
            'average_price' => $request->average_price,
            'photo' => $photocard->photo,
        ]);

        return redirect()->route('admin.photocards.index');
    }

    public function destroy(Photocard $photocard)
    {
        if ($photocard->photo) {
            Storage::disk('public')->delete($photocard->photo);
        }

        $photocard->delete();

        return redirect()->route('admin.photocards.index');
    }
}


