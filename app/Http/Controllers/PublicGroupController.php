<?php

namespace App\Http\Controllers;

use App\Models\Group;

class PublicGroupController extends Controller
{
    public function index()
    {
        $groups = Group::with('members')->get();

        return view('groups.index', compact('groups'));
    }
}

