<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Categorie::get()->all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $categorie = Categorie::create($request->all());
        return $categorie
            ? response()->json($categorie, 201)
            : response()->json([], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(Categorie $categorie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categorie $categorie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $categorie = Categorie::findorFail($id);
        $categorie->fill($request->all())->save();
        return $categorie
            ? response()->json($categorie, 201)
            : response()->json([], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    { {
            $categorie = Categorie::findorFail($id);
            $categorie->delete();
            return $categorie
                ? response()->json($categorie, 201)
                : response()->json([], 500);
        }
    }
}
