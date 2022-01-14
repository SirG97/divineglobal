<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\Manager;
use App\Models\Marketer;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Waitlist;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        $branch = auth('manager')->user()->branch_id;
        $totalMarketers =  User::where('branch_id', $branch)->count();
        $totalCustomers = Customer::where('branch_id', $branch)->count();
        $yearlyTotal = Transaction::where([['branch_id','=', $branch], ['txn_type', '=', 'credit']])->whereBetween('created_at', [
            Carbon::now()->startOfYear(),
            Carbon::now()->endOfYear(),
        ])->sum('amount');
        $monthlyTotal = Transaction::where([['branch_id','=', $branch], ['txn_type', '=', 'credit']])->whereBetween('created_at', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth(),
        ])->sum('amount');
        $dailyTotal = Transaction::where([['branch_id','=', $branch], ['txn_type', '=', 'credit']])->whereBetween('created_at', [
            Carbon::now()->startOfDay(),
            Carbon::now()->endOfDay()
        ])->sum('amount');
        $transactions = Transaction::where('branch_id', $branch)->orderBy('id', 'desc')->take(30)->get();
        return view('manager.home', compact('totalCustomers','yearlyTotal', 'monthlyTotal', 'dailyTotal', 'transactions'));
    }

    public function marketers(){
        $users = User::where('branch_id', auth('manager')->user()->branch_id)->get();

        return view('manager.marketers', compact('users'));
    }

    public function addMarketer(){
        $branch = auth('manager')->user()->branch_id;
        $waitlists = Waitlist::where([['user_type','=', 'marketer'],['branch_id', '=', $branch]])->with('branch')->get();

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

    public function customers(){
        $users =  Customer::where('branch_id', auth('manager')->user()->branch_id)->orderBy('id', 'desc')->simplePaginate(50);

        return view('manager.customers', compact('users'));
    }

    public function show($id){
        $banks = [];
//        $curl = curl_init();
//
//        curl_setopt_array($curl, array(
//            CURLOPT_URL => "https://api.flutterwave.com/v3/banks/NG",
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_ENCODING => "",
//            CURLOPT_MAXREDIRS => 10,
//            CURLOPT_TIMEOUT => 0,
//            CURLOPT_FOLLOWLOCATION => true,
//            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//            CURLOPT_CUSTOMREQUEST => "GET",
//            CURLOPT_HTTPHEADER => array(
//                "Authorization: Bearer " . config('app.FLUTTERWAVE_SECRET')
//            ),
//        ));
//
//        $banks = curl_exec($curl);
//        $banks = json_decode($banks);
//        if($banks->status == 'success'){
//            usort($banks->data, function($a, $b){ return strcmp($a->name, $b->name); });
//        }else{
//            $banks = [];
//        }
        $user = Customer::findOrFail($id);
        $wallet = Wallet::where([['user_type', '=', 'customer'], ['customer_id', '=', $id]])->first();
        if(!$wallet){
            return back()->with('error', 'Could not retrieve customer wallet');
        }
        $balance = $wallet->balance;

        return view('manager.customer', compact('user', 'banks', 'balance'));
    }

    public function daily(){
        $branch = auth('manager')->user()->branch_id;
        $total = Transaction::where([['branch_id','=', $branch], ['txn_type', '=', 'credit'], ['created_at', '>', Carbon::today()]])->sum('amount');
        $transactions = Transaction::where([['branch_id','=', $branch], ['created_at', '>', Carbon::today()]])->orderBy('id', 'desc')->simplePaginate(31);
        $balance = $total;
        return view('manager.daily', compact('transactions', 'balance'));
    }

    public function history(){
        $branch = auth('manager')->user()->branch_id;
        $total = Transaction::where([['branch_id','=', $branch], ['txn_type', '=', 'credit']])->whereBetween('created_at', [
            Carbon::now()->startOfYear(),
            Carbon::now()->endOfYear(),
        ])->sum('amount');
        $transactions = Transaction::where('branch_id', $branch)->whereBetween('created_at', [
            Carbon::now()->startOfYear(),
            Carbon::now()->endOfYear(),
        ])->orderBy('id', 'desc')->simplePaginate(31);
        $balance = $total;
        return view('manager.history', compact('transactions', 'balance'));
    }

    public function customerHistory($id){
        $branch = auth('manager')->user()->branch_id;
        $wallet = Wallet::where([['user_type', '=', 'customer'], ['customer_id', '=', $id]])->first();
        if(!$wallet){
            return back()->with('error', 'Could not retrieve customer wallet');
        }
        $transactions = Transaction::where('customer_id', $id)->orderBy('id', 'desc')->simplePaginate(31);
        $balance = $wallet->balance;
        return view('manager.customerhistory', compact('transactions', 'balance'));
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
