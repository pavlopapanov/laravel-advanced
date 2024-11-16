<?php

namespace App\Http\Controllers\Admin;

// TODO: Permission for Attributes
use App\Enums\Permission\CategoryEnum as Permission;
use App\Http\Controllers\Controller;
use App\Http\Requests\Attributes\CreateRequest;
use App\Http\Requests\Attributes\EditRequest;
use App\Models\Attributes\Attribute;
use Illuminate\Support\Str;

class AttributesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attributes = Attribute::with(['options'])->paginate(15);

        return view('admin.attributes.index', compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.attributes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request): \Illuminate\Http\RedirectResponse
    {
        $name = $request->get('name');
        $slug = Str::slug($name);

        $attribute = Attribute::create(compact('name', 'slug'));

        $attribute->options()->createMany($request->get('options'));


        return redirect()->route('admin.attributes.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attribute $attribute)
    {
        return view('admin.attributes.edit', [
            'attribute' => $attribute,
            // TODO: make options list
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditRequest $request, Attribute $attribute)
    {
        $data = array_merge(
            $request->validated(),
            ['slug' => Str::slug($request->get('name'))]
        );

        $attribute->updateOrFail($data);

        notify()->success('Attribute updated successfully');

        return redirect()->route('admin.attributes.edit', $attribute);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attribute $attribute)
    {
        $this->middleware('permission:' . Permission::DELETE->value);

        $attribute->deleteOrFail();

        return redirect()->route('admin.attributes.index');
    }
}
