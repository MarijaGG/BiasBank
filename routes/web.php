<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\GroupController as AdminGroupController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\AlbumController;
use App\Http\Controllers\Admin\PhotocardController;

use App\Http\Controllers\PublicGroupController;
use App\Http\Controllers\PublicAlbumController;
use App\Http\Controllers\GroupListController;
use App\Http\Controllers\PublicMemberController;
use App\Http\Controllers\PublicPhotocardController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $collection = [];
    if (auth()->check()) {
        $collection = auth()->user()->userPhotocards()->with(['photocard.member', 'photocard.album'])->get();
    }

    $collectionTotal = 0;
    if (!empty($collection) && $collection->count()) {
        $collectionTotal = $collection->sum(function ($item) {
            return $item->purchase_price ?? ($item->photocard->average_price ?? 0);
        });
    }

    return view('dashboard', compact('collection', 'collectionTotal'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::get('/groups', [GroupListController::class, 'index'])->name('groups.index');
Route::get('/groups/{group}', [GroupListController::class, 'show'])->name('groups.show');
Route::get('/albums', [PublicAlbumController::class, 'index'])->name('albums.index');
Route::get('/albums/upcoming', [PublicAlbumController::class, 'upcoming'])->name('albums.upcoming');
Route::get('/albums/{album}', [PublicAlbumController::class, 'show'])->name('albums.show');
Route::get('/members/{member}', [PublicMemberController::class, 'show'])->name('members.show');
Route::get('/photocards/{photocard}', [PublicPhotocardController::class, 'show'])->name('photocards.show');
Route::post('/photocards/{photocard}/collect', [PublicPhotocardController::class, 'collect'])->middleware('auth')->name('photocards.collect');
Route::post('/photocards/{photocard}/want', [PublicPhotocardController::class, 'want'])->middleware('auth')->name('photocards.want');

Route::middleware('auth')->group(function () {
    Route::get('/collection', [\App\Http\Controllers\CollectionController::class, 'index'])->name('collection.index');
    Route::delete('/collection/{userPhotocard}', [\App\Http\Controllers\CollectionController::class, 'destroy'])->name('collection.destroy');
});


Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::resource('groups', AdminGroupController::class);

        Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('members', MemberController::class);
        Route::resource('albums', AlbumController::class);
        Route::resource('photocards', PhotocardController::class);
    });
