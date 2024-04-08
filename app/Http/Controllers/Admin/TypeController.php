<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTypeRequest;
use App\Http\Requests\UpdateTypeRequest;
use App\Models\Project;
use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = Type::all();

        return view('admin.types.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(StoreTypeRequest $request)
    {

        $request->validated();

        $data = $request->all();

        $type = new Type;

        $type->fill($data);
        $type->save();

        return redirect()->route('admin.types.show', compact('type'))->with('message-status', 'alert-success')->with('message-text', 'Type created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Type  $type
     */
    public function show(Type $type)
    {
        $projects = $type->projects->all();
        return view('admin.types.show', compact('type', 'projects'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Type  $type
     */
    public function edit(Type $type)
    {
        return view('admin.types.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Type  $type
     */
    public function update(UpdateTypeRequest $request, Type $type)
    {
        $request->validated();

        $data = $request->all();
        $type->update($data);

        return redirect()->route('admin.types.index')->with('message-status', 'alert-success')->with('message-text', 'Type modified successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Type  $type
     */
    public function destroy(Request $request, Type $type)
    {
        $data = $request->input('delete-choice');

        $projects = Project::all();
        if($data != 'delete-projects'){
            
            foreach($projects as $project){
                $project->type_id = $data;
                $project->save();
            }    
        } else {
            foreach($projects as $project){
                $project->delete();
            }
        }

        $type->delete();

        return redirect()->route('admin.types.index')->with('message-status', 'alert-danger')->with('message-text', 'Type deleted successfully');
    }
}
