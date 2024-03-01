<?php

namespace App\Http\Controllers\Admin;

use App\Enums\EmploymentType;
use App\Enums\JobVerificationStatus;
use App\Http\Controllers\Controller;
use App\Models\JobPost;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;

interface JobPostInterface
{
    public function viewJobPostList();
    public function viewJobPostUpdate($id);
    public function handleJobPostUpdate(Request $request, $id);
    public function handleToggleJobPostStatus(Request $request);
    public function handleJobPostDelete($id);
}

class JobPostController extends Controller implements JobPostInterface
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * View Job Post List
     *
     * @return mixed
     */
    public function viewJobPostList(): mixed
    {
        try {

            $job_posts = JobPost::all();

            $verification_status = JobVerificationStatus::class;
            $employment_type = EmploymentType::class;

            return view('admin.pages.job-post.job-post-list', [
                'job_posts' => $job_posts,
                'verification_status' => $verification_status,
                'employment_type' => $employment_type
            ]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage()
            ]);
        }
    }

    /**
     * View Job Post Update
     *
     * @return mixed
     */
    public function viewJobPostUpdate($id): mixed
    {
        try {

            $job_post = JobPost::find($id);

            if (!$job_post) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Job Post not found',
                    'description' => 'Job post not found with specified ID'
                ]);
            }

            $verification_status = JobVerificationStatus::class;
            $employment_type = EmploymentType::class;

            return view('admin.pages.job-post.job-post-preview', [
                'job_post' => $job_post,
                'verification_status' => $verification_status,
                'employment_type' => $employment_type
            ]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Handle Job Post Update
     *
     * @return RedirectResponse
     */
    public function handleJobPostUpdate(Request $request, $id): RedirectResponse
    {
        try {

            $job_post = JobPost::find($id);

            if (!$job_post) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Job Post not found',
                    'description' => 'Job post not found with specified ID'
                ]);
            }

            $validation = Validator::make($request->all(), [
                'verification_status' => ['required', 'string', new Enum(JobVerificationStatus::class)],
            ]);

            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $job_post->verification_status = $request->input('verification_status');
            $job_post->update();

            return redirect()->route('admin.view.job.post.list')->with('message', [
                'status' => 'success',
                'title' => 'Changes saved',
                'description' => 'The changes are successfully saved.'
            ]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Handle Toggle Job Post Status
     *
     * @return Response
     */
    public function handleToggleJobPostStatus(Request $request): Response
    {
        try {

            $validation = Validator::make($request->all(), [
                'job_post_id' => ['required', 'numeric', 'exists:job_posts,id']
            ]);

            if ($validation->fails()) {
                return response([
                    'status' => false,
                    'message' => $validation->errors()->first(),
                    'error' => $validation->errors()->getMessages()
                ], Response::HTTP_OK);
            }

            $job_post = JobPost::find($request->input('job_post_id'));
            $job_post->status = !$job_post->status;
            $job_post->update();

            return response([
                'status' => true,
                'message' => "Status successfully updated",
                'data' => $job_post
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response([
                'status' => false,
                'message' => "An error occcured",
                'error' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Handle Job Post Delete
     *
     * @return RedirectResponse
     */
    public function handleJobPostDelete($id): RedirectResponse
    {
        try {

            $job_post = JobPost::find($id);

            if (!$job_post) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Job Post not found',
                    'description' => 'Job post not found with specified ID'
                ]);
            }

            $job_post->delete();

            return redirect()->route('admin.view.job.post.list')->with('message', [
                'status' => 'success',
                'title' => 'Job Post Deleted',
                'description' => 'The job post is successfully deleted.'
            ]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Handle Job Post Verification Status
     *
     * @return mixed
     */
    public function handleJobPostVerificationStatus(Request $request, $id): RedirectResponse
    {
        try {

            $job_post = JobPost::find($id);

            if (!$job_post) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Job Post not found',
                    'description' => 'Job post not found with specified ID'
                ]);
            }

            $validation = Validator::make($request->all(), [
                'verification_status' => ['required', 'string', new Enum(JobVerificationStatus::class)],
            ]);

            if ($validation->fails()) {
                return redirect()->back()->with('message', [
                    'status' => 'false',
                    'title' => 'Invalid Data',
                    'description' => $validation->errors()->first()
                ]);
            }

            $job_post->verification_status = $request->input('verification_status');
            $job_post->update();

            return redirect()->back()->with('message', [
                'status' => 'success',
                'title' => 'Changes saved',
                'description' => 'The changes are successfully saved.'
            ]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage()
            ]);
        }
    }

    
}
