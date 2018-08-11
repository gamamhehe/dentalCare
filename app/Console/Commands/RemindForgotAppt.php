<?php

namespace App\Console\Commands;

use App\Http\Controllers\BusinessFunction\AppointmentBussinessFunction;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class RemindForgotAppt extends Command
{
    use AppointmentBussinessFunction;
    use DispatchesJobs;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remind:forgotAppoinment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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

    }
}
