<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Contact;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $business_id = Auth::user()->business_id;
        $suppliers = Contact::where('business_id', $business_id)
                ->where('type', 'supplier')
                ->latest()
                ->paginate(5);
        return Inertia::render('Admins/ContactManagement/Supplier/Index',[
            'suppliers' => $suppliers
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
    public function store(Request $request) {
        if (auth()->user()->hasAnyRole(['super-admin', 'admin'])) {

            $this->validate($request, [
                'name' => ['required', 'max:50'],
                'email' => ['required', 'string', 'email', 'max:50', 'unique:users'],
                'mobile1' => ['required'],
            ]);
            try {
                Contact::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'type' => 'supplier',
                    'mobile1' => $request->mobile1,
                    'mobile2' => $request->mobile2,
                    'address' => $request->address,
                    'supplier_business_name' => $request->supplier_business_name,
                    'created_by' => auth()->user()->id,
                    'business_id' => auth()->user()->business_id,
                    'business_location_id' => auth()->user()->business_location_id,
                ]);
                // $request->session()->put('message', 'hello hello bar tone');
                // // Session::put('message', 'hello bar tone');
                return back();
            } catch (\Exception $e) {
                return back()->with('fail','Fail to Create Supplier');
            }
        }
        return back()->withErrors(['fail' => 'No permission']);
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
    public function update(Request $request, $id) {
        // return $contact;
        if (auth()->user()->hasAnyRole(['super-admin', 'admin'])) {
            $this->validate($request, [
                'name' => ['required', 'max:50'],
                'email' => 'required|unique:contacts,email,'.$id,
                'mobile1' => ['required'],
            ]);
            try {
                $contact = Contact::find($id);
                $contact->name = $request->name;
                $contact->email = $request->email;
                $contact->address = $request->address;
                $contact->supplier_business_name = $request->supplier_business_name;
                $contact->mobile1 = $request->mobile1;
                $contact->mobile2 = $request->mobile2;
                $contact->created_by = auth()->user()->id;
                $contact->business_id = auth()->user()->business_id;
                $contact->business_location_id = auth()->user()->business_location_id;
                $contact->save();
                return back();
            } catch (\Exception $e) {
                return back()->withErrors(['fail' => 'Fail to Update Supplier']);
            }
        }
        return back()->withErrors(['fail' => 'No permission']);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        if (auth()->user()->hasAnyRole(['super-admin', 'admin'])) {
            $contact = Contact::find($id);
            $contact->delete();
            return back();
        }
        return back()->withErrors(['fail' => 'No permission']);
    }
}
