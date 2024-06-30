<?php

use App\Http\Controllers\Mail\PasswordResetController;


Route::post('SendMail', [PasswordResetController::class, 'SendMail']);
Route::get('password/reset/{token}', [PasswordResetController::class, 'showResetForm']);
Route::post('password/reset', [PasswordResetController::class, 'reset']);