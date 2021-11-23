<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SerialNumber;

class SerialNumbersLogs extends Model
{
    use HasFactory;

    //protected $touches = ['serialNumber']; -> this is function name // automatically "touch" the updated_at timestamp

    public $timestamps = false;
    
    protected $table = "serial_numbers_logs_tbl";

    protected $fillable = ['serial_number_id','site_id','validated_on','created_on'];

    public function serialNumber()
    {
        return $this->belongsToMany(SerialNumber::class);
    }
}
