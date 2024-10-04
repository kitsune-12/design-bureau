<?php

namespace App\Http\Controllers;

use App\Models\Specialization;
use Illuminate\Http\Request;

class SpecializationController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $specializations = Specialization::when($query, function ($q) use ($query) {
            return $q->where('name', 'like', "%{$query}%");
        })->get();

        return view('admin.specializations.index', compact('specializations', 'query'));
    }

    public function create()
    {
        return view('admin.specializations.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:specializations,name',
        ]);

        Specialization::create($validatedData);

        return redirect()->route('admin.specializations.index')->with('success', 'Спеціалізацію успішно створена');
    }

    public function edit($id)
    {
        $specialization = Specialization::findOrFail($id);
        return view('admin.specializations.edit', compact('specialization'));
    }

    public function update(Request $request, $id)
    {
        $specialization = Specialization::findOrFail($id);

        $validatedData = $request->validate([
            'name' => [
                'required',
                'unique:specializations,name,'. $specialization->id,
            ],
        ]);

        $specialization->update($validatedData);

        return redirect()->route('admin.specializations.index')->with('success', 'Спеціалізація успішно оновлена');
    }

    public function destroy($id)
    {
        $specialization = Specialization::findOrFail($id);
        $specialization->delete();

        return redirect()->route('admin.specializations.index')->with('success', 'Спеціалізація успішно видалена');
    }
    public function filter(Request $request)
    {
        $query = $request->input('query');

        $specializations = Specialization::when($query, function ($q) use ($query) {
            return $q->where('name', 'like', "%{$query}%");
        })->get();

        return response()->json(['specializations' => $specializations]);
    }


}
