<?php

namespace App\Http\Controllers;

use App\Prime;
use App\Http\Requests\CreatePrimeRequest;

class PrimeController extends Controller
{
    public function index()
    {
        return response()->json(Prime::all());
    }

    public function add(CreatePrimeRequest $request)
    {
        $validated = $request->validated();
        $prime = Prime::create([
            'nom' => $validated['nom'],
            'prix' => $validated['prix'],
        ]);
        $prime->save();
        return response()->json($prime);
    }

    public function remove($id)
    {
        $prime = Prime::find($id);
        if ($prime === null) {
            return response()->json(['error' => 'Prime not found'], 404);
        }
        $prime->delete();
        return response()->json($prime);
    }
}
