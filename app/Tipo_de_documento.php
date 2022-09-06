<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_de_documento extends Model
{
	protected $guarded = ['id'];    

    protected $primaryKey = 'id_tipo_de_documento';

    protected $connection = 'sistema';
    protected $table = 'tb_tipo_de_documento';

}
