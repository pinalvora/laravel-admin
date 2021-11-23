<?php

namespace App\Imports;

use App\Models\SerialNumber;
use Maatwebsite\Excel\Concerns\ToModel;
use Session;

class SerialNumberImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
     public function model(array $row)
    {   

        $site_val = Session()->get('siteval');
        $data = new SerialNumber([
            'serial_number' => $row[0],
            'site_id' => $site_val,
            'is_validated' => 0,
            'validate_count' => 0,
            'validated_on' => 0,
            'created_on' => date('Y-m-d H:i:s'),
            'status' => 1
        ]);
        $data->save();
    }
}
