<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Project;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $payments = Payment::when($query, function ($q) use ($query) {
            return $q->where('status', 'like', "%{$query}%");
        })->get();

        return view('admin.payments.index', compact('payments', 'query'));
    }

    public function create()
    {
        $projects = Project::all();
        return view('admin.payments.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'status' => 'required',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date',
            'project_id' => 'required|integer',
        ]);

        Payment::create($validatedData);

        return redirect()->route('admin.payments.index')->with('success', 'Платіж успішно створено');
    }

    public function edit($id)
    {
        $payment = Payment::findOrFail($id);
        $projects = Project::all();
        return view('admin.payments.edit', compact('payment','projects'));
    }

    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        $validatedData = $request->validate([
            'status' => 'required',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date',
            'project_id' => 'required|integer',
        ]);

        $payment->update($validatedData);

        return redirect()->route('admin.payments.index')->with('success', 'Платіж успішно оновлено');
    }

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return redirect()->route('admin.payments.index')->with('success', 'Платіж успішно видалено');
    }

    public function filter(Request $request)
    {
        $query = $request->input('query');

        $payments = Payment::when($query, function ($q) use ($query) {
            return $q->where('status', 'like', "%{$query}%");
        })->get();

        return response()->json(['payments' => $payments]);
    }
}
