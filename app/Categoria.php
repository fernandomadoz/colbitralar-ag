<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
	protected $guarded = ['id'];    

    protected $primaryKey = 'id_categoria';

    protected $connection = 'sistema';
    protected $table = 'tb_categoria';

}
