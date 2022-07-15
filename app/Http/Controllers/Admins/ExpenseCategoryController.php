<?php

namespace App\Http\Controllers\Admins;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\ExpenseCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admins\ExpenseCategoryRequest;

class ExpenseCategoryController extends Controller
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
        $expense_categorys = ExpenseCategory::query();
        $expense_categorys->where('business_id', '=', $business_id);

        if (request('search')) {
            $expense_categorys->where('price', 'LIKE', '%' . request('search') . '%');
        }

        if (request()->has(['field', 'direction'])) {
            $expense_categorys->orderBy(request('field'), request('direction'));
        }
        $expense_categorys->orderBy('created_at', 'DESC');
        return Inertia::render('AdminPanel/ExpenseManagement/ExpenseCategory/Index', [
            'expense_categorys' => $expense_categorys->paginate(5)->withQueryString(),
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
    public function store(ExpenseCategoryRequest $request)
    {
        try {
            ExpenseCategory::create([
                'business_id' => auth()->user()->business_id,
                'name' => $request->name,
            ]);
            return back();
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
    public function update(ExpenseCategoryRequest $request, $id)
    {
        try {
            $expense_category = ExpenseCategory::find($id);
            $expense_category->name = $request->name;
            $expense_category->save();
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
        $expense_category = ExpenseCategory::find($id);
        $expense_category->delete();
        return back();
    }
}
