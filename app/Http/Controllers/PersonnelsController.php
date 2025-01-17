<?php

namespace App\Http\Controllers;

use App\Models\Personnel;
use App\Models\Poste;
use App\Models\Information;
use Illuminate\Http\Request;

class PersonnelsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $personnels = Personnel::orderBy('id')->paginate(4);

        return view('personnels.index', compact('personnels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $postes = Poste::all();

        return view('personnels.create', compact('postes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'nom' =>  'required',
            'poste' =>  'required'
             //['required', 'email']
        ]);

        $nom =  $request->nom;
        $poste =  $request->poste;


        Personnel::create([
            'nom' => $nom,
            'poste_id' => $poste,
        ]);

        session()->flash('success');

        return redirect()->route('personnels.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $personnel = Personnel::find($id);
        $info = Information::where('user_id', $id);

        return view('personnels.show', compact('personnel', 'info'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $personnel = Personnel::find($id);
        $postes = Poste::all();

        return view('personnels.edit', compact('personnel', 'postes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $personnel = Personnel::find($id);

        $nom =  $request->nom;
        $poste =  $request->poste;

        $personnel->update(['nom' => $nom, 'poste_id' => $poste]);

        return redirect()->route('personnels.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Personnel::find($id)->delete();
        return redirect()->route('personnels.index');
    }
}
