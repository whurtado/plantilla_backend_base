<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\User;
use Spatie\Permission\Models\Role;


class UserRolesController extends Controller
{
    public function index()
    {
    }

    public function store()
    {
    }

    public function edit()
    {
    }

    public function update(Request $request)
    {

        //validacion formulario
        $validator = Validator::make($request->all(), [

            'id_user' => 'required',
            'rolesActualizar' => 'required',

        ]);


        if ($validator->fails()) {

            if($request->ajax())
            {
                return response()->json(array(
                    'success' => false,
                    'message' => 'There are incorect values in the form!',
                    'errors' => $validator->getMessageBag()->toArray()
                ), 422);
            }

            $this->throwValidationException(
                $request, $validator
            );
        }

        $user =  User::find($request->id_user);
        //se convierte la cadena a un array para que no gerere evento
        $request->rolesActualizar = explode(",", $request->rolesActualizar);

        $user->syncRoles($request->rolesActualizar);


        $response = array(
            'status' => 'success',
            'response_code' => 200
        );

        return $response;
    }

}
