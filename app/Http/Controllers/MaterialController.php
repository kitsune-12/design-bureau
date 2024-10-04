<?php

namespace App\Http\Controllers;

use App\Models\material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $materials = Material::when($query, function ($q) use ($query) {
            return $q->where('name', 'like', "%{$query}%");
        })->get();

        return view('admin.materials.index', compact('materials', 'query'));
    }

    public function create()
    {
        return view('admin.materials.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:materials,name',
            'type' => 'required',
            'description' => 'nullable',
            'stock_availability'=>'required',
        ]);

        Material::create($validatedData);

        return redirect()->route('admin.materials.index')->with('success', 'Матеріал успішно створена');
    }

    public function edit($id)
    {
        $material = Material::findOrFail($id);
        return view('admin.materials.edit', compact('material'));
    }

    public function update(Request $request, $id)
    {
        $material = Material::findOrFail($id);

        $validatedData = $request->validate([
            'name' => [
                'required',
                'unique:materials,name,'. $material->id,
            ],
            'type' => 'required',
            'description' => 'nullable',
            'stock_availability'=>'required',
        ]);

        $material->update($validatedData);

        return redirect()->route('admin.materials.index')->with('success', 'Спеціалізація успішно оновлена');
    }

    public function destroy($id)
    {
        $material = Material::findOrFail($id);
        $material->delete();

        return redirect()->route('admin.materials.index')->with('success', 'Спеціалізація успішно видалена');
    }
    public function filter(Request $request)
    {
        $query = $request->input('query');

        $materials = Material::when($query, function ($q) use ($query) {
            return $q->where('name', 'like', "%{$query}%");
        })->get();

        return response()->json(['materials' => $materials]);
    }


}
