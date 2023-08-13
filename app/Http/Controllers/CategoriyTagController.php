<?php

namespace App\Http\Controllers;

use App\Models\CategoriyTag;
use Illuminate\Http\Request;

class CategoriyTagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $categoriyTag = CategoriyTag::create($request->all());
        return $categoriyTag
            ? response()->json($categoriyTag, 201)
            : response()->json([], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(CategoriyTag $categoriyTag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoriyTag $categoriyTag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CategoriyTag $categoriyTag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoriyTag $categoriyTag)
    {
        //
    }
}
