<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipments'; // Specify the table name if it's not the plural form

    protected $fillable = [
        'equipment_number', 'name', 'description'
    ];
}
