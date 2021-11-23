<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $table = 'sites_tbl';

    protected $fillable = ['name','uid','ip_address','created_at','updated_at','status'];

    public function getData()
    {
        return static::where('status',1)->get();
    }
}
