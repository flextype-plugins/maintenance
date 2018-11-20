<?php
namespace Flextype;
use Flextype\Component\{Http\Http, Registry\Registry, I18n\I18n, Token\Token, Form\Form, Event\Event};
?>

<?php
    Themes::view('admin/views/partials/head')->display();
    Themes::view('admin/views/partials/navbar')
        ->assign('links', ['settings' => ['url' => Http::getBaseUrl() . '/admin/maintenance', 'title' => I18n::find('maintenance_admin_heading', Registry::get('system.locale'))]])
        ->display();
    Themes::view('admin/views/partials/content-start')->display();
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <?php echo I18n::find('maintenance_admin_settings', Registry::get('system.locale')); ?>
            </div>
            <div class="card-body">
                <?php echo Form::open(); ?>
                <?php echo Form::hidden('token', Token::generate()); ?>
                <?php echo Form::hidden('enabled', $plugin_settings['enabled']); ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php
                                echo (
                                    Form::label('activated', I18n::find('maintenance_admin_settings_activated', Registry::get('system.locale')), ['for' => 'maintenanceActivated']).
                                    Form::select('activated', [0 => 'false', 1 => 'true'], $plugin_settings['activated'], ['class' => 'form-control', 'id' => 'maintenanceActivated', 'required'])
                                );
                            ?>
                        </div>
                        <div class="form-group">
                            <?php
                                echo (
                                    Form::label('msg_title', I18n::find('maintenance_admin_settings_msg_title', Registry::get('system.locale')), ['for' => 'maintenanceMsgTitle']).
                                    Form::input('msg_title', $plugin_settings['msg_title'], ['class' => 'form-control', 'id' => 'maintenanceMsgTitle', 'required'])
                                );
                            ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php
                                echo (
                                    Form::label('msg_description', I18n::find('maintenance_admin_settings_msg_description', Registry::get('system.locale')), ['for' => 'maintenanceMsgDescription']).
                                    Form::input('msg_description', $plugin_settings['msg_description'], ['class' => 'form-control', 'id' => 'maintenanceMsgDescription', 'required'])
                                );
                            ?>
                        </div>
                        <div class="form-group">
                            <?php
                                echo (
                                    Form::label('bg_img_url', I18n::find('maintenance_admin_settings_bg_img_url', Registry::get('system.locale')), ['for' => 'maintenanceBgImageUrl']).
                                    Form::input('bg_img_url', $plugin_settings['bg_img_url'], ['class' => 'form-control', 'id' => 'maintenanceBgImageUrl', 'required'])
                                );
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <div class="form-group no-margin">
                    <?php echo Form::submit('maintenance_settings_save', I18n::find('admin_save', Registry::get('system.locale')), ['class' => 'btn']); ?>
                </div>
            </div>
            <?php echo Form::close(); ?>
        </div>
    </div>
</div>

<?php
    Themes::view('admin/views/partials/content-end')->display();
    Themes::view('admin/views/partials/footer')->display();
?>
