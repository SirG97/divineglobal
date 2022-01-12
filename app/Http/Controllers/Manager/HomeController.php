<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Manager;
use App\Models\Marketer;
use App\Models\User;
use App\Models\Waitlist;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('manager.auth:manager');
    }

    /**
     * Show the Manager dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        return view('manager.home');
    }

    public function marketers(){
        $users = User::all();

        return view('manager.marketers', compact('users'));
    }

    public function addMarketer(){
        $waitlists = Waitlist::where('user_type', 'marketer')->with('branch')->get();

        return view('manager.mwaitlist', compact('waitlists'));
    }

    public function storeMarketer(Request $request){
        $request->validate([
            'email' => 'required|unique:waitlists',
        ]);

        $manager = Manager::where('id', auth('manager')->user()->id)->with('branch')->first();

        if(!$manager){
            return back()->with('error', 'An error occurred. Please try again');
        }
        Waitlist::create([
            'email' => $request->email,
            'user_type' => 'marketer',
            'branch_id' => $manager->branch->id,
            'manager_id' => auth('manager')->user()->id,
        ]);

        return back()->with('success', 'Manager added to preregistration list successfully');
    }
}
