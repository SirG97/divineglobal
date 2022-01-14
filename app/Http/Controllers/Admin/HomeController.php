<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\Manager;
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
        $this->middleware('admin.auth:admin');
    }

    /**
     * Show the Admin dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {

        $totalMarketers =  User::count();
        $totalCustomers = Customer::count();
        $yearlyTotal = Transaction::where([['txn_type', '=', 'credit']])->whereBetween('created_at', [
            Carbon::now()->startOfYear(),
            Carbon::now()->endOfYear(),
        ])->sum('amount');
        $monthlyTotal = Transaction::where([['txn_type', '=', 'credit']])->whereBetween('created_at', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth(),
        ])->sum('amount');
        $dailyTotal = Transaction::where([['txn_type', '=', 'credit']])->whereBetween('created_at', [
            Carbon::now()->startOfDay(),
            Carbon::now()->endOfDay()
        ])->sum('amount');
        $transactions = Transaction::orderBy('id', 'desc')->take(30)->get();
        return view('admin.home', compact('totalCustomers','yearlyTotal', 'monthlyTotal', 'dailyTotal', 'transactions'));
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

    public function marketers(){
        $users = User::all();

        return view('admin.marketers', compact('users'));
    }

    public function customers(){
        $users =  Customer::with('branch')->orderBy('id', 'desc')->simplePaginate(50);

        return view('admin.customers', compact('users'));
    }

    public function show($id){
        $banks = [];
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.flutterwave.com/v3/banks/NG",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer " . config('app.FLUTTERWAVE_SECRET')
            ),
        ));

        $banks = curl_exec($curl);
        $banks = json_decode($banks);
        if($banks->status == 'success'){
            usort($banks->data, function($a, $b){ return strcmp($a->name, $b->name); });
        }else{
            $banks = [];
        }
        $user = Customer::findOrFail($id);
        $wallet = Wallet::where([['user_type', '=', 'customer'], ['customer_id', '=', $id]])->first();
        if(!$wallet){
            return back()->with('error', 'Could not retrieve customer wallet');
        }
        $balance = $wallet->balance;

        return view('admin.customer', compact('user', 'banks', 'balance'));
    }

    public function daily(){

        $total = Transaction::where([ ['txn_type', '=', 'credit'], ['created_at', '>', Carbon::today()]])->sum('amount');
        $transactions = Transaction::where([['created_at', '>', Carbon::today()]])->orderBy('id', 'desc')->simplePaginate(31);
        $balance = $total;
        return view('admin.daily', compact('transactions', 'balance'));
    }

    public function history(){

        $total = Transaction::where([['txn_type', '=', 'credit']])->whereBetween('created_at', [
            Carbon::now()->startOfYear(),
            Carbon::now()->endOfYear(),
        ])->sum('amount');
        $transactions = Transaction::whereBetween('created_at', [
            Carbon::now()->startOfYear(),
            Carbon::now()->endOfYear(),
        ])->orderBy('id', 'desc')->simplePaginate(31);
        $balance = $total;
        return view('admin.history', compact('transactions', 'balance'));
    }

    public function customerHistory($id){

        $wallet = Wallet::where([['user_type', '=', 'customer'], ['customer_id', '=', $id]])->first();
        if(!$wallet){
            return back()->with('error', 'Could not retrieve customer wallet');
        }
        $transactions = Transaction::where('customer_id', $id)->orderBy('id', 'desc')->simplePaginate(31);
        $balance = $wallet->balance;
        return view('admin.customerhistory', compact('transactions', 'balance'));
    }


    public function password(){
        return view('admin.password');
    }

    public function changePassword(Request $request){
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|string|min:8|confirmed'
        ]);
        $user = Admin::where('id',auth('admin')->user()->id)->first();
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
