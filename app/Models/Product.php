<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'productos';

    protected $fillable = ['nombre', 'precio', 'imagen'];

    public $timestamps = false;
}
