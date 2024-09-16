<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Feature::all();
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
            'name' => 'required|string|max:255|unique:features',                    
        ]);

        if ($validator->fails())
        {
            return response($validator->errors(), 500);
        }
         
        
        $feature = Feature::create($request->all());      
        
        return response($feature, 200);  
    }

    /**
     * Display the specified resource.
     */
    public function show(Feature $feature)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Feature $feature)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $feature = Feature::findOrFail($id);

        $validator = Validator::make($request->all(), [            
            'name' => 'required|string|max:255|unique:features',                    
        ]);

        if ($validator->fails())
        {
            return response($validator->errors(), 500);
        }
         
        
        $feature->name = $request->input('name');
        $feature->save();
        
        return response($feature, 200);  
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $feature= Feature::destroy($id);
        return response($feature, 200);
    }
}
