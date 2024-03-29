<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

# Todo group all routes & create controller
Route::get('/redirect', function (Request $request) {
    $request->session()->put('state', $state = Str::random(40));
    $request->session()->put('code_verifier', $code_verifier = Str::random(128));

    $code_challenge = strtr(rtrim(base64_encode(hash('sha256', $code_verifier, true)), '='), '+/', '-_');

    $query = http_build_query([
        'client_id' => $request->client_id,
        'redirect_uri' => $request->redirect_uri,
        'response_type' => 'code',
        'state' => $state,
        'code_challenge' => $code_challenge,
        'code_challenge_method' => 'S256',
    ]);

    return redirect('http://taskair.local/oauth/authorize?' . $query);
});

Route::get('/callback', function (Request $request) {
    $state = $request->session()->pull('state');
    $code_verifier = $request->session()->pull('code_verifier');

    throw_unless(
        strlen($state) > 0 && $state === $request->state,
        InvalidArgumentException::class,
        'Invalid state value.'
    );

    $data = $request->only(['client_id', 'redirect_uri', 'code']);
    $data['grant_type'] = 'authorization_code';
    $data['code_verifier'] = $code_verifier;

    return view('callback', [
        'data' => $data
    ]);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard/clients', function (Request $request) {
    return view('clients', [
        'clients' => $request->user()->clients
    ]);
})->middleware(['auth'])->name('dashboard.clients');

Route::get('/users', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get('/logout', function (Request $request) {
    $request->user()->token()->revoke();
    $request->user()->token()->delete();

    return response()->json([
        'message' => 'Logout success'
    ]);
})->middleware('auth:api');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
