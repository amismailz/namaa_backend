<?php

use AnourValar\EloquentSerialize\Service;
use App\Http\Controllers\API\V1\AuthenticationController;
use App\Http\Controllers\API\V1\BlogController;
use App\Http\Controllers\API\V1\BookingController;
use App\Http\Controllers\API\V1\CategoryController;
use App\Http\Controllers\API\V1\CountactUsController;
use App\Http\Controllers\API\V1\FaqController;
use App\Http\Controllers\API\V1\MovementController;
use App\Http\Controllers\API\V1\PointController;
use App\Http\Controllers\API\V1\RangeController;
use App\Http\Controllers\API\V1\ReviewController;
use App\Http\Controllers\API\V1\SocietyReviewController;
use App\Http\Controllers\API\V1\EvaluationController;
use App\Http\Controllers\API\V1\ContestController;
use App\Http\Controllers\API\V1\HomeController;
use App\Http\Controllers\API\V1\HostingPlanController;
use App\Http\Controllers\API\V1\SeoController;
use App\Http\Controllers\API\V1\ServiceController;
use App\Http\Controllers\API\V1\TripController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;

Route::group([
    'middleware' => [
        'api',
        'localization',
        'forceJson'
    ],
    'prefix' => 'v1',
    'name' => 'api.',
], function () {

    Route::group([], function () {
        Route::get('/form/client-request', [CountactUsController::class, 'getFormClientRequest']);
        Route::post('/submit/client-request', [CountactUsController::class, 'submitClientRequest']);
        Route::get('/faqs', [FaqController::class, 'getAllFaqs']);
        Route::get('/service-blog/{slug}', [BlogController::class, 'getBlogOrServiceBySlug']);
        Route::get('/home', [HomeController::class, 'home']);
        Route::get('/contact-info', [HomeController::class, 'contactInfo']);
        Route::get('/about-us', [HomeController::class, 'getAboutUs']);
        Route::get('/blogs', [BlogController::class, 'getAllBlogs']);
        Route::get('/site-map/blogs', [BlogController::class, 'getBlogsSiteMap']);
        Route::get('/blogs/{slug}', [BlogController::class, 'getBlog']);
        Route::get('navbar/services', [ServiceController::class, 'getAllServicesForNavBar']);
        Route::get('/services', [ServiceController::class, 'getAllServices']);
        Route::get('/service/{slug}', [ServiceController::class, 'getServiceBySlug']);
        Route::get('/service/{slug}/sub-services', [ServiceController::class, 'getSubServicesForService']);
        Route::get('/sub-service/{slug}', [ServiceController::class, 'getSubServiceBySlug']);
        Route::get('/services', [ServiceController::class, 'getAllServices']);
        Route::get('/our-works', [ServiceController::class, 'getAllWorks']);
        Route::get('/seo', [SeoController::class, 'getAllSeos']);
        Route::get('/seo/{slug}', [SeoController::class, 'getSeo']);
        Route::get('/hosting-plans', [HostingPlanController::class, 'getAllHostingPlans']);
        Route::get('/jobs', [ServiceController::class, 'getAllJobs']);
        Route::post('/submit/contact-us', [CountactUsController::class, 'submitContactUs']);
        Route::post('/submit/subscription', [CountactUsController::class, 'submitSubscription']);
        Route::get('/form/job-application', [CountactUsController::class, 'getFormJobApplication']);
        Route::post('/submit/job-application', [CountactUsController::class, 'submitJobApplication']);


        Route::get('/form/hosting-plan-request', [CountactUsController::class, 'getFormHostingPlanRequest']);
        Route::post('/submit/hosting-plan-request', [CountactUsController::class, 'submitHostingPlanRequest']);
    });


    Route::group([
        'middleware' => [
            'auth:sanctum',
            'checkActiveStatus',
        ],
        'name' => 'auth.',
    ], function () {});

    Route::group([
        'middleware' => [
            // 'guest:sanctum'
        ],
        'name' => 'all.',
    ], function () {});
});
