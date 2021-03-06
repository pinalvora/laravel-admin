<?php 
namespace App\Http\Controllers;

use App\Models\Sale;
use App\Jobs\SaleCsvProcess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;

class SaleController extends Controller
{
    public function index()
    {
        return view('demo');
    }

    public function upload_csv_records(Request $request)
    {
        if($request->has('csv') ) {
            $csv    = file($request->csv);
            $chunks = array_chunk($csv,1000);
            $header = [];
            $batch  = Bus::batch([])->dispatch();
           // dd($batch);

            foreach ($chunks as $key => $chunk) {
            $data = array_map('str_getcsv', $chunk);
                if($key == 0){
                    $header = $data[0];
                    unset($data[0]);
                }
                $batch->add(new SaleCsvProcess($data, $header));
            }
            return $batch;
        }
        return "please upload csv file & Total Data".$csv;
    }
}