<?php

namespace App\Http\Controllers\Admin;

use App\Enums\VendorType;
use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

interface VendorInterface
{
    public function viewVendorList();
    public function viewVendorPreview($id);
    public function handleVendorVerify($id);
}

class VendorController extends Controller implements VendorInterface
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
     * View Vendor List
     *
     * @return mixed
     */
    public function viewVendorList(): mixed
    {
        try {

            $vendors = Vendor::with(['address', 'documents'])->get();
            $types = VendorType::class;

            return view('admin.pages.vendor.vendor-list', [
                'vendors' => $vendors,
                'types' => $types
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
     * View Vendor Preview
     *
     * @return mixed
     */
    public function viewVendorPreview($id): mixed
    {
        try {

            $vendor = Vendor::with(['address', 'documents'])->find($id);

            if (!$vendor) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Vendor not found',
                    'description' => 'Vendor not found with specified ID'
                ]);
            }

            $types = VendorType::class;

            return view('admin.pages.vendor.vendor-preview', [
                'vendor' => $vendor,
                'types' => $types
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
     * Handle Vendor Verify
     *
     * @return mixed
     */
    public function handleVendorVerify($id): RedirectResponse
    {
        try {

            $vendor = Vendor::with(['address', 'documents'])->find($id);

            if (!$vendor) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Vendor not found',
                    'description' => 'Vendor not found with specified ID'
                ]);
            }

            $vendor->is_verified = !$vendor->is_verified;
            $vendor->save();

            return redirect()->back()->with('message', [
                'status' => 'success',
                'title' =>  $vendor->is_verified ? "Verified" : "Unverified",
                'description' => "The vendor is successfully " . ($vendor->is_verified ? "verified" : "unverified")
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
