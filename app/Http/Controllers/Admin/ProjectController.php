<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Type;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\isNull;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        $types = Type::all();
        $projects = Project::orderByDesc('id')->paginate(15);

        return view('admin.project.index', compact('types', 'projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Type::all();
        return view('admin.project.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request, Project $project)
    {
        $validated = $request->validated();
        $data = $request->all();

        if ($request->has('cover_image')) {
            $img_path = Storage::put('cover_images', $request->cover_image);
            $data['cover_image'] = $img_path;
        }

        //$data['slug'] = Str::slug($request->title);

        $data['slug'] = $project->createSlug($request->title);

        //dd($data['slug']);
        $new_project = Project::create($data);

        return to_route('admin.project.index')->with('message', 'Created sucessfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $types = Type::all();

        return view('admin.project.show', compact('project', 'types'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        return view('admin.project.edit', compact('project', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $validated = $request->validated();
        $data = $request->all();
        if ($request->has('cover_image')) {
            $img_path = Storage::put('cover_images', $request->cover_image);

            if (!is_null($project->cover_image) && Storage::fileExists($project->cover_image)) {
                //dd($project->cover_image);
                Storage::delete($project->cover_image);
            }

            $data['cover_image'] = $img_path;
        }

        if (!Str::is($project->getOriginal('title'), $request->title)) {
            $data['slug'] = $project->createSlug($request->title);
        }
        //dd($data);
        $project->update($data);
        return to_route('admin.project.index')->with('message', 'Updated sucessfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {

        if (isNull($project->cover_image)) {
            Storage::delete($project->cover_image);
        }

        //dd($project);
        $project->delete();

        return to_route('admin.project.index')->with('message', 'Delete sucessfully');
    }
}
