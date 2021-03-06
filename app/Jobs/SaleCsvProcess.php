<?php
namespace App\Jobs;

use App\Models\Sale;
use Illuminate\Bus\Queueable;
use Illuminate\Bus\Batchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Symfony\Component\Console\Output\ConsoleOutput;

class SaleCsvProcess implements ShouldQueue
{
    
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public $header;
    public $data;

    public function __construct($data, $header)
    {
        $this->data = $data;
        $d = [];
        foreach($data as $k => $v){
            $r = new Sale([
                'name' => $data[$k][0]
            ]);
            $r->save();
            //$d = $r;
        }
        /*$this->data = $data;
        $this->header = $header;*/
    }

    public function handle()
    {
        /*foreach ($this->data as $sale) {
            $sellData = array_combine($this->header,$sale);
            Sale::create($sellData);
        }*/
    }
}