<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTechnologyRequest;
use App\Http\Requests\UpdateTechnologyRequest;
use App\Models\Technology;
use Illuminate\Http\Request;

class TechnologyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $technologies = Technology::all();
        return view('admin.technologies.index', compact('technologies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return view('admin.technologies.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(StoreTechnologyRequest $request)
    {
        
        // $request->validated();

        $data = $request->all();

        $technology = new Technology;

        $technology->fill($data);
        $technology->save();

        return redirect()->route('admin.technologies.show', compact('technology'))->with('message-status', 'alert-success')->with('message-text', 'Technology created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Technology  $technology
     */
    public function show(Technology $technology)
    {
        $projects = $technology->projects->all();
        return view('admin.technologies.show', compact('technology', 'projects'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Technology  $technology

     */
    public function edit(Technology $technology)
    {
        return view('admin.technologies.edit', compact('technology'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Technology  $technology
     */
    public function update(UpdateTechnologyRequest $request, Technology $technology)
    {
        $request->validated();

        $data = $request->all();
        $technology->update($data);

        return redirect()->route('admin.technologies.index')->with('message-status', 'alert-success')->with('message-text', 'Technology modified successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Technology  $technology
     */
    public function destroy(Technology $technology)
    {
        $technology->projects()->detach();

        $technology->delete();

        return redirect()->route('admin.technologies.index')->with('message-status', 'alert-danger')->with('message-text', 'Technology deleted successfully');
    }
}
