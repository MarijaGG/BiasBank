<?php

namespace App\Http\Controllers\Admin;

use App\Models\Member;
use App\Models\Group;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class MemberController extends Controller
{

public function index()
{
    $members = Member::with('group')->get();
    return view('admin.members.index', compact('members'));
}

public function create()
{
    $groups = Group::all();
    return view('admin.members.create', compact('groups'));
}

public function store(Request $request)
{
    $request->validate([
        'group_id' => 'required|exists:groups,id',
        'stage_name' => 'required|max:255',
            'real_name' => 'nullable|max:255',
            'birthday' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
            'emoji' => 'nullable|string|max:10',
            'nationality' => 'nullable|string|max:100'
    ]);

    $data = $request->all();

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('members', 'public');
    }

    Member::create($data);

    return redirect()->route('admin.members.index')
        ->with('success', 'Member created successfully.');
}

public function edit(Member $member)
{
    $groups = Group::all();
    return view('admin.members.edit', compact('member', 'groups'));
}

public function update(Request $request, Member $member)
{
    $request->validate([
        'group_id' => 'required|exists:groups,id',
        'stage_name' => 'required|max:255',
            'real_name' => 'nullable|max:255',
            'birthday' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
            'emoji' => 'nullable|string|max:10',
            'nationality' => 'nullable|string|max:100'
    ]);

        $data = $request->all();

        if ($request->hasFile('image')) {

            if ($member->image) {
                Storage::disk('public')->delete($member->image);
            }

            $data['image'] = $request->file('image')->store('members', 'public');
        }

        $member->update($data);

    return redirect()->route('admin.members.index')
        ->with('success', 'Member updated successfully.');
}

public function destroy(Member $member)
{

        if ($member->image) {
            Storage::disk('public')->delete($member->image);
        }

        $member->delete();

    return redirect()->route('admin.members.index')
        ->with('success', 'Member deleted.');
}

 }

