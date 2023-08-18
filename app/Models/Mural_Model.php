<?php

namespace App\Models;

use CodeIgniter\Model;

class Mural_Model extends Model
{
    protected $table = 'mural'; // Nombre de la tabla
    protected $primaryKey = 'id_mural'; // Nombre de la clave primaria
    protected $allowedFields = ['id_mural', 'id_user', 'height', 'width', 'estado','nombrem']; // Campos permitidos para inserción masiva

    protected $returnType = 'array'; // Tipo de datos de retorno, en este caso un arreglo
    protected $useTimestamps = false; // No usar timestamps (created_at, updated_at)
    protected $useAutoIncrement = false;

    // Agregar la relación con la tabla users
    protected $with = ['usuario'];

    // Relación con la tabla users
    /*public function user()
    {
        return $this->belongsTo(user_model::class, 'id_user', 'id_user');
    }*/

    // Método  para insertar el mural
    public function insertMural(array $data)
    {
        // Generar la consulta SQL para insertar el mural
        $builder = $this->db->table($this->table);
        $builder->insert($data);
    }

    public function getIdMural()
    {
        return $this->select('id_mural')
            ->findAll(); // Obtener todos los id_mural de la tabla
    }
    //devuelve las solicitudes
    public function getSolicitudData()
    {
        $builder = $this->db->table('mural mur');
        $builder->select('mur.id_mural, us.id_user, mur.estado, CONCAT(us.nombre,us.apellido_p) as Diseñador, sol.fecha_solicitud');
        $builder->join('usuario us', 'us.id_user = mur.id_user', 'inner');
        $builder->join('solicitar sol', 'sol.id_mural = mur.id_mural', 'inner');

        $query = $builder->get();

        return $query->getResultArray();
    }

    //obtener los murales por ID
    public function getMuralbyId($idMural){
        $query = $this->db->query("
            SELECT
                mur.*,
                ARRAY_AGG(DISTINCT txt.*) AS txts,
                ARRAY_AGG(DISTINCT vid.*) AS videos,
                ARRAY_AGG(DISTINCT img.*) AS imagenes,
                ARRAY_AGG(DISTINCT pdfs.*) AS pdfs
            FROM
                mural AS mur
            LEFT JOIN
                txt ON mur.id_mural = txt.id_mural
            LEFT JOIN
                videos AS vid ON mur.id_mural = vid.id_mural
            LEFT JOIN
                imagenes AS img ON mur.id_mural = img.id_mural
            LEFT JOIN
                pdfs ON mur.id_mural = pdfs.id_mural
            WHERE
                mur.id_mural = ?
            GROUP BY
                mur.id_mural
        ", [$idMural]);

        return $query->getResultArray();
    }
    //obtener el id del usuario para mostrar los murales de ese usuario
    public function getMuralByUser($idUsuario)
    {
        $query = $this->db->query("
            SELECT
                mur.*,
                ARRAY_AGG(DISTINCT txt.valor) AS txts,
                ARRAY_AGG(DISTINCT vid.url_video) AS videos,
                ARRAY_AGG(DISTINCT img.url) AS imagenes,
                ARRAY_AGG(DISTINCT pdfs.url_pdfs) AS pdfs
            FROM
                $this->table AS mur
            LEFT JOIN
                txt ON mur.id_mural = txt.id_mural
            LEFT JOIN
                videos AS vid ON mur.id_mural = vid.id_mural
            LEFT JOIN
                imagenes AS img ON mur.id_mural = img.id_mural
            LEFT JOIN
                pdfs ON mur.id_mural = pdfs.id_mural
            WHERE
                mur.id_user = ?
            GROUP BY
                mur.id_mural
        ", [$idUsuario]);

        return $query->getResultArray();
    }



}