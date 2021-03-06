<?php

/*
 * This file is part of Flarum.
 *
 * (c) Toby Zerner <toby.zerner@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ZhiShiQ\Flarum\Pusher\Listener;

use Flarum\Notification\Event\Sending;
use Flarum\Post\Event\Posted;
use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\User\Guest;
use Illuminate\Contracts\Events\Dispatcher;
use ZhiShiQ\Flarum\Pusher\Connector\PusherWrapper;

class PushNewPosts
{
    /**
     * @var SettingsRepositoryInterface
     */
    protected $settings;

    /**
     * @param SettingsRepositoryInterface $settings
     */
    public function __construct(SettingsRepositoryInterface $settings)
    {
        $this->settings = $settings;

    }

    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(Posted::class, [$this, 'pushNewPost']);
        $events->listen(Sending::class, [$this, 'pushNotification']);
    }

    /**
     * @param Posted $event
     */
    public function pushNewPost(Posted $event)
    {
        if ($event->post->isVisibleTo(new Guest)) {
            $pusher = $this->getPusher();

            $pusher->trigger('public', 'newPost', [
                'postId' => $event->post->id,
                'discussionId' => $event->post->discussion->id,
                'tagIds' => $event->post->discussion->tags()->pluck('id')
            ]);
        }
    }

    /**
     * @param Sending $event
     */
    public function pushNotification(Sending $event)
    {
        $pusher = $this->getPusher();
        $blueprint = $event->blueprint;

        foreach ($event->users as $user) {
            if ($user->shouldAlert($blueprint::getType())) {
                $pusher->trigger('private-user' . $user->id, 'notification', null);
            }
        }
    }

    /**
     * @return PusherWrapper
     */
    protected function getPusher()
    {
        return new PusherWrapper(boolval($this->settings->get('zhishiq.pusher.async_push')));
    }
}
