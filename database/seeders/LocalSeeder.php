<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class LocalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private $amount = 100000; 


    public function run()
    {

        /*$this->command->getOutput()->progressStart(10000);
        for ($i = 0; $i < 10000; $i++) {
            sleep(1);
            $this->command->getOutput()->progressAdvance();
        }
        $this->command->getOutput()->progressFinish();*/
        /*$output = new ConsoleOutput();

        $progressBar = new ProgressBar($output, $this->amount);*/

        $this->command->getOutput()->progressStart(1000);

        User::factory()->count(1000)->create()->each(function($user) {
            if ($user->save()) {
                sleep(1);
                $this->command->getOutput()->progressAdvance();
            }
        });
        $this->command->getOutput()->progressFinish();
        /*factory(User::class, 100000)->create()->each(function ($user) use ($progressBar) {
            $user->save();
            $progressBar->advance();

        });*/

        //$progressBar->finish();
        
    }
}
