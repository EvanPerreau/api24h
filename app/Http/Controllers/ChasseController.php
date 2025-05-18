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

    public function destroy(Chasse $chasse)
    {
        if ($chasse->user_id !== auth()->user()->id) {
            Log::error('Unauthorized chasse deletion attempt', [
                'user_id' => auth()->user()->id,
                'chasse_id' => $chasse->id,
            ]);
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $chasse->delete();
        return response()->json(null);
    }
}
