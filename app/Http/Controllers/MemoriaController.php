<?php

namespace App\Http\Controllers;

use App\Models\memoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemoriaController extends Controller
{
    public function memoriastore(Request $request)
    {
        
        $request->validate([
            'paciente_id' => 'required',
            'foto' => 'required',
            'descripcion' => 'required|max:40'
        ]);
        $data = $request->except('foto');
        if($request->hasFile('foto')){
            $file=$request->file('foto');
            $routeName=$file->store('memorias', ['disk' => 'public']);
            $data['foto'] = $routeName;
        }
        $actividad =new memoria($data);
        $actividad->save();
        return back();
    }

    public function memoriadestroy(memoria $memoria)
    {
        if($memoria->foto){
            Storage::disk('public')->delete($memoria->foto);
        }
        $memoria->delete();
        return back();
    }
}
