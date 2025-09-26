<?php

namespace App\Http\Controllers\API\V1;

use App\Enums\RoleTypeEnum;
use App\Http\Requests\API\MovementRequest;
use App\Services\API\BlogService;
use App\Services\API\MovementService;
use App\Services\API\RangeService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Services\API\HomeService;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;


class BlogController extends Controller
{
    use ResponseTrait;

    protected BlogService $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }
    /**
     * Display a listing of the resource.
     */
    public function getAllBlogs(Request $request)
    {
        return $this->blogService->getAllBlogs($request);
    }
       public function getBlog($slug)
    {
        return $this->blogService->getBlog($slug);
    }
       public function getBlogOrServiceBySlug($slug)
    {
        return $this->blogService->getBlogOrServiceBySlug($slug);
    }

  

  
}
