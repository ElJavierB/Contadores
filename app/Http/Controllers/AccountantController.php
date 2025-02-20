<?php

namespace App\Http\Controllers;

use App\Models\Accountant;
use Illuminate\Http\Request;

class AccountantController extends Controller
{
    public function index()
    {
        return view('accountants.accountants');
    }

    public function store(Request $request)
    {
        $accountant = Accountant::create($request->all());
        return response()->json($accountant, 201);
    }

    public function show($id)
    {
        $accountant = Accountant::findOrFail($id);
        return response()->json($accountant);
    }

    public function update(Request $request, $id)
    {
        $accountant = Accountant::findOrFail($id);
        $accountant->update($request->all());
        return response()->json($accountant);
    }

    public function destroy($id)
    {
        Accountant::destroy($id);
        return response()->json(null, 204);
    }
}
