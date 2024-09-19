<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $room = Room::with('features')->get();
    
        return response($room, 200); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:rooms',            
            'features' => 'required|array', // Expecting an array of feature IDs
            'features.*' => 'exists:features,id', // Each feature ID must exist in the features table
        ]);

        if ($validator->fails())
        {
            return response($validator->errors(), 500);
        }
                 
        $room = Room::create(['name' => $request->name]);
        
        $room->features()->attach($request->features);
        
        return response($room, 200);  
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $room = Room::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:rooms,name,' . $id,
            'features' => 'required|array', // Expecting an array of feature IDs
            'features.*' => 'exists:features,id', // Each feature ID must exist in the features table
        ]);

        if ($validator->fails())
        {
            return response($validator->errors(), 500);
        }
                 
        $room->name = $request->input('name');
        $room->save();

        $room->features()->sync($request->input('features'));
        
        return response($room, 200);  
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $feature= Room::destroy($id);
        return response($feature, 200);
    }
}
