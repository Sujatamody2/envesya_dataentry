<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempResponsibleCorporate extends Model
{
     protected $fillable = ['user_id','form_data'];

    protected $casts = [
        'form_data' => 'array'
    ];
}
