<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Exception;

interface ServiceInterface
{
    public function viewServiceList();
    public function viewServiceCreate();
    public function viewServiceUpdate($id);
    public function handleServiceCreate(Request $request);
    public function handleServiceUpdate(Request $request, $id);
    public function handleToggleServiceStatus(Request $request);
    public function handleServiceDelete($id);
}

class ServiceController extends Controller implements ServiceInterface
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin')->except('logout');
    }

    /**
     * View Service List
     *
     * @return mixed
     */
    public function viewServiceList(): mixed
    {
        try {

            $services = Service::all();

            return view('admin.pages.service.service-list', [
                'services' => $services,
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
     * View Service Create
     *
     * @return mixed
     */
    public function viewServiceCreate(): mixed
    {
        try {

            return view('admin.pages.service.service-create');
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage()
            ]);
        }
    }

    /**
     * View Service Update
     *
     * @return mixed
     */
    public function viewServiceUpdate($id): mixed
    {
        try {

            $service = Service::find($id);

            if (!$service) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Service not found',
                    'description' => 'Service not found with specified ID'
                ]);
            }

            return view('admin.pages.service.service-update', [
                'service' => $service
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
     * Handle Service Create
     *
     * @return mixed
     */
    public function handleServiceCreate(Request $request): RedirectResponse
    {
        try {

            $validation = Validator::make($request->all(), [
                'name' => ['required', 'string', 'min:1', 'max:250'],
                'slug' => ['required', 'string',  'min:1', 'max:250', 'unique:services'],
                'summary' => ['required', 'string', 'min:1', 'max:500'],
                'description' => ['nullable', 'string', 'min:1', 'max:1000'],
                'thumbnail_image' => ['nullable', 'file', 'mimes:png.jpeg,jpg,webp'],
                'cover_image' => ['required', 'file', 'mimes:png.jpeg,jpg,webp'],
                'commission_percentage' => ['required', 'numeric', 'min:0', 'max:30']
            ]);

            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $service = new Service();
            $service->name = $request->input('name');
            $service->slug = $request->input('slug');
            $service->summary = $request->input('summary');
            $service->description = $request->input('description');
            $service->commission_percentage = $request->input('commission_percentage');
            if ($request->hasFile('thumbnail_image')) {
                $service->thumbnail_image = $request->file('thumbnail_image')->store('services');
            }
            if ($request->hasFile('cover_image')) {
                $service->cover_image = $request->file('cover_image')->store('services');
            }
            $service->save();

            return redirect()->route('admin.view.service.list')->with('message', [
                'status' => 'success',
                'title' => 'Service created',
                'description' => 'The service is successfully created.'
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
     * Handle Service Update
     *
     * @return mixed
     */
    public function handleServiceUpdate(Request $request, $id): RedirectResponse
    {
        try {

            $service = Service::find($id);

            if (!$service) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Service not found',
                    'description' => 'Service not found with specified ID'
                ]);
            }

            $validation = Validator::make($request->all(), [
                'name' => ['required', 'string', 'min:1', 'max:250'],
                'slug' => ['required', 'string',  'min:1', 'max:250', Rule::unique('services')->ignore($id)],
                'summary' => ['required', 'string', 'min:1', 'max:500'],
                'description' => ['nullable', 'string', 'min:1', 'max:1000'],
                'thumbnail_image' => ['nullable', 'file', 'mimes:png.jpeg,jpg,webp'],
                'cover_image' => ['nullable', 'file', 'mimes:png.jpeg,jpg,webp'],
                'commission_percentage' => ['required', 'numeric', 'min:0', 'max:30']
            ]);

            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $service->name = $request->input('name');
            $service->slug = $request->input('slug');
            $service->summary = $request->input('summary');
            $service->description = $request->input('description');
            $service->commission_percentage = $request->input('commission_percentage');
            if ($request->hasFile('thumbnail_image')) {
                if (!is_null($service->thumbnail_image)) Storage::delete($service->thumbnail_image);
                $service->thumbnail_image = $request->file('thumbnail_image')->store('services');
            }
            if ($request->hasFile('cover_image')) {
                if (!is_null($service->cover_image)) Storage::delete($service->cover_image);
                $service->cover_image = $request->file('cover_image')->store('services');
            }
            $service->update();

            return redirect()->route('admin.view.service.list')->with('message', [
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
     * Handle Toggle Service Status
     *
     * @return mixed
     */
    public function handleToggleServiceStatus(Request $request): Response
    {
        try {

            $validation = Validator::make($request->all(), [
                'service_id' => ['required', 'numeric', 'exists:services,id']
            ]);

            if ($validation->fails()) {
                return response([
                    'status' => false,
                    'message' => $validation->errors()->first(),
                    'error' => $validation->errors()->getMessages()
                ], 200);
            }

            $service = Service::find($request->input('service_id'));
            $service->status = !$service->status;
            $service->update();

            return response([
                'status' => true,
                'message' => "Status successfully updated",
                'data' => $service
            ], 200);
        } catch (Exception $exception) {
            return response([
                'status' => false,
                'message' => "An error occcured",
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * Handl Service Delete
     *
     * @return mixed
     */
    public function handleServiceDelete($id): RedirectResponse
    {
        try {

            $service = Service::find($id);

            if (!$service) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Service not found',
                    'description' => 'Service not found with specified ID'
                ]);
            }

            $service->delete();

            return redirect()->route('admin.view.service.list')->with('message', [
                'status' => 'success',
                'title' => 'Service deleted',
                'description' => 'The service is successfully deleted.'
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
