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
                $items = $items->sortBy('created_at', SORT_REGULAR, $direction === 'desc')->values();
            }

            return $items;
        };

        $haveItems = $fetchItems('have');
        $wantItems = $fetchItems('want');

        $allHaveItems = $user->userPhotocards()->with('photocard')->where('status', 'have')->get();
        $collectionTotal = $allHaveItems->sum(function ($item) {
            return $item->purchase_price ?? ($item->photocard->average_price ?? 0);
        });

        $groups = Group::with('members')->orderBy('name')->get();
     
        $membersQuery = Member::orderBy('stage_name');
        if ($groupFilter) {
            $membersQuery->where('group_id', $groupFilter);
        }
        $members = $membersQuery->get();

        return view('collection.index', compact('haveItems', 'wantItems', 'groups', 'members', 'section', 'sort', 'direction', 'groupFilter', 'memberFilter', 'collectionTotal'));
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

    public function update(Request $request, UserPhotocard $userPhotocard)
    {
        $user = $request->user();

        if ($userPhotocard->user_id !== $user->id) {
            abort(403);
        }

        $data = $request->validate([
            'purchase_price' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:have,want'],
        ]);

        $userPhotocard->purchase_price = $data['purchase_price'] ?? null;
        $userPhotocard->status = $data['status'];
        $userPhotocard->save();

        return back()->with('status', 'Updated.');
    }
}
