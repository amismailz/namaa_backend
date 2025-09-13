<?php

use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\Basic\HomeController;
use Illuminate\Support\Facades\Mail;



Route::get('/test-mailjet', function () {
    Mail::raw('This is a test email via Mailjet!', function ($message) {
        $message->to('ahmedhabibwork80@gmail.com')
            ->subject('Test Mailjet');
    });

    return 'Sent!';
});

Route::get('/', function () {
    return redirect()->route('filament.dashboard.auth.login');
});



