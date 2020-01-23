<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','user']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        //return $request;
        $credentials = request(['email', 'password']);
        //$credentials = [$request->email, $request->password];

        //return $credentials;


        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => true,
            'message' => 'El usuario no cuenta con permisos para acceder a la aplicación'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $user_id = auth()->user()->id;
        //se trae el usuario logueado con los roles y permiso que tenga el usuario
        $user        = User::with('roles','permissions')->find($user_id);

        $i = 0;

        $arrayPermisosRol = array();
        $arrayPermisos = array();

        foreach ( $user->roles as $rol=>$roles){
            //se traen los permisos que tenga el rol del usuario
            $permisosRol       = Role::with('permissions')->find($roles->id);

            $j = 0;

            $arrayPermisosRol[$i] =$permisosRol;

            foreach ($arrayPermisosRol as $permiso=>$permisos){
                //se envian solo los permisos de los roles
                $arrayPermisos[$j] = $permisos->permissions;

                $j++;

            }

            $i++;
        }




        return response()->json([
            'error' => false,
            'message' => 'Usuario logueado correctamente',
            'access_token' => $token,
            'token_type' => 'bearer',
            'rolesPermisos' => $arrayPermisos,
            'user' => $user,

            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
