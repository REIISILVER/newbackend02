<?php
namespace App\Models;
use CodeIgniter\Model;
class user_model extends Model {

    protected $table = 'usuario'; // Nombre de la tabla de usuarios en la base de datos
    protected $primaryKey = 'id_user'; // Clave primaria de la tabla

    protected $allowedFields = ['email', 'contrasenia']; // Campos permitidos para la asignación masiva

    public function getUserByEmail($email)
    {
        //return $this->where('email', $email)->first();
        return $this->select('usuario.*, rol.perfil as perfil')
            ->join('rol', 'rol.id_rol = usuario.id_rol', 'inner')
            ->where('email', $email)
            ->first();

    }





}