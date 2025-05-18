<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreChasseRequest;
use App\Chasse;

class ChasseController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        return response()->json($user->chasses);
    }

    public function store(StoreChasseRequest $request)
    {
        $chasse = Chasse::create([
            'nom' => $request->nom,
            'lieu' => $request->lieu,
            'date' => $request->date,
            'user_id' => $request->user()->id,
        ]);
        $chasse->save();
        return response()->json($chasse);
    }

    public function destroy(int $id)
    {
        $chasse = Chasse::find($id);
        if ($chasse === null) {
            return response()->json(['error' => 'Chasse not found'], 404);
        }
        $chasse->delete();
        return response()->json(null);
    }
}
