<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserPhotocard;
use App\Models\Group;
use App\Models\Member;

class CollectionController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $groupFilter = $request->get('group');
        $memberFilter = $request->get('member');
        $section = $request->get('section', null);
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');

        // Helper to fetch items by status and apply filters/sorting
        $fetchItems = function ($status) use ($user, $groupFilter, $memberFilter, $sort, $direction) {
            $q = $user->userPhotocards()->with(['photocard.member', 'photocard.album'])->where('status', $status);

            if ($groupFilter) {
                $q->whereHas('photocard.album', function ($qq) use ($groupFilter) {
                    $qq->where('group_id', $groupFilter);
                });
            }

            if ($memberFilter) {
                $q->whereHas('photocard', function ($qq) use ($memberFilter) {
                    $qq->where('member_id', $memberFilter);
                });
            }

            $items = $q->get();

            // Collection-based sorting for member/album/price
            if ($sort === 'member') {
                $items = $items->sortBy(function ($up) {
                    return $up->photocard->member->stage_name ?? $up->photocard->member->name ?? '';
                }, SORT_REGULAR, $direction === 'desc')->values();
            } elseif ($sort === 'album') {
                $items = $items->sortBy(function ($up) {
                    return $up->photocard->album->name ?? '';
                }, SORT_REGULAR, $direction === 'desc')->values();
            } elseif ($sort === 'price') {
                $items = $items->sortBy(function ($up) {
                    return $up->purchase_price ?? ($up->photocard->average_price ?? 0);
                }, SORT_REGULAR, $direction === 'desc')->values();
            } else {
                // default: sort by created_at on the pivot
                $items = $items->sortBy('created_at', SORT_REGULAR, $direction === 'desc')->values();
            }

            return $items;
        };

        $haveItems = $fetchItems('have');
        $wantItems = $fetchItems('want');

        $groups = Group::orderBy('name')->get();
        // If a group filter is set, only return members for that group
        $membersQuery = Member::orderBy('stage_name');
        if ($groupFilter) {
            $membersQuery->where('group_id', $groupFilter);
        }
        $members = $membersQuery->get();

        return view('collection.index', compact('haveItems', 'wantItems', 'groups', 'members', 'section', 'sort', 'direction', 'groupFilter', 'memberFilter'));
    }

    public function destroy(Request $request, UserPhotocard $userPhotocard)
    {
        $user = $request->user();

        if ($userPhotocard->user_id !== $user->id) {
            abort(403);
        }

        $userPhotocard->delete();

        return back()->with('status', 'Removed from your collection.');
    }
}
