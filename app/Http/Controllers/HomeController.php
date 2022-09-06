<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiTrait;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use ApiTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' =>  ['accessToken']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }


    public function accessToken($userId)
    {
        if (env('APP_ENV')  !== 'production') {
            $user = User::find($userId);

            $token = $user->createToken('API')->accessToken;

            return $this->response(['token' => $token, "user" => $user->only(["name", "avatar"])]);
        }
    }
}
