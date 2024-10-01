<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Room;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {        
        $schedule = Schedule::with('room')->orderBy('room_id', 'asc')->orderBy('start_time', 'asc')->get();
    
        return response($schedule, 200); 
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
    public function store(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'start_time' => 'required|date|after_or_equal:now',            
            'end_time' => 'required|date|after:start_time',
            'title' => 'required|string|max:255', 
        ]);

        if ($validator->fails())
        {
            return response($validator->errors(), 500);
        }

        $conflict = Schedule::where('room_id', $id)
        ->where(function ($query) use ($request) {
            $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                  ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                  ->orWhere(function ($query) use ($request) {
                      $query->where('start_time', '<=', $request->start_time)
                            ->where('end_time', '>=', $request->end_time);
                  });
        })
        ->exists();

        if ($conflict) {
            return response()->json(['error' => 'This room has a schedule'], 422);
        }

        $room = Room::findOrFail($id);

        $schedule = new Schedule([
            'room_id' => $id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'title' => $request->title
        ]);

        $room->schedules()->save($schedule);
        
        return response($room, 200);  
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $schedule = Schedule::findOrFail($id);
        
        return response($schedule, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, string $scheduleId)
    {
        $schedule = Schedule::findOrFail($scheduleId);

        $validator = Validator::make($request->all(), [
            'start_time' => 'required|date|after_or_equal:now',            
            'end_time' => 'required|date|after:start_time',
            'title' => 'required|string|max:255', 
        ]);

        if ($validator->fails())
        {
            return response($validator->errors(), 500);
        }

        $conflict = Schedule::where('room_id', $id)
        ->where(function ($query) use ($request) {
            $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                  ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                  ->orWhere(function ($query) use ($request) {
                      $query->where('start_time', '<=', $request->start_time)
                            ->where('end_time', '>=', $request->end_time);
                  });
        })
        ->exists();

        if ($conflict) {
          return response()->json(['error' => 'Schedule conflicts', 422]);  
        }       
                 
        $schedule->update([
            'room_id' => $id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'title' => $request->title
        ]);
                
        return response($schedule, 200);  
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $schedule= Schedule::destroy($id);
        return response($schedule, 200);
    }
}
