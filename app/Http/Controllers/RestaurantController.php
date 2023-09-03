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
    public function getAll()
    {
        $items = Restaurant::where('user_id', Auth::id())->get()->all();
        foreach ($items as $item) {
            $item->categories;
            }
        return $items
        ? response()->json($items, 201)
        : response()->json([], 500);

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $items =  Restaurant::where('user_id', Auth::id())->paginate(10);
        foreach ($items as $item) {
            $item->categories;
            }

        return $items
        ? response()->json($items, 201)
        : response()->json([], 500);


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RestaurantRequest $request)
    {
        $restaurant = new Restaurant();
        $file = $request->file('food_picture');
        if (isset($file)) {
            $file_name = $file->getClientOriginalName();
            $request->file('food_picture')->storeAs('public/', $file_name);
            $restaurant->food_picture = $file_name;
        }

        $restaurant->name = $request->name;
        $restaurant->name_katakana = $request->name_katakana;
        $restaurant->comment = $request->comment;
        $restaurant->map_url = $request->map_url;
        $restaurant->review = $request->review;
        $restaurant->tel = $request->tel;
        $restaurant->user_id = $request->user_id;
        $restaurant->save();
        $restaurant->categories()->sync($request->get('categorieId', []));
dump($request->all());
        return $restaurant
            ? response()->json($restaurant, 201)
            : response()->json([], 500);
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
        $restaurant->categories()->sync($request->get('categorieId', []));

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
