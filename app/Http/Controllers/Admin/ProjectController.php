<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::where('user_id', Auth::id())->sortable()->Filter(request(['search', 'type']))->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
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
     * @param  \App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        $form_data = $request->all();
        if (array_key_exists('cover_image', $form_data)) {
            $form_data['original_cover_image'] = $request->file('cover_image')->getClientOriginalName();
            $form_data['cover_image'] = Storage::put('uploads', $form_data['cover_image']);
        }

        $form_data['slug'] = Project::generateSlug($form_data['name']);
        $form_data['user_id'] = Auth::id();
        $project = Project::create($form_data);

        if (array_key_exists('technologies', $form_data))
            $project->technologies()->attach($form_data['technologies']);

        return redirect()->route('admin.projects.index')->with('success', 'Project ' . '<strong>' . $project->name . '</strong>' . ' added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        if($project->user_id === Auth::id()){
            return view('admin.projects.show', compact('project'));
        }

        return redirect()->route('admin.projects.index')->with('denied', 'Accesso negato');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        if($project->user_id !== Auth::id()){
            return redirect()->route('admin.projects.index')->with('denied', 'Accesso negato');
        }
        $types = Type::all();
        $technologies = Technology::all();

        return view('admin.projects.edit', compact('project', 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, Project $project)
    {
        $form_data = $request->all();

        if (array_key_exists('cover_image', $form_data)) {

            if ($project->cover_image) {
                Storage::disk('public')->delete($project->cover_image);
            }

            $form_data['original_cover_image'] = $request->file('cover_image')->getClientOriginalName();
            $form_data['cover_image'] = Storage::put('uploads', $form_data['cover_image']);
        }

        if ($form_data['name'] != $project->title)
            $form_data['slug'] = Project::generateSlug($form_data['name']);
        $project->update($form_data);

        if (array_key_exists('technologies', $form_data))
            $project->technologies()->sync($form_data['technologies']);
        else
            $project->technologies()->detach();

        return redirect()->route('admin.projects.index')->with('success', 'Project ' . '<strong>' . $project->name . '</strong>' . ' updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        if ($project->cover_image) {
            Storage::disk('public')->delete($project->cover_image);
        }

        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Project ' . '<strong>' . $project->name . '</strong>' . ' deleted successfully');
    }
}
