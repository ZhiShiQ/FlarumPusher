import { extend } from 'flarum/extend';
import app from 'flarum/app';

import PusherSettingsModal from './components/PusherSettingsModal';

app.initializers.add('zhishiq-pusher', app => {
  app.extensionSettings['zhishiq-pusher'] = () => app.modal.show(new PusherSettingsModal());
});
