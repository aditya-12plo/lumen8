<?php

namespace App\Http\Controllers\Auth;

use DB;

use App\Models\User;
use App\Models\UserRole;

use Firebase\JWT\JWT;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Laravel\Lumen\Routing\Controller as BaseController;

class LoginController extends BaseController {
    
    private function jwt(User $user) {
        
        $payload = [
            'iss' => "bearer",
            'sub' => $user,
            'iat' => time(),
            'exp' => time() + 1440*60 // token kadaluwarsa setelah 3600 detik
        ];
        
        return JWT::encode($payload, env('JWT_SECRET'));
    
    }
    
    public function authenticate(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'email'         => 'required',
            'password'      => 'required'
        ]);

        if ($validator->fails()) {
            return response()
            ->json(['status'=>422 ,'datas' => null, 'errors' => $validator->errors()])
            ->withHeaders([
                'Content-Type'          => 'application/json',
            ])
            ->setStatusCode(422);
        }
           
        $email 	    = $request->input('email');
    	$password 	= $request->input('password'); 
        
		
		$selectedUser = User::where('email', '=', $email)->first();
        
        if ($selectedUser && Hash::check($password, $selectedUser->password)) {
             if($selectedUser->status === "ACTIVATED"){
				$token = $this->jwt($selectedUser);
            
				$data = ['token' => $token, 'type' => 'bearer', 'exp' => time() + 1440*60];
				return response()
				->json(['status'=>200 ,'datas' => $data, 'errors' => []])
				->withHeaders([
				  'Content-Type'          => 'application/json',
				  ])
					->setStatusCode(200);
			 }else{
				return response()
				->json(['status'=>422 ,'datas' => [], 'errors' => ['message' => "user has been DEACTIVATED"]])
				->withHeaders([
				  'Content-Type'          => 'application/json',
				  ])
					->setStatusCode(422);  
			 }            
        } else {
            return response()
			->json(['status'=>422 ,'datas' => [], 'errors' => ['message' => "user not found "]])
			->withHeaders([
			  'Content-Type'          => 'application/json',
			  ])
				->setStatusCode(422);        
        }

    }

}