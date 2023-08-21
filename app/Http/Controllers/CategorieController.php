<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CategorieRequest;

class CategorieController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Categorie::where('user_id', Auth::id())->orderByDesc('id')->get();
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
    public function store(CategorieRequest $request)
    {
        $categorie = Categorie::create($request->all());
        return $categorie
            ? response()->json($categorie, 201)
            : response()->json([], 500);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategorieRequest $request, $id)
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
