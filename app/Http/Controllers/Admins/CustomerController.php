<?php

namespace App\Http\Controllers\Admins;

use Inertia\Inertia;
use App\Models\Contact;
use App\Models\Business;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Admins\ContactRequest;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $business_id = Auth::user()->business_id;
        $customers = Contact::where('business_id', $business_id)
            ->where('type', 'customer')
            ->latest()
            ->paginate(5);
        return Inertia::render('AdminPanel/ContactManagement/Customer/Index', [
            'customers' => $customers
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
    public function store(ContactRequest $request)
    {
        try {
            Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'type' => 'customer',
                'mobile1' => $request->mobile1,
                'mobile2' => $request->mobile2,
                'address' => $request->address,
                'created_by' => auth()->user()->id,
                'business_id' => auth()->user()->business_id,
                'business_location_id' => auth()->user()->business_location_id,
            ]);

            return back();
        } catch (\Exception $e) {
            return back()->with('fail', 'Fail to Create Customer');
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
    public function update(ContactRequest $request, $id)
    {
        try {
            $contact = Contact::find($id);
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->address = $request->address;
            $contact->mobile1 = $request->mobile1;
            $contact->mobile2 = $request->mobile2;
            $contact->created_by = auth()->user()->id;
            $contact->business_id = auth()->user()->business_id;
            $contact->business_location_id = auth()->user()->business_location_id;
            $contact->save();
            return back();
        } catch (\Exception $e) {
            return back()->withErrors(['fail' => 'Fail to Create Customer']);
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
        if (auth()->user()->hasAnyRole(['super-admin', 'admin'])) {
            $contact = Contact::find($id);
            $contact->delete();
            return back();
        }
        return back();
    }
}
