<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Manager;
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
        $this->middleware('admin.auth:admin');
    }

    /**
     * Show the Admin dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        return view('admin.home');
    }

    public function branches(){
        $branches = Branch::all();
        return view('admin.branches', compact('branches'));
    }

    public function addBranch(Request $request){
        $request->validate([
            'name' => 'required|string',
            'address' => 'nullable|string'
        ]);

        Branch::create([
            'name' =>  $request->name,
            'address' => $request->address
        ]);

        return back()->with('success', 'Branch created successfully');
    }

    public function managers(){
        $managers = Manager::all();
        return view('admin.managers', compact('managers'));
    }

    public function addManager(){
        $waitlists = Waitlist::where('user_type', 'manager')->with('branch')->get();

        $branches = Branch::all();
        return view('admin.waitlist', compact('waitlists','branches'));
    }

    public function storeManager(Request $request){
        $request->validate([
            'email' => 'required|unique:waitlists',
            'branch' => 'required|numeric'
        ]);

        Waitlist::create([
            'email' => $request->email,
            'user_type' => 'manager',
            'branch_id' => $request->branch,
            'admin_id' => auth()->guard('admin')->user()->id,
        ]);

        return back()->with('success', 'Manager added to preregistration list successfully');
    }


}
