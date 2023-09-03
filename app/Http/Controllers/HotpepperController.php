<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class HotpepperController extends Controller
{
    private const REQUEST_URL = 'http://webservice.recruit.co.jp/hotpepper/gourmet/v1/';


    public function index()
    {
        $client = new Client();

        $method = 'GET';

        // APIキーを取得
        $api_key = config('hotpepper.api_key');

        // APIキーや検索ワードなどの設定を記述
        $options = [
            'query' => [
                'key' => $api_key,
                'large_area' => 'Z022', //京都
                'count' => 30,
                'format' => 'json',
            ],
        ];

        // HTTPリクエストを送信
        $response = $client->request($method, self::REQUEST_URL, $options);
        // 'format' => 'json'としたのでJSON形式でデータが返ってくるので、連想配列型のオブジェクトに変換
        $restaurants = json_decode($response->getBody(), true)['results'];
        $shop = $restaurants["shop"];
        $collect_shops = collect($shop);
        $paginate = $collect_shops->paginate(10);

        return $paginate
        ? response()->json($paginate, 201)
        : response()->json([], 500);

    }
}
