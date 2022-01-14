<?php

namespace App\Http\Controllers;

//use App\Models\Audit;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalCustomers = Customer::where('user_id', auth()->user()->id)->count();
        $yearlyTotal = Transaction::where([['user_id','=', auth()->user()->id], ['txn_type', '=', 'credit']])->whereBetween('created_at', [
            Carbon::now()->startOfYear(),
            Carbon::now()->endOfYear(),
        ])->sum('amount');
        $monthlyTotal = Transaction::where([['user_id','=', auth()->user()->id], ['txn_type', '=', 'credit']])->whereBetween('created_at', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth(),
        ])->sum('amount');
        $dailyTotal = Transaction::where([['user_id','=', auth()->user()->id], ['txn_type', '=', 'credit']])->whereBetween('created_at', [
            Carbon::now()->startOfDay(),
            Carbon::now()->endOfDay()
        ])->sum('amount');
        $transactions = Transaction::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->take(30)->get();
        return view('home', compact('totalCustomers','yearlyTotal', 'monthlyTotal', 'dailyTotal', 'transactions'));
    }

    public function password(){
        return view('password');
    }

    public function changePassword(Request $request){
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|string|min:8|confirmed'
        ]);
        $user = User::where('id',auth()->user()->id)->first();
        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->password);
            $user->save();
//            $audit['user_id']= Auth::guard()->user()->id;
//            $audit['reference']=Str::random(16);
//            $audit['log']='Changed Password';
//            Audit::create($audit);
            return back()->with('success', 'Password Changed successfully.');
        }elseif (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Invalid password');
        }
    }



}
