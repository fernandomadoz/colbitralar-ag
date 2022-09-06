<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parametro extends Model
{
	protected $guarded = ['id'];    

    protected $primaryKey = 'id_parametro';

    protected $connection = 'sistema';
    protected $table = 'tb_parametro';

}
