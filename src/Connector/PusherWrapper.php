<?php
/**
 * Created by IntelliJ IDEA.
 * User: bill
 * Date: 2018/11/29
 * Time: 12:43
 */

namespace ZhiShiQ\Flarum\Pusher\Connector;

use ZhiShiQ\Flarum\Pusher\Job\PusherTrigger;

class PusherWrapper
{
    private $asyncPush;

    public function __construct($asyncPush)
    {
        $this->asyncPush = boolval($asyncPush);
    }

    /**
     * @param array|string $channels
     * @param string $event
     * @param mixed $data
     * @param string|null $socketIdToExclude
     */
    public function trigger($channels, $event, $data, $socketIdToExclude = null)
    {
        if ($this->asyncPush) {
            PusherTrigger::dispatch($channels, $event, $data, $socketIdToExclude);
        } else {
            PusherTrigger::dispatchNow($channels, $event, $data, $socketIdToExclude);
        }
    }
}
