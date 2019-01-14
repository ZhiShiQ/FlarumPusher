import SettingsModal from 'flarum/components/SettingsModal';

export default class PusherSettingsModal extends SettingsModal {
  className() {
    return 'PusherSettingsModal Modal--small';
  }

  title() {
    return app.translator.trans('zhishiq.pusher.admin.setting_title');
  }

  form() {
    return [
      <div className="Form-group">
        <label>{app.translator.trans('zhishiq.pusher.admin.app_id_label')}</label>
        <input className="FormControl" bidi={this.setting('zhishiq.pusher.app_id')}/>
      </div>,

      <div className="Form-group">
        <label>{app.translator.trans('zhishiq.pusher.admin.app_key_label')}</label>
        <input className="FormControl" bidi={this.setting('zhishiq.pusher.app_key')}/>
      </div>,

      <div className="Form-group">
        <label>{app.translator.trans('zhishiq.pusher.admin.app_secret_label')}</label>
        <input className="FormControl" bidi={this.setting('zhishiq.pusher.app_secret')}/>
      </div>,

      <div className="Form-group">
        <label>{app.translator.trans('zhishiq.pusher.admin.app_cluster_label')}</label>
        <input className="FormControl" bidi={this.setting('zhishiq.pusher.app_cluster')}/>
      </div>,

      <div className="Form-group">
        <label>{app.translator.trans('zhishiq.pusher.admin.async_push')}</label>
        <input className="FormControl" bidi={this.setting('zhishiq.pusher.async_push')}/>
      </div>,
    ];
  }
}
