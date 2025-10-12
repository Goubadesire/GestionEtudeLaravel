<?php

use App\Http\Controllers\MatiereController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SemestreController;
use App\Http\Controllers\EmploiDuTempsController;
use App\Http\Controllers\DashboardController;



use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::middleware(['auth'])->group(function () {
    // Ressources déjà en place
    Route::resource('semestres', SemestreController::class);
    Route::resource('matieres', MatiereController::class);

    // Ajout futur pour Notes, Planning/Emploi du temps, etc.
    Route::middleware(['auth'])->group(function () {
    Route::resource('notes', NoteController::class);
});
          // à créer plus tard
    //Route::resource('planning', EmploiDuTempsController::class); // à créer plus tard
    Route::resource('planning', EmploiDuTempsController::class)
    ->parameters(['planning' => 'planning']);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');



});



require __DIR__.'/auth.php';
