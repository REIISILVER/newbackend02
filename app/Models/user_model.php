<?php
namespace App\Models;
use CodeIgniter\Model;
class user_model extends Model {

    protected $table = 'usuario'; // Nombre de la tabla de usuarios en la base de datos
    protected $primaryKey = 'id_user'; // Clave primaria de la tabla

    protected $allowedFields = ['email', 'password']; // Campos permitidos para la asignación masiva

    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }





}