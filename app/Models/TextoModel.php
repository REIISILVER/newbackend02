<?php

namespace App\Models;

use CodeIgniter\Model;

class TextoModel extends Model
{
    protected $table = 'txt';
    protected $primaryKey = 'id_txt';
    protected $allowedFields = ['font', 'sangria', 'font_size', 'posx', 'posy', 'height', 'width', 'border_color', 'backgroundcolor', 'border_style', 'border_radius', 'color', 'fontweight', 'id_mural', 'valor'];

    protected $returnType = 'array';
    protected $useTimestamps = false;

    // Agregar la relación con la tabla mural
    protected $with = ['mural'];

    // Relación con la tabla mural
    public function mural()
    {
        return $this->belongsTo(Mural_Model::class, 'id_mural', 'id_mural');
    }

    public function insertBatch(?array $data = null, ?bool $escape = null, int $batchSize = 100, bool $testing = false)
    {
        return parent::insertBatch($data, $escape, $batchSize, $testing);
    }
}