<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\user_model;

class UserController extends Controller
{


    public function insertUser()
    {
        // Obtener los datos del usuario desde la solicitud POST co un JSON
        $userData = $this->request->getJSON();

        // Validar los datos del usuario, por ejemplo, asegurarse de que los campos requeridos estén presentes.

        // Insertar el nuevo usuario en la base de datos
        $UserModel = new user_model();

        $insertedUserId = $UserModel->insertUser($userData);

        // Verificar si la inserción fue exitosa
        if ($insertedUserId) {
            $resp = [
                'mensaje'=>'Usuario creado con éxito'
            ];
            return $this->response->setJSON($resp);
        } else {
            $resp = [
                'mensaje'=>'error al insertar usuario'
            ];


            return $this->response->setJSON($resp);
        }
    }

    public function getUserRoles()
    {

        $userModel = new user_model();
        $usuarios = $userModel->getUsers();

        // Haz algo con $usuarios, como pasarlos a la vista o realizar otras operaciones.
        $resp = [];
        foreach ($usuarios as $usuario) {
            $resp[] = [ // Agrega un nuevo arreglo asociativo para cada usuario.
                'id_user' => $usuario->id_user,
                'nombre' => $usuario->nombre,
                'apellidos' => $usuario->apellidos,
                'correo' => $usuario->correo,
                'id_rol' => $usuario->idRol,
                'rol' => $usuario->rol
            ];
        }
        return $this->response->setJSON($resp);
    }

    public function getUserbyId(){
        $request =  $this->request->getJSON();
        if(!$request){
            $resp=["error"=>"no se recibio ni un dato"];
            return $this->response->setJSON($resp);
        }

        $userModel = new user_model();
        $usuario = $userModel->getUserbyID($request->id_user);

        if ($usuario) {
            $resp = [
                'id_user' => $usuario->id_user,
                'nombre' => $usuario->nombre,
                'apellidos' => $usuario->apellidos,
                'correo' => $usuario->correo,
                'id_rol' => $usuario->idRol,
                'rol' => $usuario->rol
            ];
            return $this->response->setJSON($resp);
        } else {
            // Usuario no encontrado, se devuelve un mensaje de error.
            return $this->response->setJSON(['error' => 'Usuario no encontrado']);
        }

    }

}