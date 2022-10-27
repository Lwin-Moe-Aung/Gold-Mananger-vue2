<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Models\Transaction;
use App\Models\ExpenseCategory;
use App\Models\Expense;
use App\Models\User;
use App\Models\ExpenseFor;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admins\ExpenseRequest;
use Carbon\Carbon;
use DB;


class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:name,city']
        ]);

        $business_id = auth()->user()->business_id;

        $transactions = Transaction::query();
        $transactions->where('business_id', $business_id)->where('type','expense');

        if (request('search')) {
            $transactions->where('ref_no', 'LIKE', '%' . request('search') . '%');
        }
        if (request()->has(['field', 'direction'])) {
            $transactions->orderBy(request('field'), request('direction'));
        }else{
            $transactions->orderBy('created_at', 'desc');
        }
        $transactions = $transactions->paginate(5)->withQueryString();
        foreach ($transactions as $key=>$value) {
            // dd($value->expense->expense_category);
            $transactions[$key]->expense = $value->expense;
            $transactions[$key]->expense_category = $value->expense->expense_category;
        }
        return Inertia::render('AdminPanel/ExpenseManagement/Expense/Index', [
            'transactions' =>  $transactions,
            'filters' => request()->all(['search', 'field', 'direction'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('AdminPanel/ExpenseManagement/Expense/Create', [
            'transaction' => null,
            'expense_categories' => ExpenseCategory::where('business_id',auth()->user()->business_id)->get(),
            'expense_fors' => ExpenseFor::where('business_id',auth()->user()->business_id)->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseRequest $request)
    {
        try {
            DB::beginTransaction();
            $transaction = Transaction::create([
                'business_id' => auth()->user()->business_id,
                'business_location_id' => auth()->user()->business_location_id,
                'type' => "expense",
                'status' => "received",
                'payment_status' => "paid",
                'ref_no' => $request->ref_no,
                'transaction_date' =>  Carbon::parse($request->date)->format('Y-m-d'),
                'created_by' =>  auth()->user()->id,
            ]);
             if ($file = $request->file('image')) {
                $image_name = uniqid() . str_replace(' ', '', $file->getClientOriginalName());
                $path = '/images/expense/';
                $file->move(public_path($path), $image_name);
                $image_name_path = $path . $image_name;
            } else {
                $image_name_path = null;
            }
            Expense::create([
                'transaction_id' => $transaction->id,
                'expense_category_id' => $request->expense_category_id,
                'expense_for_id' => $request->expense_for_id,
                'amount' =>  $request->total_amount,
                'additional_notes' =>  $request->additional_notes,
                'image' => $image_name_path,
            ]);
            DB::commit();
            return redirect()->route('admin.expenses.index');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('fail', 'Fail to Create New Daily Price');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expense = Expense::with(['expense_category', 'expense_for'])->where('transaction_id', $id)->first();

        return Inertia::render('AdminPanel/ExpenseManagement/Expense/Detail', [
            'expense' =>  $expense,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $transaction = Transaction::find($id);
        $transaction->expense = $transaction->expense;
        $transaction->expense_category = $transaction->expense->expense_category;
        $transaction->expense_for = $transaction->expense->expense_for;

        return Inertia::render('AdminPanel/ExpenseManagement/Expense/Create', [
            'transaction' => $transaction,
            'expense_categories' => ExpenseCategory::where('business_id',auth()->user()->business_id)->get(),
            'expense_fors' => ExpenseFor::where('business_id',auth()->user()->business_id)->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function expensesUpdate(ExpenseRequest $request)
    {
        // dd(Carbon::now()->toDayDateTimeString());
        // dd($request->all());
        // dd(Carbon::parse($request->date)->toDateString());
        try {
            DB::beginTransaction();
            $transaction = Transaction::find($request->id);
            $transaction->ref_no = $request->ref_no;
            $transaction->transaction_date = Carbon::parse($request->date)->format('Y-m-d');
            $transaction->save();

            $expense = Expense::where('transaction_id', $request->id)->first();
            $expense->expense_category_id = $request->expense_category_id;
            $expense->expense_for_id = $request->expense_for_id;
            $expense->amount = $request->total_amount;
            $expense->additional_notes = $request->additional_notes;

            if ($file = $request->file('image')) {
                $image_name = uniqid() . str_replace(' ', '', $file->getClientOriginalName());
                $path = '/images/expense/';
                $file->move(public_path($path), $image_name);
                $image_name_path = $path . $image_name;
                $expense->image = $image_name_path;
            }
            $expense->save();
            DB::commit();
            return redirect()->route('admin.expenses.index');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('fail', 'Fail to Create New Daily Price');
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteRecord($id)
    {
        $transaction = Transaction::find($id);
        $transaction->delete();
        return response()->json([
            'status' => true,
        ]);
    }
}
