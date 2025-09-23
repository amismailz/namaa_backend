<?php

namespace App\Services\API;;

use App\Enums\CongestionLevelEnum;
use App\Enums\MovementTypeEnum;
use App\Enums\RoleTypeEnum;
use App\Filament\Resources\CategoryResource;
use App\Http\Requests\API\MovementRequest;
use App\Http\Resources\AboutUsResource;
use App\Http\Resources\BannerResource;
use App\Http\Resources\BlogResource;
use App\Http\Resources\CategoryResource as ResourcesCategoryResource;
use App\Http\Resources\ClientResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\FeatureResource;
use App\Http\Resources\HomePage\BlogResource as HomePageBlogResource;
use App\Http\Resources\MovementResource;
use App\Http\Resources\OptionsRangeResource;
use App\Http\Resources\OurServiceResource;
use App\Http\Resources\OurWorkResource;
use App\Http\Resources\PointResource;
use App\Http\Resources\RangeResource;
use App\Http\Resources\ReviewResource;
use App\Http\Resources\ReviewStandardResource;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\TripResource;
use App\Http\Resources\WebsiteAgencyResource;
use App\Http\Resources\WhyUsResource;
use App\Models\AboutUs;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Category;
use App\Models\City;
use App\Models\Client;
use App\Models\Comment;
use App\Models\ContactInfo;
use App\Models\Feature;
use App\Models\Movement;
use App\Models\OurService;
use App\Models\OurWork;
use App\Models\Point;
use App\Models\Range;
use App\Models\Review;
use App\Models\ReviewStandard;
use App\Models\Trip;
use App\Models\WebsiteAgency;
use App\Models\WhyUs;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use function Pest\Laravel\call;
use function Symfony\Component\String\s;


class HomeService
{
    const SORT_DIRECTIONS = ['asc', 'desc'];
    use ResponseTrait;

    public function home()
    {
        try {

            return $this->okResponse(
                __('Returned Home page successfully.'),
                [
                    'protfolio' =>  OurWorkResource::collection(OurWork::latest()->limit(5)->get() ?? []),
                    'banners' => new BannerResource(Banner::orderBy('created_at', 'desc')->first() ?? []),
                    //'whyus' => WhyUsResource::collection(Banner::orderBy('created_at', 'desc')->get() ?? []),
                    'services' =>   OurServiceResource::collection(OurService::orderBy('created_at', 'desc')->limit(6)->get() ?? []),
                    // 'Features' =>   FeatureResource::collection(Feature::orderBy('created_at', 'desc')->get() ?? []),
                    'blog' =>  HomePageBlogResource::collection(Blog::orderBy('published_date', 'desc')->limit(3)->get() ?? []),
                    'Website_design_agency_and_web_development' => new WebsiteAgencyResource(WebsiteAgency::first()),
                    'clients' =>  ClientResource::collection(Client::orderBy('created_at', 'desc')->limit(5)->get() ?? []),
                   // 'contact_info' => ContactInfo::first() ?? [],

                ]
            );
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            dd($exception);
            return $this->exceptionFailed($exception);
        }
    }
    public function contactInfo()
    {
        try {

            return $this->okResponse(
                __('Returned Contact Info page successfully.'),

                ContactInfo::first() ?? [],


            );
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            dd($exception);
            return $this->exceptionFailed($exception);
        }
    }

    public function getAboutUs()
    {
        try {
            return $this->okResponse(
                __('Returned Range Details successfully.'),
                AboutUsResource::collection(AboutUs::get())
            );
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            //            dd($exception);
            return $this->exceptionFailed($exception);
        }
    }
}
