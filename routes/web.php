<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Models\stream;
use App\Http\Controllers\StreamController;
use App\Models\student;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('content-pages.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
// Route::get('main', function () {
//     return view('content-pages.dashboard');
// });
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


// Route::get('students', function () {
//     return view('content-pages.students.index');
// })->name('students.index');

Route::resource('students', StudentController::class);
// Route::post('students/updates/{id}', [StudentController::class, 'update'])->name("students.update");

Route::resource('streams', StreamController::class);
Route::get('test', function () {
    $students = student::all();
    $html = View::make('profile.partials._table', compact('students'))->render();

    return response()->json(['success' => true, 'html' => $html]);
})->name('student.test');

Route::get('stream', function () {
    $stream = Stream::all();
    $html = View::make('profile.partials._table2', compact('stream'))->render();

    return response()->json(['success' => true, 'html' => $html]);
})->name('stream.show');

