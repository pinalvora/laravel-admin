<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SerialNumbersLogs;

class SerialNumber extends Model
{
    use HasFactory;

    protected $table = "serial_numbers_tbl";

    //protected $fillable = ['serial_number','is_validated','validate_count','validated_on','created_on','site_id','status'];

    protected $guarded = [];

    public $timestamps = false;

    public function getData()
    {
        //return static::offset(0)->limit(1000)->get();
        //return static::all();
    }

    public function serialNumberLogs()
    {
        return $this->hasMany(SerialNumbersLogs::class);
    }
}
