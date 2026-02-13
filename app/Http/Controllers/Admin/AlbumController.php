<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{

    public function index()
    {
        $albums = Album::with('group')->get();
        return view('admin.albums.index', compact('albums'));
    }

    public function create()
    {
        $groups = Group::all();
        return view('admin.albums.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'name' => 'required|string|max:255',
            'release_date' => 'nullable|date',
            'track_count' => 'nullable|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('albums', 'public');
        }

        Album::create($data);

        return redirect()->route('admin.albums.index')
            ->with('success', 'Album created successfully.');
    }

    public function edit(Album $album)
    {
        $groups = Group::all();
        return view('admin.albums.edit', compact('album', 'groups'));
    }

    public function update(Request $request, Album $album)
    {
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'name' => 'required|string|max:255',
            'release_date' => 'nullable|date',
            'track_count' => 'nullable|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($album->image) {
                Storage::disk('public')->delete($album->image);
            }
            $data['image'] = $request->file('image')->store('albums', 'public');
        }

        $album->update($data);

        return redirect()->route('admin.albums.index')
            ->with('success', 'Album updated successfully.');
    }

    public function destroy(Album $album)
    {
        if ($album->image) {
            Storage::disk('public')->delete($album->image);
        }
        $album->delete();

        return redirect()->route('admin.albums.index')
            ->with('success', 'Album deleted.');
    }
}
