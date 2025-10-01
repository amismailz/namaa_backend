<?php

namespace App\Services\API;;

use App\Enums\CongestionLevelEnum;
use App\Enums\MovementTypeEnum;
use App\Enums\RoleTypeEnum;

use App\Filament\Resources\CategoryResource;
use App\Http\Requests\API\MovementRequest;
use App\Http\Resources\BannerResource;
use App\Http\Resources\BlogResource;
use App\Http\Resources\CategoryResource as ResourcesCategoryResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\MovementResource;
use App\Http\Resources\OptionsRangeResource;
use App\Http\Resources\OurServiceResource;
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
use App\Models\Trip;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use function Pest\Laravel\call;
use function Symfony\Component\String\s;


class BlogService
{
    const SORT_DIRECTIONS = ['asc', 'desc'];
    use ResponseTrait;

    public function getAllBlogs($request)
    {
        try {
            $perPage = request()->input('per_page', 15);
            $currentPage = request()->input('page', 1);
            $blogs = Blog::query();
            if ($request->search) {
                $blogs->where('title', 'like', '%' . $request->search . '%');
            }
            // if ($request->category) {
            //     $blogs->join('categories', 'blogs.category_id', '=', 'categories.id')->where('categories.slug', $request->category);
            // }

            $blogs = $blogs->orderBy('blogs.created_at', 'desc')->paginate($perPage, ['*'], 'page', $currentPage);
            return $this->paginateResponse(BlogResource::collection($blogs));
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            dd($exception);
            return $this->exceptionFailed($exception);
        }
    }
    public function getBlogsSiteMap($request)
    {
        try {
            $blogs = Blog::
                // ->when($request->search, function ($query) use ($request) {
                //     $query->where('title->en', 'like', '%' . $request->search . '%')
                //         ->orWhere('title->ar', 'like', '%' . $request->search . '%');
                // })
                select('id', 'title', 'slug', 'created_at')
                ->latest()->get();


            return $this->okResponse(
                __('Returned Blogs successfully.'),
                $blogs
            );
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            dd($exception);
            return $this->exceptionFailed($exception);
        }
    }

    public function getBlog($slug)
    {
        try {

            $blog = Blog::where('slug->en', $slug)
                ->orWhere('slug->ar', $slug)
                ->first();
            return $this->okResponse(
                __('Returned Home page successfully.'),
                [
                    'blog' => new BlogResource($blog),
                    'popular_blogs' => BlogResource::collection(Blog::where('is_popular', 1)->limit(6)->get()),

                ]


            );
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            dd($exception);
            return $this->exceptionFailed($exception);
        }
    }
    public function getBlogOrServiceBySlug($slug)
    {
        try {

            $blog = Blog::where('slug->en', $slug)
                ->orWhere('slug->ar', $slug)
                ->first();
            if ($blog) {
                return $this->okResponse(
                    __('Returned Home page successfully.'),
                    [
                        'blog' => new BlogResource($blog),
                        'type' => 'blog',
                        'popular_blogs' => BlogResource::collection(Blog::where('is_popular', 1)->limit(6)->get()),
                    ]
                );
            }
            $service = OurService::where('slug->en', $slug)
                ->orWhere('slug->ar', $slug)->first();
            if ($service) {
                return $this->okResponse(
                    __('Returned Our Service successfully.'),
                    [
                        'service' => new OurServiceResource($service),
                        'type' => 'service'
                    ]
                );
            }
            return $this->notFoundResponse('No Blog or Service found for this slug.');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            dd($exception);
            return $this->exceptionFailed($exception);
        }
    }
}
