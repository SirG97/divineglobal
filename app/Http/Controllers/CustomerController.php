<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Wallet;
use Illuminate\Http\Request;

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
        $users = Customer::where('user_id', auth()->user()->id)->paginate(100);

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
            'office_address' => 'nullable',
            'state' => 'nullable',
            'lga' => 'nullable',
            'hometown' => 'nullable',
            'phone' => 'nullable',
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
            'initial_unit'  => $request->initial_unit,
            'bank_name' => $request->bank_name,
            'bank_code' => $request->bank_code,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'daily_amount' => $request->daily_amount
        ]);

        Wallet::create([
            'customer_id' => $customer->id,
            'balance' => 0
        ]);

        return back()->with('success', 'Customer created successfully');

    }

    public function show($id){
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
        $user = Customer::where('id', $id)->first();

        return view('customer', compact('user', 'banks'));
    }

    public function edit(){

    }

    public function update(){

    }

    public function savings(){

    }

    public function mark(){

    }

    public function withdraw(){

    }

    public function withdrawals(){

    }

    public function password(){

    }
}
