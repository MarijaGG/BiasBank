<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Group;
use Illuminate\Http\Request;

class PublicAlbumController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'name');
        $direction = $request->get('direction', 'asc');
        $groupFilter = $request->get('group');

        $albums = Album::with('group');

        if ($groupFilter) {
            $albums->where('group_id', $groupFilter);
        }

        switch ($sort) {
            case 'release_date':
                $albums->orderBy('release_date', $direction);
                break;

            case 'tracks':
                $albums->orderBy('track_count', $direction);
                break;

            case 'group':
                $albums->join('groups', 'albums.group_id', '=', 'groups.id')
                    ->orderBy('groups.name', $direction)
                    ->select('albums.*');
                break;

            default:
                $albums->orderBy('name', $direction);
        }

        $albums = $albums->get();

        $groups = Group::orderBy('name')->get();

        return view('albums.index', compact('albums', 'groups', 'sort', 'direction', 'groupFilter'));
    }

    public function show(\Illuminate\Http\Request $request, \App\Models\Album $album)
    {
        $album->load(['group.members', 'photocards.member']);

        $memberFilter = $request->get('member');

        $photocards = $album->photocards;
        if ($memberFilter) {
            $photocards = $photocards->filter(function ($pc) use ($memberFilter) {
                return $pc->member_id == $memberFilter;
            })->values();
        }

        $members = $album->group->members ?? collect();

        return view('albums.show', compact('album', 'photocards', 'members', 'memberFilter'));
    }
}

