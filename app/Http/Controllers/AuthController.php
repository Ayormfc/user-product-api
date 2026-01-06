<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use OpenApi\Annotations as OA;

class AuthController extends Controller
{
    public function __construct()
    {
        //api guard for middleware checks
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * @OA\Post(
     * path="/api/register",
     * tags={"Auth"},
     * summary="Register a new user",
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"name","email","password"},
     * @OA\Property(property="name", type="string", example="John Doe"),
     * @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     * @OA\Property(property="password", type="string", format="password", example="secret123")
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="User registered successfully"
     * )
     * )
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // CHANGE: Use 'api' guard to generate the token
        $token = auth('api')->login($user);
        
        return $this->respondWithToken($token);
    }

    /**
     * @OA\Post(
     * path="/api/login",
     * tags={"Auth"},
     * summary="Login User",
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"email","password"},
     * @OA\Property(property="email", type="string", example="john@example.com"),
     * @OA\Property(property="password", type="string", example="secret123")
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Login Successful"
     * ),
     * @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @OA\Post(
     * path="/api/logout",
     * tags={"Auth"},
     * summary="Logout User",
     * security={{"bearerAuth":{}}},
     * @OA\Response(response=200, description="Logged out successfully")
     * )
     */
    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * @OA\Post(
     * path="/api/refresh",
     * tags={"Auth"},
     * summary="Refresh Token",
     * security={{"bearerAuth":{}}},
     * @OA\Response(response=200, description="Token refreshed")
     * )
     */
    public function refresh()
    {
        
        return $this->respondWithToken(auth('api')->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}