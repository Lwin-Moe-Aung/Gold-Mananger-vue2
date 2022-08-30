<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\ExpenseFor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admins\ExpenseForRequest;
use Inertia\Inertia;

class ExpenseForController extends Controller
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
        $expense_fors = ExpenseFor::query();
        $expense_fors->where('business_id', '=', $business_id);

        if (request('search')) {
            $expense_fors->where('price', 'LIKE', '%' . request('search') . '%');
        }

        if (request()->has(['field', 'direction'])) {
            $expense_fors->orderBy(request('field'), request('direction'));
        }
        $expense_fors->orderBy('created_at', 'DESC');
        return Inertia::render('AdminPanel/ExpenseManagement/ExpenseFor/Index', [
            'expense_fors' => $expense_fors->paginate(5)->withQueryString(),
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseForRequest $request)
    {
        try {
            ExpenseFor::create([
                'business_id' => auth()->user()->business_id,
                'name' => $request->name,
            ]);
            return back();
        } catch (\Exception $e) {
            return back()->with('fail', 'Fail to Create Expense Category');
        }
    }


    public function storeDialog(ExpenseForRequest $request)
    {
        try {
            $expense_for = ExpenseFor::create([
                'business_id' => auth()->user()->business_id,
                'name' => $request->name,
            ]);
            return response()->json(['data'=>$expense_for]);
        } catch (\Exception $e) {
            return back()->with('fail', 'Fail to Create Expense Category');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExpenseForRequest $request, $id)
    {
        try {
            $expense_for = ExpenseFor::find($id);
            $expense_for->name = $request->name;
            $expense_for->save();
            return back();
        } catch (\Exception $e) {
            return back()->withErrors(['fail' => 'Fail to Update Expense Category']);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense_for = ExpenseFor::find($id);
        $expense_for->delete();
        return back();
    }
}
