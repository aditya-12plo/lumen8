<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function profile(Request $request){
        $auth					= $request->auth;
        return response()
        ->json(['status'=>200 ,'datas' => $auth, 'errors' => []])
        ->withHeaders([
          'Content-Type'          => 'application/json',
          ])
        ->setStatusCode(200);
    }
}
