<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use Exception;
use Illuminate\Http\Request;

interface MembershipInterface
{
    public function viewMembershipList();
}

class MembershipContoroller extends Controller implements MembershipInterface
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:alumni');
    }

    /**
     * View Membership List
     *
     * @return mixed
     */
    public function viewMembershipList(): mixed
    {
        try {

            $memberships = Membership::all();

            return view('alumni.pages.membership.membership-list', [
                'memberships' => $memberships,
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
