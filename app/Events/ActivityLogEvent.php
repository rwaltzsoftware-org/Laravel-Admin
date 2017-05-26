<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Sentinel;

class ActivityLogEvent extends Event
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Array $arr_activity_data)
    {
        $this->module_title  = "";
        $this->module_action = "";
        $this->user_id       = "";
        $obj_data            = Sentinel::getUser();
        $user_id             = $obj_data->id;

        if(isset($arr_activity_data['module_title']))
        {
            $this->module_title   = $arr_activity_data['module_title'];
        }

        if(isset($arr_activity_data['module_action']))
        {
            $this->module_action = $arr_activity_data['module_action'];
        }

        if(isset($user_id))
        {
            $this->user_id       = $user_id;
        }              
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
