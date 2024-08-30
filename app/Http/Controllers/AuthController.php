<?php

namespace App\Http\Controllers;

use DB;
use DateTime;
use DateInterval;
use DatePeriod;
use Validator, Hash;
use JWTAuth;
use Redirect;
use Auth;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Password;
use App\Http\Requests;
use Tymon\JWTAuth\Exceptions\JWTException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Support\Facades\Log;


use App\Entities\User;
use App\Entities\Role;

/**
 * Class AuthController.
 *
 * @package namespace App\Http\Controllers;
 */
class AuthController extends Controller
{

    public function register(Request $request)
    {
        DB::beginTransaction();
        try {
            $check = User::where('username', $request->username)
                            ->orWhere('email',$request->email)
                            ->first();
            if($check){
                return response()->json([
                    'status'=> false, 
                    'error'=> 'Username already used'
                ], 403);
            }
            
            $user = User::create([
                            'role_id'   => $request->role_id,
                            'username'  => $request->username,
                            'fullname'  => $request->fullname,
                            'email'     => $request->email,
                            'password'  => bcrypt($request->password),
                        ]);
                        
            DB::commit();
            return response()->json([
                'status'    => true, 
                'message'   => 'Thanks for signing up.',
                'data'      => $user
            ], 200);
        } catch (Exception $e) {
            // For rollback data if one data is error
            DB::rollBack();

            return response()->json([
                'status'=> false, 
                'error'=> 'Something wrong!'
            ], 500);
        } catch (\Illuminate\Database\QueryException $ex) {
            // For rollback data if one data is error
            DB::rollBack();

            return response()->json([
                'status'=> false, 
                'error'=> 'Something wrong!'
            ], 500);
        }
    }

    public function login(Request $request){
        $user = $request->session()->get('user');
        // return response()->json($user,200);
        if($user){
            return Redirect::to('landing');
        }else{
            return view('sessions.signIn');
        }
    }

    /**
     * API Login, on success return JWT Auth token
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function doLogin(Request $request)
    {
        $credentials = $request->only('username', 'password');
        
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];
        $validator = Validator::make($credentials, $rules);
        if($validator->fails()) {
            return Redirect::to('login')
                            ->with('error', $validator->messages())
                            ->withInput();
        }
        
        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return Redirect::to('login')
                            ->with('error', 'We cant find an account with this credentials.')
                            ->withInput();
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return Redirect::to('login')
                            ->with('error', 'Failed to login, please try again.')
                            ->withInput();
        }
        
        // all good so return the token
        $user = User::where('username', $credentials['username'])->with('user_group.group')->first();
        
        Log::info('Token generated for user: ' . $token);

        if($user){
            $role = Role::where('name','Admin')->first();
            $roleMerchant = Role::where('name','Merchant')->first();
            if($role){
                if($role->id == $user->role_id || $roleMerchant->id == $user->role_id) {
                    //skip
                } else {
                    return Redirect::to('login')
                                    ->with('error', 'Failed to login, please check your account.')
                                    ->withInput();
                }
                // if($role->id != $user->role_id){
                //     return Redirect::to('login')
                //                     ->with('error', 'Failed to login, please check your account.')
                //                     ->withInput();
                // }
            }

			$request->session()->put('user', $user);

            return Redirect::to('landing');
        }else{
            return Redirect::to('login')
                            ->withInput();
        }
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->forget('user');
        return Redirect::to('login');
    }
}
