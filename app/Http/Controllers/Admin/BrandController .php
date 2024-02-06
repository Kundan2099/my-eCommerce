<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

interface BrandInterface
{
    public function viewBrandList();
    public function handleBrandCreate(Request $request);
    public function handleBrandDelete($id);
}

class BrandController extends Controller implements BrandInterface
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
     * View Brand List
     *
     * @return mixed
     */
    public function viewBrandList(): mixed
    {
        try {

            $brands = Brand::all();

            return view('admin.pages.brand.brand-list', [
                'brands' => $brands,
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
     * Handle Brand Create
     *
     * @return RedirectResponse
     */
    public function handleBrandCreate(Request $request): RedirectResponse
    {
        try {
            
            $validation = Validator::make($request->all(), [
                'brands' => ['array'],
                'brands.*' => ['required', 'file', 'mimes:jpg,jpeg,png,webp'],
            ]);
    
            if ($validation->fails()) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => $validation->errors()->first(),
                    'description' => $validation->errors()->first()
                ]);
            }
    
            if ($request->brands) {
                foreach ($request->brands as $key => $file) {
                    if ($request->hasFile('brands')) {
                        $brand = new Brand();
                        $brand->name = $file->getClientOriginalName();
                        $brand->logo = $file->store('brands');
                        $brand->save();
                    }
                }
                return redirect()->back()->with('message', [
                    'status' => 'success',
                    'title' => 'Images Uploaded',
                    'description' => 'Chapter images are is successfully uploaded.'
                ]);
            } else {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Upload Files',
                    'description' => 'Please select files to upload'
                ]);
            }
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage()
            ]);
        }
        
    }

    /**
     * Handl Brand Delete
     *
     * @return mixed
     */
    public function handleBrandDelete($id): RedirectResponse
    {
        try {

            $brand = Brand::find($id);

            if (!$brand) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Brand not found',
                    'description' => 'Brand not found with specified ID'
                ]);
            }

            $brand->delete();

            return redirect()->route('admin.view.brand.list')->with('message', [
                'status' => 'success',
                'title' => 'Brand deleted',
                'description' => 'The brand is successfully deleted.'
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
