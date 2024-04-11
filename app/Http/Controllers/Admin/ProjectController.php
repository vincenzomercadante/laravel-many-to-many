<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Mail\CreateProjectMail;
use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $projects = Project::all();
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Type::all();

        $technologies = Technology::all();


        return view('admin.projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(StoreProjectRequest $request)
    {
        $request->validated();

        $data = $request->all();

        $project = new Project;

        $project->fill($data);
        $project->slug = Str::slug($project->title);

        if($data['image']){
            $path_img = Storage::put('upload/projects', $data['image']);
            $project->image = $path_img;
        }

        $project->save();

        $project->technologies()->attach($data['technologies']);

        Mail::to('emails@mail.com')->send(new CreateProjectMail($project, Auth::user()->email));

        return redirect()->route('admin.projects.show', compact('project'))->with('message-status', 'alert-success')->with('message-text', 'Project created successfully');;
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        $technologies = Technology::all();

        return view('admin.projects.edit', compact('project', 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {

        $request->validated();

        $data = $request->all();
        $project->fill($data);

        $project->slug = Str::slug($project->title);

        if(isset($data['image'])){
            if($data['image'] && $project->image){
                Storage::delete($project->image);
                $path_img = Storage::put('upload/projects', $data['image']);
                $project->image = $path_img;

            } else if ($data['image'] && !$project->image) {
                $path_img = Storage::put('upload/projects', $data['image']);
                $project->image = $path_img;
            }
        }

        $project->save();

        $project->technologies()->sync($data['technologies']);

        return redirect()->route('admin.projects.show', $project)->with('message-status', 'alert-success')->with('message-text', 'Project modified successfully');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     */
    public function destroy(Project $project)
    {
        $project->technologies()->detach();

        $project->delete();

        return redirect()->route('admin.projects.index')->with('message-status', 'alert-danger')->with('message-text', 'Project delete successfully');
    }

    public function destroyImage(Project $project)
    {
        Storage::delete($project->image);

        $project->image = null;

        $project->save();

        return redirect()->back();
    }
}
