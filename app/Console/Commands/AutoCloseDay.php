<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\OpenCloseDay;

class AutoCloseDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto-close-day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto Closing a Day by running this command';

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
     * @return int
     */
    public function handle()
    {
        info("Auto Close Command Running at daily 12pm");
        $open_close_day = OpenCloseDay::latest()->first();
        if($open_close_day != null && $open_close_day->closed == 0){
            $open_close_day->auto_closed = '1';
            $open_close_day->save();
            info("Auto closed at daily 12pm");
        }
        return 0;
    }
}
