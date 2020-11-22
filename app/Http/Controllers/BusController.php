<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Bus;
use App\Http\Resources\Bus as BusResource;

class BusController extends Controller
{
    //::GET http://127.0.0.1:8000/api/buses :://
    public function index()
    {
        $buses = Bus::orderBy('created_at', 'desc')->paginate(5);

        return BusResource::collection($buses);
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

    //::POST http://127.0.0.1:8000/api/buses :://
    public function store(Request $request)
    {
        $bus = $request->isMethod('put') ? Bus::findOrFail($request->id): new Bus;

        $bus->id = $request->input('id');

        $bus->depart_loc = $request->input('depart_loc');
        $bus->arrival_loc = $request->input('arrival_loc');
        $bus->depart_date = $request->input('depart_date');
        $bus->depart_time = $request->input('depart_time');
        $bus->arrival_time = $request->input('arrival_time');
    
        if($bus->save()){
            return new BusResource($bus);
        }
    }
    
    //::GET http://127.0.0.1:8000/api/buses/4 :://
    public function show($id)
    {
        $bus = Bus::findOrFail($id);
        return new BusResource($bus);
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
    public function update(Request $request)
    {
        $bus = Bus::findOrFail($request->input('id'));

        $bus->depart_loc = $request->input('depart_loc');
        $bus->arrival_loc = $request->input('arrival_loc');
        $bus->depart_date = $request->input('depart_date');
        $bus->depart_time = $request->input('depart_time');
        $bus->arrival_time = $request->input('arrival_time');

        if($bus->update()){
            return new BusResource($bus);
        }
    }

    //::DELETE http://127.0.0.1:8000/api/buses/4 :://
    public function destroy($id)
    {
        $bus = Bus::findOrFail($id);

        if($bus->delete()){
            return new BusResource($bus);
        }
    }
}
