<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\BranchWallet;
use App\Models\Customer;
use App\Models\Loan;
use App\Models\Manager;
use App\Models\Marketer;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Waitlist;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $yearlyCredit= Transaction::where([['branch_id','=', $branch], ['txn_type', '=', 'credit']])->whereBetween('created_at', [
            Carbon::now()->startOfYear(),
            Carbon::now()->endOfYear(),
        ])->sum('amount');
        $yearlyDebit = Transaction::where([['branch_id','=', $branch], ['txn_type', '=', 'debit'], ['purpose','=','withdrawal'],['purpose','!=','commission']])->whereBetween('created_at', [
            Carbon::now()->startOfYear(),
            Carbon::now()->endOfYear(),
        ])->sum('amount');

        $b = BranchWallet::where('branch_id', auth('manager')->user()->branch_id)->first();
        if(!$b){
            $balance = 0;
        }else{
            $balance = $b->balance;
        }
//
//        $loanTaken = Transaction::where([['branch_id','=', $branch], ['txn_type', '=', 'credit'],['purpose', '=', 'loan']])->whereBetween('created_at', [
//            Carbon::now()->startOfYear(),
//            Carbon::now()->endOfYear()
//        ])->sum('amount');
//        $loanPaid = Transaction::where([['branch_id','=', $branch], ['txn_type', '=', 'debit'],['purpose', '=', 'loan']])->whereBetween('created_at', [
//            Carbon::now()->startOfYear(),
//            Carbon::now()->endOfYear()
//        ])->sum('amount');
        $loanTaken = Loan::where([['branch_id', '=', auth('manager')->user()->branch_id], ['status', '!=', 'rejected']])->sum('amount');
        $amountPaidBack = Loan::where([['branch_id', '=', auth('manager')->user()->branch_id], ['status', '!=', 'rejected']])->sum('paid');
        $loanReceived = $loanTaken - $amountPaidBack;

        $loanGiven = Loan::where([['lender_id', '=', auth('manager')->user()->branch_id], ['status', '!=', 'rejected']])->sum('amount');
        $amountRecoveredBack = Loan::where([['lender_id', '=', auth('manager')->user()->branch_id], ['status', '!=', 'rejected']])->sum('paid');
        $loanGivenOut = $loanGiven - $amountRecoveredBack;
        $transactions = Transaction::where('branch_id', $branch)->orderBy('id', 'desc')->take(30)->get();
        return view('manager.home', compact('totalCustomers','yearlyCredit', 'yearlyDebit',
                                                    'transactions', 'balance', 'loanReceived', 'loanGivenOut'));
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

        $user = Customer::findOrFail($id);
        $wallet = Wallet::where([['customer_id', '=', $id]])->first();
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



    public function history(Request $request){

        $branch = auth('manager')->user()->branch_id;
        $b = BranchWallet::where('branch_id', auth('manager')->user()->branch_id)->first();
        if(!$b){
            $balance = 0;
            $bank = 0;
            $cash = 0;
        }else{
            $balance = $b->balance;
            $bank = $b->bank;
            $cash = $b->cash;
        }

        if($request->start !== null and $request->end !== null){
//            dd($request->start, $request->end);
            $transactions = Transaction::where('branch_id', $branch)->whereBetween('created_at', [
                $request->start,
                $request->end,
            ])->orderBy('id', 'desc')->simplePaginate(31);
        }elseif($request->start !== null and $request->end == null){
            $transactions = Transaction::where(['branch_id', $branch])->whereBetween('created_at', [
                $request->start,
                Carbon::now(),
            ])->orderBy('id', 'desc')->simplePaginate(31);
        }elseif($request->start == null and $request->end !== null){
            $transactions = Transaction::where('branch_id', $branch)->whereBetween('created_at', [
                Carbon::now()->startOfYear(),
                $request->end,
            ])->orderBy('id', 'desc')->simplePaginate(31);
        }elseif($request->start == null and $request->end == null){

            $transactions = Transaction::where('branch_id', $branch)->whereBetween('created_at', [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear(),
            ])->orderBy('id', 'desc')->simplePaginate(31);
        }

        return view('manager.history', compact('transactions', 'balance', 'cash', 'bank'));
    }





    public function customerHistory($id){
        $branch = auth('manager')->user()->branch_id;
        $wallet = Wallet::where([['customer_id', '=', $id]])->first();
        if(!$wallet){
            $balance = 0;
        }else{
            $balance = $wallet->balance;
        }
        if(!$wallet){
            return back()->with('error', 'Could not retrieve customer wallet');
        }
        $transactions = Transaction::where('customer_id', $id)->orderBy('id', 'desc')->simplePaginate(31);

        return view('manager.customerhistory', compact('transactions', 'balance'));
    }


    public function password(){
        return view('manager.password');
    }

    public function changePassword(Request $request){
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|string|min:8|confirmed'
        ]);
        $user = User::where('id',auth('manager')->user()->id)->first();
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


    public function search($id){

        $customers =  Customer::where([['first_name', 'LIKE', "%{$id}%"], ['branch_id','=', auth('manager')->user()->branch_id]])
            ->orWhere([['surname', 'LIKE', "%{$id}%"],['branch_id','=', auth('manager')->user()->branch_id]])
            ->orWhere([['phone', 'LIKE', "%{$id}%"],['branch_id','=', auth('manager')->user()->branch_id]])->with('branch')->get();

        if($customers->count() > 0){
            return response()->json(['data' => $customers, 'status' => 'success', 'message' => 'Customer(s) retrieved successfully']);
        }else{
            return response()->json(['data' => [], 'status' => 'error', 'message' => 'Customer retrieval failed']);
        }
    }

    public function recordExpenditure(){
        $b = BranchWallet::where('branch_id', auth('manager')->user()->branch_id)->first();
        if(!$b){
            $balance = 0;
            $bank = 0;
            $cash = 0;
        }else{
            $balance = $b->balance;
            $bank = $b->bank;
            $cash = $b->cash;
        }
        return view('manager.recordexpenditure', compact('balance', 'bank', 'cash'));
    }

    public function saveExpenditure(Request $request){
        $request->validate([
            'amount' => 'required|numeric',
            'option' => 'required',
            'description' => 'string|required',
            'remark' => 'nullable'
        ]);
        if($request->amount < 1){
            return back()->with('error', 'Invalid amount');
        }
        $branchWallet = BranchWallet::where('branch_id', auth('manager')->user()->branch_id)->first();
        $balance = $branchWallet->balance;
        $bank = $branchWallet->bank;
        $cash = $branchWallet->cash;

        if($request->option == 'cash' and $request->amount > $cash){
            return back()->with('error', 'Insufficient cash balance');
        }elseif ($request->option == 'bank' and $request->amount > $bank){
            return back()->with('error', 'Insufficient bank balance');
        }

        Transaction::create([
            'user_id' => auth('manager')->user()->id,
            'branch_id' => auth('manager')->user()->branch_id,
            'txn_ref' => Str::random(10),
            'user_type' => 'manager',
            'txn_type' =>'debit',
            'purpose' => 'logistics',
            'option' => $request->option,
            'amount' => $request->amount,
            'balance_before' => $balance,
            'balance_after' => $balance + $request->amount,
            'description' => $request->description,
            'remark' => $request->remark
        ]);

        if($request->option === 'bank'){
            BranchWallet::updateOrCreate(['branch_id' => auth('manager')->user()->branch_id],
                ['balance' => DB::raw('balance -' . $request->amount),
                    'bank' => DB::raw('bank -' . $request->amount)]);
        }else{
            BranchWallet::updateOrCreate(['branch_id' => auth('manager')->user()->branch_id],
                ['balance' => DB::raw('balance -' . $request->amount),
                    'cash' => DB::raw('cash -' . $request->amount),
                ]);
        }

        return back()->with('success', 'Transaction recorded successfully');
    }

    public function getLoan(){
        $branches = Branch::where('id',  '!=', auth('manager')->user()->branch_id)->get();
        $loans = Loan::where('branch_id', auth('manager')->user()->branch_id)->with('lender')->get();

        return view('manager.getloan', compact('branches', 'loans'));
    }

    public function applyForLoan(Request $request){
        $request->validate([
            'amount' => 'required|numeric',
            'branch' => 'required|numeric'
        ]);

        Loan::create([
            'request_amount' => $request->amount,
            'branch_id' => auth('manager')->user()->branch_id,
            'manager_id' => auth('manager')->user()->id,
            'lender_id' =>$request->branch,
        ]);

        return back()->with('success', 'Loan application successful');
    }

    public function repayLoan(){
        $loans = Loan::where([['branch_id', '=', auth('manager')->user()->branch_id],['status','=','approved']])->with('lender')->get();
        return view('manager.repay', compact('loans'));
    }

    public function storeLoanRepayment(){

    }

    public function getLoanRequests(){
        $loans = Loan::where([['lender_id', '=', auth('manager')->user()->branch_id],['status','=','pending']])->with('branch')->get();
        return view('manager.loanrequests', compact('loans'));
    }

    public function approveLoan(Request $request){
        $request->validate([
            'id' => 'required|numeric',
            'amount' => 'required',
            'option' => 'required',
        ]);
//        $loan = Loan::findOrFail($request->id);

//        $wallet = BranchWallet::where('branch_id', $loan->branch_id)->first();
//        dd($loan, $loan->branch_id, $wallet, BranchWallet::all(),'Manager branch ID',auth('manager')->user()->branch_id,  'Creditor is:',BranchWallet::where('branch_id', auth('manager')->user()->branch_id)->first());
        DB::transaction(function () use ($request) {
//            dd($request->id, $request->option, $request->amount);
            $loan = Loan::findOrFail($request->id);

            $creditor = BranchWallet::where('branch_id', auth('manager')->user()->branch_id)->first();
            if(!$creditor){
                return back()->with('error', 'An error occurred and branch wallet could not be retrieved!');
            }

            if($request->option == 'cash' and $creditor->cash < (int)$request->amount){
                return back()->with('error', 'You do not have enough cash at hand to approve this loan');
            }

            if($request->option == 'bank' and $creditor->bank < (int)$request->amount){
                return back()->with('error', 'You do not have enough money in the bank to approve this loan');
            }
            $wallet = BranchWallet::where('branch_id', $loan->branch_id)->first();

            // Debit the creditor
            Transaction::create([
                'user_id' => auth('manager')->user()->id,
                'branch_id' => auth('manager')->user()->branch_id,
                'txn_ref' => Str::random(10),
                'user_type' => 'manager',
                'txn_type' =>'debit',
                'purpose' => 'loan',
                'option' => $request->option,
                'amount' => $request->amount,
                'balance_before' => $creditor->balance,
                'balance_after' => $creditor->balance  - (int)$request->amount,
                'description' => 'Loan given to '. $loan->branch->name,
                'remark' => ''
            ]);
            // Update his wallet
            if($request->option === 'bank'){
                $creditor->update(
                    ['balance' => DB::raw('balance -' . $request->amount),
                        'bank' => DB::raw('bank -' . $request->amount)]);
            }else{
                $creditor->update(
                    ['balance' => DB::raw('balance -' . $request->amount),
                        'cash' => DB::raw('cash -' . $request->amount),
                    ]);
            }

            // Credit the branch that is requesting the loan
            Transaction::create([
                'user_id' => $loan->manager_id,
                'branch_id' => $loan->branch_id,
                'txn_ref' => Str::random(10),
                'user_type' => 'manager',
                'txn_type' =>'credit',
                'purpose' => 'loan',
                'option' => $request->option,
                'amount' => $request->amount,
                'balance_before' => $wallet->balance,
                'balance_after' => $wallet->balance + $request->amount,
                'description' => 'Loan collected from '. $loan->lender->name,
                'remark' => ''
            ]);

            if($request->option === 'bank'){
                dd('something should happen here in banck');
                $wallet->update(
                    ['balance' => DB::raw('balance +' . $request->amount),
                        'bank' => DB::raw('bank +' . $request->amount)]);
            }else{

                $wallet->update(
                    ['balance' => DB::raw('balance +' . $request->amount),
                        'cash' => DB::raw('cash +' . $request->amount),
                    ]);
            }
            $loan->status = 'approved';
            $loan->amount = $request->amount;
            $loan->save();

        });


        return back()->with('success', 'Loan approved successfully');
    }

    public function rejectLoan(Request $request){
        $request->validate([
            'id' => 'required|numeric',
        ]);
        $loan = Loan::findOrFail($request->id);
        $loan->status = 'rejected';
        $loan->save();

        return back()->with('success', 'Loan rejected successfully');
    }

    public function paybackLoan(Request $request){
        $request->validate([
            'id' => 'required|numeric',
            'amount' => 'required',
            'option' => 'required',
        ]);

        $creditor = BranchWallet::where('branch_id', auth('manager')->user()->branch_id)->first();
        if(!$creditor){
            return back()->with('error', 'An error occurred and branch wallet could not be retrieved!');
        }

        if($request->option == 'cash' and $creditor->cash < (int)$request->amount){
            return back()->with('error', 'You do not have enough cash at hand to payback this loan');
        }

        if($request->option == 'bank' and $creditor->bank < (int)$request->amount){
            return back()->with('error', 'You do not have enough money in the bank to pay back this loan');
        }

        DB::transaction(function () use ($request, $creditor) {
            $loan = Loan::findOrFail($request->id);
            $wallet = BranchWallet::where('branch_id', $loan->lender_id)->first();
            if(($loan->paid + $request->amount) < $loan->amount){
                $loan->paid += $request->amount;
            }elseif (($loan->paid + $request->amount) == $loan->amount){
                $loan->status = 'paid';
                $loan->paid += $request->amount;
            }elseif(($loan->paid + $request->amount) > $loan->amount){
                return back()->with('error', 'The amount you specified is more than what you owe. Make the figures to tally');
            }
            $loan->save();
            Transaction::create([
                'user_id' => auth('manager')->user()->id,
                'branch_id' => auth('manager')->user()->branch_id,
                'txn_ref' => Str::random(10),
                'user_type' => 'manager',
                'txn_type' =>'debit',
                'purpose' => 'loan',
                'option' => $request->option,
                'amount' => $request->amount,
                'balance_before' => $creditor->balance,
                'balance_after' => $creditor->balance  - (int)$request->amount,
                'description' => 'Loan payback to '. $loan->lender->name,
                'remark' => ''
            ]);
            // Update his wallet
            if($request->option === 'bank'){
                $creditor->update(
                    ['balance' => DB::raw('balance -' . $request->amount),
                        'bank' => DB::raw('bank -' . $request->amount)]);
            }else{
                $creditor->update(
                    ['balance' => DB::raw('balance -' . $request->amount),
                        'cash' => DB::raw('cash -' . $request->amount),
                    ]);
            }

            // Branch that is getting paid
            Transaction::create([
                'user_id' => $loan->manager_id,
                'branch_id' => $loan->lender->id,
                'txn_ref' => Str::random(10),
                'user_type' => 'manager',
                'txn_type' =>'credit',
                'purpose' => 'loan',
                'option' => $request->option,
                'amount' => $request->amount,
                'balance_before' => $wallet->balance,
                'balance_after' => $wallet->balance + $request->amount,
                'description' => 'Loan payback from '. $loan->branch->name,
                'remark' => ''
            ]);

            if($request->option === 'bank'){
                $wallet->update(
                    ['balance' => DB::raw('balance +' . $request->amount),
                        'bank' => DB::raw('bank +' . $request->amount)]);
            }else{

                $wallet->update(
                    ['balance' => DB::raw('balance +' . $request->amount),
                        'cash' => DB::raw('cash +' . $request->amount),
                    ]);
            }

        });

        return back()->with('success', 'Loan payment recorded successfully');
    }

    public function transaction($id){
        $transaction = Transaction::where([['txn_ref', '=', $id]])->with('branch')->first();
        return view('manager.transaction', compact('transaction'));
    }
}
