<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OpenCloseDay;
use Inertia\Inertia;
use App\Http\Resources\OpeningClosingDayResource;

class OpeningClosingDayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('AdminPanel/SetupManagement/OpeningClosingDay/Index');
    }

    /**
     * get data for opening and closing day table
     */
    public function getOpeningClosingDataLists()
    {
        $paginate = request('paginate');
        if (isset($paginate)) {
            $openCloseDayData = OpenCloseDay::openCloseDaysQuery()->paginate($paginate);
        } else {
            $openCloseDayData = OpenCloseDay::openCloseDaysQuery()->get();
        }
        return OpeningClosingDayResource::collection($openCloseDayData);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('AdminPanel/SetupManagement/OpeningClosingDay/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
