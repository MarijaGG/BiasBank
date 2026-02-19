<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupListController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'name');
        $direction = $request->get('direction', 'asc');

        $groups = Group::withCount('members');

        switch ($sort) {
            case 'debut':
                $groups->orderBy('debut_date', $direction);
                break;

            case 'members':
                $groups->orderBy('members_count', $direction);
                break;

            default:
                $groups->orderBy('name', $direction);
        }

        $groups = $groups->get();

        return view('groups.index', compact('groups', 'sort', 'direction'));
    }

    public function show(Group $group)
    {
        $group->load(['members', 'albums']);

        return view('groups.show', compact('group'));
    }

    public function members(Group $group)
    {
        $members = $group->members()->orderBy('stage_name')->get(['id', 'stage_name', 'name']);

        $result = $members->map(function ($m) {
            return ['id' => $m->id, 'name' => $m->stage_name ?? $m->name];
        });

        return response()->json($result);
    }

}
