<?php

namespace App\Services\API;;

use App\Enums\CongestionLevelEnum;
use App\Enums\MovementTypeEnum;
use App\Enums\RoleTypeEnum;

use App\Http\Requests\API\MovementRequest;
use App\Http\Resources\BannerResource;
use App\Http\Resources\BlogResource;
use App\Http\Resources\CategoryResource as ResourcesCategoryResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\MovementResource;
use App\Http\Resources\OptionsRangeResource;
use App\Http\Resources\PointResource;
use App\Http\Resources\RangeResource;
use App\Http\Resources\ReviewResource;
use App\Http\Resources\ReviewStandardResource;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\TripResource;
use App\Models\AboutUs;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Category;
use App\Models\City;
use App\Models\Comment;
use App\Models\ContactInfo;
use App\Models\Movement;
use App\Models\OurService;
use App\Models\Point;
use App\Models\Range;
use App\Models\Review;
use App\Models\ReviewStandard;
use App\Models\SubCategory;
use App\Models\Trip;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use function Pest\Laravel\call;
use function Symfony\Component\String\s;


class CategoryService
{
    const SORT_DIRECTIONS = ['asc', 'desc'];
    use ResponseTrait;

    public function getAllCategories()
    {
        try {
            return $this->okResponse(
                __('Returned Home page successfully.'),
                [
                    ResourcesCategoryResource::collection(Category::orderBy('created_at', 'desc')->get() ?? []),
                ]
            );
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            dd($exception);
            return $this->exceptionFailed($exception);
        }
    }

    public function getCategoryTrips($slug)
    {
        try {
            $category = Category::where('slug', $slug)->first();
            if (!$category) {
                return $this->notFoundResponse('Category');
            }
            $trips = Trip::where('category_id', $category->id)->get();
            return $this->okResponse(
                __('Returned Home page successfully.'),
                [
                    TripResource::collection($trips ?? []),
                ]
            );
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            dd($exception);
            return $this->exceptionFailed($exception);
        }
    }
    public function getSubCategoryTrips($slug)
    {
        try {
            $subCategory = SubCategory::where('slug', $slug)->first();
            if (!$subCategory) {
                return $this->notFoundResponse('Sub Category');
            }
            $trips = Trip::where('sub_category_id', $subCategory->id)->get();
            return $this->okResponse(
                __('Returned Home page successfully.'),
                [
                    TripResource::collection($trips ?? []),
                ]
            );
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            dd($exception);
            return $this->exceptionFailed($exception);
        }
    }
    public function getCategoryBySlug(string $slug)
    {
        try {
            $category = Category::where('slug', $slug)->first();
            if (!$category) {
                return $this->notFoundResponse('Category');
            }
            return $this->okResponse(
                __('Returned Category Details successfully'),
                new ResourcesCategoryResource($category)
            );
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return $this->exceptionFailed($exception);
        }
    }
}
