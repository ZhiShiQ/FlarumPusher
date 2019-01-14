<?php
/**
 * Created by IntelliJ IDEA.
 * User: bill
 * Date: 2019-01-09
 * Time: 16:34
 */

namespace ZhiShiQ\Flarum\Pusher\Job;

use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Pusher;
use ZhiShiQ\Flarum\Queue\Bus\Dispatchable;

class PusherTrigger implements ShouldQueue
{
    use Dispatchable, Queueable;

    private $channels;
    private $event;
    private $data;
    private $socketIdToExclude;

    public function __construct($channels, $event, $data, $socketIdToExclude)
    {
        $this->channels = $channels;
        $this->event = $event;
        $this->data = $data;
        $this->socketIdToExclude = $socketIdToExclude;
    }

    public function handle(SettingsRepositoryInterface $settings)
    {
        $pusher = $this->getPusher($settings);

        $pusher->trigger($this->channels, $this->event, $this->data, $this->socketIdToExclude);
    }


    /**
     * @param SettingsRepositoryInterface $settings
     * @return Pusher
     */
    protected function getPusher(SettingsRepositoryInterface $settings)
    {
        $options = [];

        if ($cluster = $settings->get('zhishiq.pusher.app_cluster')) {
            $options['cluster'] = $cluster;
        }

        return new Pusher(
            $settings->get('zhishiq.pusher.app_key'),
            $settings->get('zhishiq.pusher.app_secret'),
            $settings->get('zhishiq.pusher.app_id'),
            $options
        );
    }
}
