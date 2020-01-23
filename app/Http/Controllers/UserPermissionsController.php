<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\User;
use Spatie\Permission\Models\Permission;


class UserPermissionsController extends Controller
{

    public function update(Request $request)
    {

        //validacion formulario
        $validator = Validator::make($request->all(), [

            'id_user' => 'required',
            'permisosActualizar' => 'required'
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
        $request->permisosActualizar = explode(",", $request->permisosActualizar);
        //le quita los permisos que tiene el usuario y le coloca los nuevos
        $user->syncPermissions($request->permisosActualizar);


        $response = array(
            'status' => 'success',
            'response_code' => 200
        );

        return $response;
    }

}
