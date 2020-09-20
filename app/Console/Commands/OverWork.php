<?php

namespace App\Console\Commands;

use App\Model\Work;
use App\Services\WorkService;
use Illuminate\Console\Command;

class OverWork extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:overWork';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'command:overWork';

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
        $this->overWork();
    }

    protected function overWork()
    {
        $workList = Work::where(['createDate' => date('Y-m-d', strtotime('-1 day'))])->where(['work_end' => 0])->get();
        /** @var Work $work */

        foreach ($workList as $work) {
            $workHour = WorkService::getWorkHour($work->work_start, strtotime(date('Y-m-d', strtotime("-1 day"))));
            $work->work_end = time();
            $work->work_time = $workHour >= WorkService::$workHour ? WorkService::$workHour : $workHour;
            $work->work_extra = $workHour >= WorkService::$workHour ? $workHour - WorkService::$workHour : 0;
            $work->save();
        }
    }

}
