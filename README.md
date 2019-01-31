This repo is used as a plugin of flarum. You can install it under flarum root directory with the command: 
```bash
composer require zhishiq/flarum-pusher
```

This plugin is an alternative of flarum/pusher. A drawback of flarum/pusher is that it doesn't have asynchronous feature. When a user submits a discussion reply, flarum/pusher will send a synchronous request to pusher.com. This request will block the response of discussion reply. So the user can feel flarum responds slowly, which is bad for user experience.

To solve this problem, this plugin uses zhishiq/queue to make requests to pusher.com asynchronous. When a discussion reply is submitted, a queueable job will be pushed to zhishiq/queue, which will be executed asynchronously with the command `flarum queue:listen` of zhishiq/queue.

In addition, because requests to flarum can be handled quickly, the system doesn't need a lot php processes blocked by requests to pusher.com, which can save memory and support more concurrent requests. 

Command `php flarum queue:listen` from zhishiq/queue should be executed as a daemon to execute jobs in queue.
