<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmileController;

Route::post('/smile-detect', [SmileController::class, 'detectSmile'])->name('smile.detect');
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
      // Authenticated user
      $user = Auth::user();

      // Kullanıcının son yüklediği gülümseme tespiti
      $lastUpload = $user->smiles()->latest()->get();

      return view('dashboard', [
          'lastUpload' => $lastUpload,
      ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
