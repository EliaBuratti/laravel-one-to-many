<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTypeRequest;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = Type::orderByDesc('id')->paginate(15);
        return view('admin.type.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.type.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTypeRequest $request, Type $type)
    {
        $validated = $request->validated();
        $data = $request->all();

        $data['slug'] = $type->createSlug($request->name);

        //dd($data);
        $new_type = Type::create($data);
        return to_route('admin.type.index')->with('message', 'Created sucessfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Type $types)
    {
        return view('admin.type.show', compact('types'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Type $types)
    {
        return view('admin.type.edit', compact('types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Type $type)
    {
        $validated = $request->validated();
        $data['slug'] = $type->createSlug($request->name);

        $type->update($data);
        return to_route('admin.type.index')->with('message', 'Type updated sucessfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Type $type)
    {
        $type->delete();
        return to_route('admin.type.index')->with('message', 'Delete sucessfully');
    }
}
