<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
    use HasFactory;

    protected $table = "files";

    protected $fillable = ['name','site_id','status','date_time']; 

    public function getData()
    {
        return static::orderBy('id','desc')->where('status',1)->get();
    }
}
