<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Project;
use App\Models\Client;
use App\Models\Designer;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with(['client', 'designer'])->get();
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $clients = Client::all();
        $designers = Designer::all();
        $materials = Material::all();
        return view('admin.projects.create', compact('clients', 'designers', 'materials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cost' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'client_id' => 'required|exists:users,id',
            'designer_id' => 'required|exists:users,id',
            'materials.*.quantity' => 'required|integer|min:1',
            'materials.*.id' => 'required|exists:materials,id',
        ]);
        foreach ($request->input('materials') as $material) {
            $materialModel = Material::find($material['id']);
            if ($materialModel->stock_availability < $material['quantity']) {
                return redirect()->back()->withErrors(['materials' => 'Кількість матеріалу ' . $materialModel->name . ' перевищує доступну.']);
            }
        }
        $project = Project::create($request->all());

        foreach ($request->input('materials') as $material) {
            $project->materials()->attach($material['id'], ['quantity' => $material['quantity']]);
        }

        return redirect()->route('admin.projects.index')->with('success', 'Проект успішно створено!');
    }


    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $clients = Client::all();
        $designers = Designer::all();
        $materials = Material::all();
        return view('admin.projects.edit', compact('project', 'clients', 'designers','materials'));
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cost' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'client_id' => 'required|integer|exists:users,id',
            'designer_id' => 'required|integer|exists:users,id',
            'materials' => 'required|array',
            'materials.*.id' => 'required|integer|exists:materials,id',
            'materials.*.quantity' => 'required|integer|min:1',
        ]);

        foreach ($validatedData['materials'] as $materialData) {
            $material = Material::findOrFail($materialData['id']);
            $quantity = $materialData['quantity'];
            if ($quantity > $material->stock_availability) {
                return back()->withErrors("Недостатньо матеріалу: {$material->name} на складі. Доступно: {$material->stock_availability}.");
            }
        }

        $project->update($validatedData);

        $project->materials()->detach();
        foreach ($validatedData['materials'] as $materialData) {
            $project->materials()->attach($materialData['id'], ['quantity' => $materialData['quantity']]);
        }

        return redirect()->route('admin.projects.index')->with('success', 'Проект оновлено успішно.');
    }


    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Проєкт успішно видалений');
    }
}
