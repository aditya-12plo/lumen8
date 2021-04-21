<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IndexController extends Controller
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

    public function index(Request $request){
        $datas                  = $request->all();

        return response()
        ->json(['status'=>200 ,'datas' => $datas, 'errors' => []])
        ->withHeaders([
          'Content-Type'          => 'application/json',
          ])
        ->setStatusCode(200);
    }
}
