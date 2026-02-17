<?php

namespace App\Http\Controllers;

use App\Models\Member;

class PublicMemberController extends Controller
{
    public function show(Member $member)
    {
        $member->load(['group', 'photocards']);

        $ownedCounts = [];
        if (auth()->check()) {
            $userPhotocards = auth()->user()->userPhotocards()->whereIn('photocard_id', $member->photocards->pluck('id'))->get();
            foreach ($userPhotocards as $up) {
                $ownedCounts[$up->photocard_id] = ($ownedCounts[$up->photocard_id] ?? 0) + 1;
            }
        }

        return view('members.show', compact('member', 'ownedCounts'));
    }
}
