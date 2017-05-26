<?php

namespace App\Listeners;

use App\Events\ActivityLogEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\ActivityLogsModel;

class ActivityLogListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ActivityLogsModel $activity_logs)
    {
        $this->ActivityLogsModel  = $activity_logs; 
    }

    /**
     * Handle the event.
     *
     * @param  ActivityLogEvent  $event
     * @return void
     */


    public function handle(ActivityLogEvent $event)
    {
        $arr_activity_data['module_title']  = $event->module_title;
        $arr_activity_data['module_action'] = $event->module_action;
        $arr_activity_data['user_id']       = $event->user_id;
        
        $this->ActivityLogsModel->create($arr_activity_data);
    }
}
