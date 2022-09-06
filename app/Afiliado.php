<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Afiliado extends Model
{
	protected $guarded = ['id'];    

    protected $primaryKey = 'id_afiliado';

    protected $connection = 'sistema';
    protected $table = 'tb_afiliado';

}
