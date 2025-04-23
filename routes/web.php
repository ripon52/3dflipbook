<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BoothController;

Route::get('/', [PageController::class, 'book3D'])->name('home');

Route::name("admin.")->group(function () {
    Route::resource("booths", BoothController::class);
});

Route::get('/api/booths/{id}', function ($id) {
    $booth = App\Models\Booth::where('code', $id)->firstOrFail();
    return response()->json([
        'name' => $booth->name,
        'status' => $booth->status,
        'type' => $booth->type,
        'description' => $booth->description,
    ]);
});

