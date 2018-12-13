<?php
namespace Flextype;
use Flextype\Component\{Http\Http, Registry\Registry, I18n\I18n, Token\Token, Form\Form, Event\Event};
use function Flextype\Component\I18n\__;
?>

<?php
    Themes::view('admin/views/partials/head')->display();
    Themes::view('admin/views/partials/navbar')
        ->assign('links', ['settings' => ['link' => Http::getBaseUrl() . '/admin/maintenance', 'title' => I18n::find('maintenance_admin_heading', Registry::get('settings.locale')),'attributes' => ['class' => 'navbar-item active'] ]])
        ->assign('buttons', [
                                'save' => [
                                                'link'       => 'javascript:;',
                                                'title'      => __('admin_save'),
                                                'attributes' => ['class' => 'js-save-form-submit float-right btn']
                                          ]
                            ])
        ->display();
    Themes::view('admin/views/partials/content-start')->display();
?>

<?php echo Form::open(null, ['id' => 'form']); ?>
<?php echo Form::hidden('token', Token::generate()); ?>
<?php echo Form::hidden('action', 'save-form'); ?>
<?php echo Form::hidden('enabled', $plugin_settings['enabled']); ?>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <?php
                echo (
                    Form::label('activated', I18n::find('maintenance_admin_settings_activated', Registry::get('settings.locale')), ['for' => 'maintenanceActivated']).
                    Form::select('activated', [0 => 'false', 1 => 'true'], $plugin_settings['activated'], ['class' => 'form-control', 'id' => 'maintenanceActivated', 'required'])
                );
            ?>
        </div>
        <div class="form-group">
            <?php
                echo (
                    Form::label('msg_title', I18n::find('maintenance_admin_settings_msg_title', Registry::get('settings.locale')), ['for' => 'maintenanceMsgTitle']).
                    Form::input('msg_title', $plugin_settings['msg_title'], ['class' => 'form-control', 'id' => 'maintenanceMsgTitle', 'required'])
                );
            ?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <?php
                echo (
                    Form::label('msg_description', I18n::find('maintenance_admin_settings_msg_description', Registry::get('settings.locale')), ['for' => 'maintenanceMsgDescription']).
                    Form::input('msg_description', $plugin_settings['msg_description'], ['class' => 'form-control', 'id' => 'maintenanceMsgDescription', 'required'])
                );
            ?>
        </div>
        <div class="form-group">
            <?php
                echo (
                    Form::label('bg_img_url', I18n::find('maintenance_admin_settings_bg_img_url', Registry::get('settings.locale')), ['for' => 'maintenanceBgImageUrl']).
                    Form::input('bg_img_url', $plugin_settings['bg_img_url'], ['class' => 'form-control', 'id' => 'maintenanceBgImageUrl', 'required'])
                );
            ?>
        </div>
    </div>
</div>
<?php echo Form::close(); ?>

<?php
    Themes::view('admin/views/partials/content-end')->display();
    Themes::view('admin/views/partials/footer')->display();
?>
