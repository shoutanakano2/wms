<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Historie;

class histories_status_change extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'status_change';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '入出庫確定処理';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $histories=\App\Historie::where('change_status','=','可')->get();
        foreach($histories as $history){
            $history->change_status='否';
            $history->save();
        }
    }
}
