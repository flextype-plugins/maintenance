<?php

namespace Flextype;

/**
 *
 * Flextype Admin Plugin
 *
 * @author Romanenko Sergey / Awilum <awilum@yandex.ru>
 * @link http://flextype.org
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Flextype\Component\{Arr\Arr, Notification\Notification, Http\Http, Event\Event, Filesystem\Filesystem, Registry\Registry, Token\Token, I18n\I18n};
use Symfony\Component\Yaml\Yaml;
use function Flextype\Component\I18n\__;

//
// Add listner for onAdminArea event
//
Event::addListener('onAdminArea', function () {
    MaintenanceAdmin::getInstance();
});

NavigationManager::addItem('settings', 'maintenance', '<i class="fas fa-cog"></i>' . __('maintenance_admin_menu', Registry::get('settings.locale')), Http::getBaseUrl() . '/admin/maintenance', ['class' => 'nav-link']);

class MaintenanceAdmin {
    /**
     * An instance of the Admin class
     *
     * @var object
     * @access private
     */
    private static $instance = null;

    /**
     * Private clone method to enforce singleton behavior.
     *
     * @access private
     */
    private function __clone() { }

    /**
     * Private wakeup method to enforce singleton behavior.
     *
     * @access private
     */
    private function __wakeup() { }

    /**
     * Private construct method to enforce singleton behavior.
     *
     * @access private
     */
    protected function __construct()
    {
        MaintenanceAdmin::init();
    }

    protected static function init() {
        Http::getUriSegment(1) == 'maintenance' and MaintenanceAdmin::getMaintenancePage();
    }

    protected static function getMaintenancePage()
    {

        $action = Http::post('action');

        if (isset($action) && $action == 'save-form') {
            if (Token::check((Http::post('token')))) {

                // Delete this data - DONT STORE IT!
                Arr::delete($_POST, 'token');
                Arr::delete($_POST, 'action');

                // Set activated true/false bool type
                Arr::set($_POST, 'enabled', (Http::post('enabled') == '1' ? true : false));
                Arr::set($_POST, 'activated', (Http::post('activated') == '1' ? true : false));

                if (Filesystem::setFileContent(PATH['plugins'] . '/maintenance/settings.yaml', Yaml::dump($_POST))) {
                    Notification::set('success', __('maintenance_message_changes_saved'));
                    Http::redirect(Http::getBaseUrl().'/admin/maintenance');
                }

            } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
        }

        Themes::view('maintenance/views/templates/admin/settings')
            ->assign('plugin_settings', Yaml::parseFile(PATH['plugins'] . '/maintenance/settings.yaml'))
            ->display();
    }

    /**
     * Get the MaintenanceAdmin instance.
     *
     * @access public
     * @return object
     */
     public static function getInstance()
     {
        if (is_null(MaintenanceAdmin::$instance)) {
            MaintenanceAdmin::$instance = new self;
        }

        return MaintenanceAdmin::$instance;
     }
}
