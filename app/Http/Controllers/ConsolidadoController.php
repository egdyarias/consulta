<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ConsolidadoController extends Controller
{
    /**
     * Verify the provided password against the authenticated user.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $user = Auth::user();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return response()->json(['password' => 'Contraseña incorrecta.'], 422);
        }

        return response()->json([], 200);
    }
}
