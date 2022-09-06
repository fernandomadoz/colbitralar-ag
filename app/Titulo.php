<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Titulo extends Model
{
	protected $guarded = ['id'];    

    protected $primaryKey = 'id_titulo';

    protected $connection = 'sistema';
    protected $table = 'tb_titulo';

}
