<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
                'data'      => 'Welcome to laravel',
            ]);
    }
    /**
     * Store a newly created resource in storage.
     */

    //===============  Register =================
    public function store(Request $request)
    {
        $user = $request->validate([
        'name'     => 'required|string',
        'email'    => 'required|string',
        'password' => 'required|string|min:6'
    ]);
        User::create($user);
        return response()->json([
            'success'       => true,
            'message'       =>'Create successfully',
            'data'          =>$user,
        ]);
    }
    //============== Login ==================
    public function login(Request $request){
        $user_login  = Validator::make($request->all(),[
            'email'     =>'required|email',
            'password'  =>'required|string',
        ]);
        if($user_login->fails()){
            return response()->json([
                'success'   =>false,
                'errors'    =>$user_login->errors(),
            ], 422);
        }
        $user = User::where('email', $request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                'success'   => false,
                'message'   => 'Password or Email incorrect',
            ], 401);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'success'   => true,
            'message'   => 'Login Successfully',
            'user'      => $user,
            'token'     => $token,
        ], 200);
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
