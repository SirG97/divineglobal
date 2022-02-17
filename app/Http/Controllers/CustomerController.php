<?php

namespace App\Http\Controllers;

use App\Models\BranchWallet;
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
        $users = Customer::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->simplePaginate(50);

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
            'daily_amount' => 'nullable'
        ]);

        $customer = Customer::create([
            'account_id' => $this->generateAccountId(),
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
            'initial_unit' => 0
        ]);

        Wallet::create([
            'customer_id' => $customer->id,
            'balance' => 0
        ]);
        return redirect(route('index'))->with('success', 'Customer created successfully');
    }

    public function generateAccountId(){
        $digits_needed=8;

        $random_number=''; // set up a blank string

        $count=0;

        while ( $count < $digits_needed ) {
            $random_digit = mt_rand(0, 9);

            $random_number .= $random_digit;
            $count++;
        }

        $permitted_string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $length = 2;
        $input_length = strlen($permitted_string);
        $random_string = '';
        for($i = 0; $i < $length; $i++) {
            $random_character = $permitted_string[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }
        $account_id = $random_number . $random_string;

        $customer = Customer::where('account_id', $account_id)->first();
        if($customer){
            $this->generateAccountId();
        }

        return $account_id;
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
        if($banks !== null and $banks->status == 'success'){
            usort($banks->data, function($a, $b){ return strcmp($a->name, $b->name); });
        }else{
            $banks = [];
        }
        $user = Customer::findOrFail($id);
        $wallet = Wallet::where([['customer_id', '=', $id]])->first();
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
        $wallet = Wallet::where([['customer_id', '=', $id]])->first();
        if(!$wallet){
            return back()->with('error', 'Could not retrieve customer wallet');
        }
        $balance = $wallet->balance;
        return view('save', compact('user', 'balance'));
    }

    public function mark(Request $request){

        $request->validate([
            'id' => 'required|numeric',
            'amount' => 'required|numeric',
            'remark' => 'nullable|string'
        ]);
        // Retrieve the customer
        $customer = Customer::findOrFail($request->id);
        // Get the customer wallet
        $customerWallet = Wallet::where([['customer_id', '=', $request->id]])->first();
        if(!$customerWallet){
            return back()->with('error', 'Could not retrieve customer wallet');
        }

        $balance = $customerWallet->balance;

        Transaction::create([
            'user_id' => auth()->user()->id,
            'branch_id' => auth()->user()->branch_id,
            'customer_id' => $customer->id,
            'txn_ref' => Str::random(10),
            'user_type' => 'user',
            'txn_type' => 'credit',
            'purpose' => 'deposit',
            'option' => $request->option,
            'amount' => $request->amount,
            'balance_before' => $balance,
            'balance_after' => $balance + $request->amount,
            'description' => 'Deposit from ' . $customer->first_name . ' ' . $customer->surname . ' by ' . auth()->user()->name,
            'remark' => $request->remark
        ]);


        $customerWallet->balance = $balance + $request->amount;
        $customerWallet->save();

        if($request->option === 'bank'){
            BranchWallet::updateOrCreate(['branch_id' => auth()->user()->branch_id],
                                        ['balance' => DB::raw('balance +'. $request->amount),
                                            'bank' => DB::raw('bank +'. $request->amount),
                                        ]);
        }else{
            BranchWallet::updateOrCreate(['branch_id' => auth()->user()->branch_id],
                                        ['balance' => DB::raw('balance +'. $request->amount),
                                         'cash' => DB::raw('cash +'. $request->amount)]);
        }

        return back()->with('success', 'Customer\'s payment saved successfully');
    }

    public function withdraw($id){
        $user = Customer::findOrFail($id);
        $wallet = Wallet::where([['customer_id', '=', $id]])->first();
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
            'charges' => 'nullable|numeric',
        ]);
        $customer = Customer::findOrFail($request->id);
        $customerWallet = Wallet::where([['customer_id', '=', $request->id]])->first();
        if(!$customerWallet){
            return back()->with('error', 'Customer wallet not found');
        }

        if($request->amount < 1){
            return back()->with('error', 'Withdrawal amount is too small');
        }

        if($request->charges == null or $request->charges < 1){
            $request->charges = 0;
        }
        $totalAmount = $request->amount + $request->charges;
        if($totalAmount > $customerWallet->balance){
            return back()->with('error', 'Total amount to be withdrawn is more than the customer\'s balance');
        }

        $branchWallet = BranchWallet::where('branch_id', auth()->user()->branch_id)->first();
        $cashBalance = $branchWallet->cash;
        $bankBalance = $branchWallet->bank;

        if($request->option === 'cash' and $totalAmount > $cashBalance ){
            return back()->with('error', 'Total amount to be withdrawn is more than the branch\'s cash balance. Use another withdrawal option or contact manager');
        }
        if($request->option === 'bank' and $totalAmount > $bankBalance ){
            return back()->with('error', 'Total amount to be withdrawn is more than the customer\'s bank balance. Use another withdrawal option or contact manager');
        }


        $t = Transaction::create([
            'user_id' => auth()->user()->id,
            'branch_id' => auth()->user()->branch_id,
            'customer_id' => $customer->id,
            'txn_ref' => Str::random(10),
            'txn_type' => 'debit',
            'user_type' => 'user',
            'purpose' => 'withdrawal',
            'option' => $request->option,
            'amount' => $request->amount,
            'balance_before' => $customerWallet->balance,
            'balance_after' => $customerWallet->balance - $request->amount,
            'description' => 'Withdrawal for ' . $customer->first_name . ' ' . $customer->surname . ' by ' . auth()->user()->name,
            'remark' => $request->remark,
        ]);

        $customerWallet->balance = $customerWallet->balance - $request->amount;
        $customerWallet->save();

        if($request->option === 'bank'){
            BranchWallet::updateOrCreate(['branch_id' => auth()->user()->branch_id],
                ['balance' => DB::raw('balance -'. $request->amount),
                    'bank' => DB::raw('bank -'. $request->amount),
                    ]);
        }else{
            BranchWallet::updateOrCreate(['branch_id' => auth()->user()->branch_id],
                ['balance' => DB::raw('balance -'. $request->amount),
                 'cash' => DB::raw('cash -'. $request->amount)]);
        }
        if($request->charges > 0){
            Transaction::create([
                'user_id' => auth()->user()->id,
                'branch_id' => auth()->user()->branch_id,
                'customer_id' => $customer->id,
                'txn_ref' => Str::random(10),
                'txn_type' => 'debit',
                'user_type' => 'user',
                'purpose' => 'commission',
                'option' => $request->option,
                'amount' => $request->charges,
                'balance_before' => $t->balance_after,
                'balance_after' => $t->balance_after - $request->charges,
                'description' => 'Commission from ' . $customer->first_name . ' ' . $customer->surname . '\'s withdrawal by ' . auth()->user()->name,
                'remark' => $request->remark,
            ]);

            $customerWallet->balance = $customerWallet->balance - $request->charges;
            $customerWallet->save();
        }


        return redirect(route('show', $request->id))->with('success', 'Withdrawal successful');
    }

    public function daily(){
        $total = Transaction::where([['user_id','=', auth()->user()->id],['user_type', '=', 'user'], ['txn_type', '=', 'credit'], ['created_at', '>', Carbon::today()]])->sum('amount');
        $transactions = Transaction::where([['user_id','=', auth()->user()->id], ['user_type', '=', 'user'], ['created_at', '>', Carbon::today()]])->orderBy('id', 'desc')->simplePaginate(31);
        $balance = $total;

        return view('daily', compact('transactions', 'balance'));
    }

    public function history(Request $request){

        $total = Transaction::where([['user_id','=', auth()->user()->id],['user_type', '=', 'user'], ['txn_type', '=', 'credit']])->whereBetween('created_at', [
            Carbon::now()->startOfYear(),
            Carbon::now()->endOfYear(),
        ])->sum('amount');

        $yearlyCredit = Transaction::where([['user_id','=', auth()->user()->id], ['user_type', '=', 'user'], ['txn_type', '=', 'credit']])->whereBetween('created_at', [
            Carbon::now()->startOfYear(),
            Carbon::now()->endOfYear(),
        ])->sum('amount');
        $yearlyDebit = Transaction::where([['user_id','=', auth()->user()->id],['user_type', '=', 'user'], ['txn_type', '=', 'debit']])->whereBetween('created_at', [
            Carbon::now()->startOfYear(),
            Carbon::now()->endOfYear(),
        ])->sum('amount');

        if($request->start !== null and $request->end !== null){
//            dd($request->start, $request->end);
            $transactions = Transaction::where([['user_id', '=', auth()->user()->id], ['user_type', '=', 'user']])->whereBetween('created_at', [
                $request->start,
                $request->end,
            ])->orderBy('id', 'desc')->simplePaginate(31);
        }elseif($request->start !== null and $request->end == null){
            $transactions = Transaction::where([['user_id', '=', auth()->user()->id], ['user_type', '=', 'user']])->whereBetween('created_at', [
                $request->start,
                Carbon::now(),
            ])->orderBy('id', 'desc')->simplePaginate(31);
        }elseif($request->start == null and $request->end !== null){
            $transactions = Transaction::where([['user_id', '=', auth()->user()->id], ['user_type', '=', 'user']])->whereBetween('created_at', [
                Carbon::now()->startOfYear(),
                $request->end,
            ])->orderBy('id', 'desc')->simplePaginate(31);
        }elseif($request->start == null and $request->end == null){

            $transactions = Transaction::where([['user_id', '=', auth()->user()->id], ['user_type', '=', 'user']])->whereBetween('created_at', [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear(),
            ])->orderBy('id', 'desc')->simplePaginate(31);
        }

        $balance = $yearlyCredit - $yearlyDebit;

        return view('history', compact('transactions', 'balance'));
    }

    public function customerHistory($id){

        $wallet = Wallet::where([['customer_id', '=', $id]])->first();
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
            ->orWhere([['account_id', 'LIKE', "%{$id}%"],['user_id','=', auth()->user()->id]])
            ->orWhere([['phone', 'LIKE', "%{$id}%"],['user_id','=', auth()->user()->id]])->with('branch')->get();

        if($customers->count() > 0){
            return response()->json(['data' => $customers, 'status' => 'success', 'message' => 'Customer(s) retrieved successfully']);
        }else{
            return response()->json(['data' => [], 'status' => 'error', 'message' => 'Customer retrieval failed']);
        }
    }
}
