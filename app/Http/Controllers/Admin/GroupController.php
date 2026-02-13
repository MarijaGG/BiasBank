<?php

namespace App\Http\Controllers\Admin;
use App\Models\Group;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GroupController extends Controller
{

public function index()
{
    $groups = Group::all();
    return view('admin.groups.index', compact('groups'));
}

public function create()
{
    return view('admin.groups.create');
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'debut_date' => 'nullable|date',
    ]);

    Group::create($request->all());

    return redirect()->route('admin.groups.index')
        ->with('success', 'Group created successfully.');
}

public function edit(Group $group)
{
    return view('admin.groups.edit', compact('group'));
}

public function update(Request $request, Group $group)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'debut_date' => 'nullable|date',
    ]);

    $group->update($request->all());

    return redirect()->route('admin.groups.index')
        ->with('success', 'Group updated successfully.');
}

public function destroy(Group $group)
{
    $group->delete();

    return redirect()->route('admin.groups.index')
        ->with('success', 'Group deleted.');
}

}
