<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaction;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CustomerController extends Controller
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

    public function index(){
        $users = Customer::where('user_id', auth()->user()->id)->simplePaginate(50);

        return view('customers', compact('users'));
    }

    public function create(){
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
        if($banks !== null and $banks->status == 'success'){
            usort($banks->data, function($a, $b){ return strcmp($a->name, $b->name); });
        }else{
            $banks = [];
        }

        return view('newcustomer', compact('banks'));
    }

    public function resolveAccountNumber(Request $request){
        $data = array(
            "account_number" => $request->account_number,
            "account_bank" => $request->bank,
        );
        $data = json_encode($data);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/bank/resolve?account_number={$request->account_number}&bank_code={$request->bank}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer " . config('app.PAYSTACK_SECRET'),
                "Cache-Control: no-cache",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

//        if ($err) {
//            echo "cURL Error #:" . $err;
//        } else {
//            echo $response;
//        }

//        $response = curl_exec($curl);
        $response = json_decode($response);
//        curl_close($curl);
        return response()->json($response);

    }

    public function store(Request $request){
        $request->validate([
            'first_name' => 'required|string|max:200',
            'surname' => 'required|string|max:200',
            'middle_name' => 'string|nullable',
            'dob' => 'nullable',
            'sex' => 'nullable',
            'resident_state' => 'nullable',
            'resident_lga' => 'nullable',
            'resident_address' => 'nullable',
            'occupation' => 'nullable',
            'office_address' => 'required',
            'state' => 'nullable',
            'lga' => 'nullable',
            'hometown' => 'nullable',
            'phone' => 'required',
            'next_of_kin'  => 'nullable',
            'relationship' => 'nullable',
            'nokphone' => 'nullable',
            'acc_no'  => 'nullable',
            'branch' => 'nullable',
            'group' => 'nullable',
            'sb_card_no_from' => 'nullable',
            'sb_card_no_to' => 'nullable',
            'sb' => 'nullable',
            'initial_unit'  => 'nullable',
            'bank_name' => 'nullable',
            'bank_code' => 'nullable',
            'account_name' => 'nullable',
            'account_number' => 'nullable',
            'daily_amount' => 'required'
        ]);

        $customer = Customer::create([
            'first_name' => $request->first_name,
            'surname' => $request->surname,
            'middle_name' => $request->middle_name,
            'dob' => $request->dob,
            'sex' => $request->sex,
            'resident_state' => $request->resident_state,
            'resident_lga' => $request->resident_lga,
            'resident_address' => $request->resident_address,
            'occupation' => $request->occupation,
            'office_address' => $request->office_address,
            'state' => $request->state,
            'lga' => $request->lga,
            'hometown' => $request->hometown,
            'phone' => $request->phone,
            'next_of_kin'  => $request->next_of_kin,
            'relationship' => $request->relationship,
            'nokphone' => $request->nokphone,
            'user_id' => auth()->user()->id,
            'branch_id' => auth()->user()->branch_id,
            'bank_name' => $request->bank_name,
            'bank_code' => $request->bank_code,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'initial_unit' => $request->daily_amount
        ]);

        Wallet::create([
            'customer_id' => $customer->id,
            'balance' => 0
        ]);
        return back()->with('success', 'Customer created successfully');
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

        return view('customer', compact('user', 'banks', 'balance'));
    }

    public function edit(Request $request){
        $request->validate([
            'first_name' => 'required|string|max:200',
            'surname' => 'required|string|max:200',
            'middle_name' => 'string|nullable',
            'dob' => 'nullable',
            'sex' => 'nullable',
            'resident_state' => 'nullable',
            'resident_lga' => 'nullable',
            'resident_address' => 'nullable',
            'occupation' => 'nullable',
            'office_address' => 'required',
            'state' => 'nullable',
            'lga' => 'nullable',
            'hometown' => 'nullable',
            'phone' => 'required',
            'next_of_kin'  => 'nullable',
            'relationship' => 'nullable',
            'nokphone' => 'nullable',
            'acc_no'  => 'nullable',
            'branch' => 'nullable',
            'group' => 'nullable',
            'sb_card_no_from' => 'nullable',
            'sb_card_no_to' => 'nullable',
            'sb' => 'nullable',
            'initial_unit'  => 'nullable',
            'bank_name' => 'nullable',
            'bank_code' => 'nullable',
            'account_name' => 'nullable',
            'account_number' => 'nullable',
            'daily_amount' => 'required'
        ]);


        Customer::where('id', $request->id)->update([
            'first_name' => $request->first_name,
            'surname' => $request->surname,
            'middle_name' => $request->middle_name,
            'dob' => $request->dob,
            'sex' => $request->sex,
            'resident_state' => $request->resident_state,
            'resident_lga' => $request->resident_lga,
            'resident_address' => $request->resident_address,
            'occupation' => $request->occupation,
            'office_address' => $request->office_address,
            'state' => $request->state,
            'lga' => $request->lga,
            'hometown' => $request->hometown,
            'phone' => $request->phone,
            'next_of_kin'  => $request->next_of_kin,
            'relationship' => $request->relationship,
            'nokphone' => $request->nokphone,
            'user_id' => auth()->user()->id,
            'branch_id' => auth()->user()->branch_id,
            'bank_name' => $request->bank_name,
            'bank_code' => $request->bank_code,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'initial_unit' => $request->daily_amount
        ]);

        return back()->with('success', 'Customer details updated successfully');
    }

    public function update(){

    }

    public function save($id){
        $user = Customer::findOrFail($id);
        $wallet = Wallet::where([['user_type', '=', 'customer'], ['customer_id', '=', $id]])->first();
        if(!$wallet){
            return back()->with('error', 'Could not retrieve customer wallet');
        }
        $balance = $wallet->balance;
        return view('save', compact('user', 'balance'));
    }

    public function mark(Request $request){
        $request->validate([
            'id' => 'required|numeric',
            'daily_amount' => 'required|numeric',
            'date' => 'date|required'
        ]);
        // Retrieve the customer
        $customer = Customer::findOrFail($request->id);
        // Get the customer wallet
        $customerWallet = Wallet::where([['user_type', '=', 'customer'], ['customer_id', '=', $request->id]])->first();
        if(!$customerWallet){
            return back()->with('error', 'Could not retrieve customer wallet');
        }
        // Check if the amount that is being deposited is same with the one in customer data
        if($customer->initial_unit > $request->daily_amount){
            return back()->with('error', 'The amount to be saved is less than the customers agreed payment amount.');
        }
        $balance = $customerWallet->balance;
        $count = $customerWallet->count;
        if($count < 30){
            Transaction::create([
                'user_id' => auth()->user()->id,
                'branch_id' => auth()->user()->branch_id,
                'customer_id' => $customer->id,
                'txn_ref' => Str::random(10),
                'txn_type' => 'credit',
                'purpose' => 'deposit',
                'amount' => $request->daily_amount,
                'balance_before' => $balance,
                'balance_after' => $balance + $request->daily_amount,
                'description' => 'Deposit from ' . $customer->first_name . ' ' . $customer->surname . ' by ' . auth()->user()->name,
                'count' => $count + 1,
                'date' => Carbon::now(),
            ]);
            $customerWallet->balance = $balance + $request->daily_amount;
            $customerWallet->count = $count + 1;
            $customerWallet->save();
        }else{
           $t = Transaction::create([
                'user_id' => auth()->user()->id,
                'branch_id' => auth()->user()->branch_id,
                'customer_id' => $customer->id,
                'txn_ref' => Str::random(10),
                'txn_type' => 'credit',
                'purpose' => 'deposit',
                'amount' => $request->daily_amount,
                'balance_before' => $balance,
                'balance_after' => $balance + $request->daily_amount,
                'description' => 'Deposit from ' . $customer->first_name . ' ' . $customer->surname . ' by ' . auth()->user()->name,
                'count' => 0,
                'date' => Carbon::now(),
            ]);
            $customerWallet->balance = $balance + $request->daily_amount;
            $customerWallet->count = 0;
            $customerWallet->save();
            // Debit the service charge
            Transaction::create([
                'user_id' => auth()->user()->id,
                'branch_id' => auth()->user()->branch_id,
                'customer_id' => $customer->id,
                'txn_ref' => Str::random(10),
                'txn_type' => 'debit',
                'purpose' => 'payment',
                'amount' => $request->daily_amount,
                'balance_before' => $customerWallet->balance,
                'balance_after' => $customerWallet->balance - $request->daily_amount,
                'description' => 'Service charge from ' . $customer->first_name . ' ' . $customer->surname . ' by ' . auth()->user()->name,
                'count' => 0,
                'date' => Carbon::now(),
            ]);

            $customerWallet->balance = $customerWallet->balance - $request->daily_amount;
            $customerWallet->save();

            // Update admin wallet
            Wallet::updateOrCreate(['user_type' => 'user', 'customer_id' => auth()->user()->id],
                                    ['balance' => DB::raw('balance+'. $request->daily_amount)]);

        }

        return back()->with('success', 'Customer\'s payment saved successfully');
    }

    public function withdraw($id){
        $user = Customer::findOrFail($id);
        $wallet = Wallet::where([['user_type', '=', 'customer'], ['customer_id', '=', $id]])->first();
        if(!$wallet){
            return back()->with('error', 'Could not retrieve customer wallet');
        }
        $balance = $wallet->balance;
        return view('withdraw', compact('user', 'balance'));
    }

    public function  storeWithdraw(Request $request){
        $request->validate([
            'id' => 'required|numeric',
            'amount' => 'required|numeric',
        ]);
        $customer = Customer::findOrFail($request->id);
        $customerWallet = Wallet::where([['user_type', '=', 'customer'], ['customer_id', '=', $request->id]])->first();
        if(!$customerWallet){
            return back()->with('error', 'Could not retrieve customer wallet');
        }

        Transaction::create([
            'user_id' => auth()->user()->id,
            'branch_id' => auth()->user()->branch_id,
            'customer_id' => $customer->id,
            'txn_ref' => Str::random(10),
            'txn_type' => 'debit',
            'purpose' => 'withdrawal',
            'amount' => $request->amount,
            'balance_before' => $customerWallet->balance,
            'balance_after' => $customerWallet->balance - $request->amount,
            'description' => 'Withdrawal for ' . $customer->first_name . ' ' . $customer->surname . ' by ' . auth()->user()->name,
            'count' => 0,
            'date' => Carbon::now(),
        ]);

        $customerWallet->balance = $customerWallet->balance - $request->amount;
        $customerWallet->save();

        return redirect(route('show', $request->id))->with('success', 'Withdrawal successful');
    }

    public function daily(){
        $total = Transaction::where([['user_id','=', auth()->user()->id], ['txn_type', '=', 'credit'], ['created_at', '>', Carbon::today()]])->sum('amount');
        $transactions = Transaction::where([['user_id','=', auth()->user()->id], ['created_at', '>', Carbon::today()]])->orderBy('id', 'desc')->simplePaginate(31);
        $balance = $total;
        return view('daily', compact('transactions', 'balance'));
    }

    public function history(){

        $total = Transaction::where([['user_id','=', auth()->user()->id], ['txn_type', '=', 'credit']])->whereBetween('created_at', [
            Carbon::now()->startOfYear(),
            Carbon::now()->endOfYear(),
        ])->sum('amount');
        $transactions = Transaction::where('user_id', auth()->user()->id)->whereBetween('created_at', [
            Carbon::now()->startOfYear(),
            Carbon::now()->endOfYear(),
        ])->orderBy('id', 'desc')->simplePaginate(31);
        $balance = $total;
        return view('history', compact('transactions', 'balance'));
    }

    public function customerHistory($id){

        $wallet = Wallet::where([['user_type', '=', 'customer'], ['customer_id', '=', $id]])->first();
        if(!$wallet){
            return back()->with('error', 'Could not retrieve customer wallet');
        }
        $transactions = Transaction::where('customer_id', $id)->orderBy('id', 'desc')->simplePaginate(31);
        $balance = $wallet->balance;
        return view('customerhistory', compact('transactions', 'balance'));
    }

    public function search($id){
       $customers =  Customer::where([['first_name', 'LIKE', "%{$id}%"], ['user_id','=', auth()->user()->id]])
            ->orWhere([['surname', 'LIKE', "%{$id}%"],['user_id','=', auth()->user()->id]])
            ->orWhere([['phone', 'LIKE', "%{$id}%"],['user_id','=', auth()->user()->id]])->with('branch')->get();

        if($customers->count() > 0){
            return response()->json(['data' => $customers, 'status' => 'success', 'message' => 'Customer(s) retrieved successfully']);
        }else{
            return response()->json(['data' => [], 'status' => 'error', 'message' => 'Customer retrieval failed']);
        }
    }
}
