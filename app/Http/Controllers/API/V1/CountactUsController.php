<?php

namespace App\Http\Controllers\API\V1;

use App\Enums\RoleTypeEnum;
use App\Http\Requests\API\BookingRequest;
use App\Http\Requests\API\ClientRequestRequest;
use App\Http\Requests\API\ContactUsRequest;
use App\Http\Requests\API\HostingPlanRequest;
use App\Http\Requests\API\JobApplicationRequest;
use App\Http\Requests\API\MovementRequest;
use App\Http\Requests\API\SubscriptionRequest;
use App\Http\Requests\API\TransportBookingRequest;
use App\Models\booking;
use App\Models\ClientRequest;
use App\Models\HostingplanRequests;
use App\Models\Trip;
use App\Services\API\BlogService;
use App\Services\API\MovementService;
use App\Services\API\RangeService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\ContactUs;
use App\Models\HostingPlans;
use App\Models\JobApplication;
use App\Models\Subscription;
use App\Models\TransportBooking;
use App\Services\API\CategoryService;
use App\Services\API\HomeService;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\Queue\Job;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CountactUsController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function submitContactUs(ContactUsRequest $request)
    {
        try {
            return  $this->okResponse(__('Contact Us successfully.'), ContactUs::create($request->all()));
        } catch (\Exception $e) {
            return $this->exceptionFailed($e->getMessage());
        }
    }
    public function submitSubscription(SubscriptionRequest $request)
    {
        try {

            $subscription = Subscription::create($request->all());
            $email = $request->email;
            Mail::raw(__('ًWelcome to Ensign Agency!'), function ($message) use ($email) {
                $message->to($email)
                    ->subject('Test Email');
            });
            return  $this->okResponse(__('Add Subscription successfully.'));
        } catch (\Exception $e) {
            return $this->exceptionFailed($e->getMessage());
        }
    }



    public function submitClientRequest(ClientRequestRequest $request)
    {
        try {
            return  $this->okResponse(__('Add Client Request successfully.'), ClientRequest::create($request->all()));
        } catch (\Exception $e) {
            dd($e);
            return $this->exceptionFailed($e->getMessage());
        }
    }
    public function submitHostingPlanRequest(HostingPlanRequest $request)
    {
        try {
            $plan = HostingPlans::where('slug', $request->hosting_plan)->firstOrFail();

            HostingplanRequests::create([
                'name'  => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'message' => $request->message,
                'hosting_plan_id' => $plan->id,
            ]);

            return  $this->okResponse(__('Add Hosting Plan Request successfully.'), $plan);
        } catch (\Exception $e) {
            dd($e);
            return $this->exceptionFailed($e->getMessage());
        }
    }


    public function getFormHostingPlanRequest()
    {
        try {
            return $this->okResponse(__('success'), HostingPlans::pluck('name', 'slug')->toArray());
        } catch (\Exception $e) {
            dd($e);
            return $this->exceptionFailed($e->getMessage());
        }
    }
    public function getFormClientRequest()
    {
        try {
            return $this->okResponse(__('success'),  collect(\App\Enums\GoalEnum::cases())
                ->mapWithKeys(fn($case) => [$case->value => $case->label()])
                ->toArray());
        } catch (\Exception $e) {
            dd($e);
            return $this->exceptionFailed($e->getMessage());
        }
    }

    public function getFormJobApplication()
    {
        try {
            return $this->okResponse(__('success'),  collect(\App\Enums\JobTitleEnum::cases())
                ->mapWithKeys(fn($case) => [$case->value => $case->label()])
                ->toArray());
        } catch (\Exception $e) {
            dd($e);
            return $this->exceptionFailed($e->getMessage());
        }
    }
    public function submitJobApplication(JobApplicationRequest $request)
    {
        try {
            $data = $request->all();

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('job_applications', 'public');
                $data['image'] = $path;
            }

            $jobApplication = JobApplication::create($data);

            return $this->okResponse(__('Add Job Application successfully.'), $jobApplication);
        } catch (\Exception $e) {
            dd($e);
            return $this->exceptionFailed($e->getMessage());
        }
    }
}
