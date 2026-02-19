<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Group;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PublicAlbumController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'name');
        $direction = $request->get('direction', 'asc');
        $groupFilter = $request->get('group');

        $albums = Album::with('group')
            ->where(function ($q) {
                $q->whereNull('release_date')
                  ->orWhereDate('release_date', '<=', Carbon::today());
            });

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

    public function upcoming(Request $request)
    {
        $sort = $request->get('sort', 'release_date');
        $direction = $request->get('direction', 'asc');
        $groupFilter = $request->get('group');

        $albums = Album::with('group')->whereDate('release_date', '>', Carbon::today());

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
                $albums->orderBy('release_date', $direction);
        }

        $albums = $albums->get();

        $groups = Group::orderBy('name')->get();

        $upcoming = true;

        return view('albums.index', compact('albums', 'groups', 'sort', 'direction', 'groupFilter', 'upcoming'));
    }

    public function show(\Illuminate\Http\Request $request, \App\Models\Album $album)
    {
        $album->load(['group.members', 'photocards.member']);

        $memberFilter = $request->get('member');
        $versionFilter = $request->get('version');

        $photocards = $album->photocards;
        if ($memberFilter) {
            $photocards = $photocards->filter(function ($pc) use ($memberFilter) {
                return $pc->member_id == $memberFilter;
            })->values();
        }

        if ($versionFilter) {
            $photocards = $photocards->filter(function ($pc) use ($versionFilter) {
                return (string)($pc->version ?? '') === (string)$versionFilter;
            })->values();
        }

        $members = $album->group->members ?? collect();

        $versions = $album->photocards->pluck('version')->filter()->unique()->values();

        return view('albums.show', compact('album', 'photocards', 'members', 'memberFilter', 'versionFilter', 'versions'));
    }
}

