<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RestaurantRequest;

class RestaurantController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return Restaurant::get()->all();
        return Restaurant::where('user_id', Auth::id())->orderByDesc('id')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RestaurantRequest $request)
    {
        $file_name = $request->file('food_picture')->getClientOriginalName();
        $request->file('food_picture')->storeAs('public/', $file_name);
        $json_data = json_encode($request->categorie, JSON_PRETTY_PRINT);
        $restaurant = new Restaurant();

        $restaurant->name = $request->name;
        $restaurant->name_katakana = $request->name_katakana;
        $restaurant->comment = $request->comment;
        $restaurant->map_url = $request->map_url;
        $restaurant->review = $request->review;
        $restaurant->tel = $request->tel;
        $restaurant->user_id = $request->user_id;
        $restaurant->food_picture = $file_name;
        $restaurant->categorie = $json_data;
        $all= $restaurant->all();
        // dd($all);
        $restaurant->save();

        return $restaurant
            ? response()->json($restaurant, 201)
            : response()->json([], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updated(Request $request,  $id)
    {
        $restaurant = Restaurant::findorFail($id);
        $file = $request->file('food_picture');
        if (isset($file)) {
            $path = $restaurant->food_picture;
            Storage::disk('local')->delete('public/' . $path);  //大事
            $file_name = $request->file('food_picture')->getClientOriginalName();
            $restaurant->food_picture = $file_name;
            $request->file('food_picture')->storeAs('public/', $file_name);
        }
        $restaurant->name = $request->name;
        $restaurant->name_katakana = $request->name_katakana;
        $restaurant->comment = $request->comment;
        $restaurant->map_url = $request->map_url;
        $restaurant->review = $request->review;
        $restaurant->tel = $request->tel;
        $restaurant->user_id = $request->user_id;
        $json_data = json_encode($request->categorie, JSON_PRETTY_PRINT);
        $restaurant->categorie = $json_data;

        $restaurant->save();
        return $restaurant
            ? response()->json($restaurant, 201)
            : response()->json([], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $restaurant = Restaurant::findorFail($id);
        $restaurant->delete();
        return $restaurant
            ? response()->json($restaurant, 201)
            : response()->json([], 500);
    }
}
