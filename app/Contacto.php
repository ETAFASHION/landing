<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Contacto extends Model
{
    protected $collection = 'contactos';

    protected $dates = ['created_at','updated_at'];
    //Atributos que no son masivamente asiganbles
    protected $guarded = [];
    //Atributos que son asignables masivamente
    protected $fillable = ['nombres','apellidos','email','movil','fecha_nacimiento','ciudad'];
    //Atributos que se ocultan al convertir en Array o Json
    protected $hidden = [];
}
