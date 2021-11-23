<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SerialNumberValidate extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = "serial_numbers_count_tbl";

    protected $fillable = ['serial_number','serial_number_id','site_id','is_validated','validate_count','validate_on','created_on'];

    
}
