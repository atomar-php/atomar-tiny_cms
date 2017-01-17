<?php

namespace tiny_cms;
use atomar\core\Auth;
use atomar\core\HookReceiver;
use atomar\core\Templator;

/**
 * Receives hook events from Atomar on behalf of the module
 */
class Hooks extends HookReceiver
{
    function hookPermission()
    {
        return array(
            'administer_tiny_cms',
            'access_tiny_cms'
        );
    }

    function hookMenu()
    {
        $items['secondary_menu']['/admin/tiny_cms'] = array(
            'link' => l('CMS Light', '/admin/tiny_cms/'),
            'class' => array(),
            'weight' => 0,
            'access' => 'administer_tiny_cms',
            'menu' => array()
        );
        return $items;
    }

    function hookControls()
    {
        return 'tiny_cms/AdminIndex';
    }

    /**
     * Returns an array of routes mapped to controllers
     *
     * @param $module the instance of this module
     * @return array the array of routes
     */
    function hookRoute($module)
    {
        $urls = $this->loadRoute($module, 'public');

        // perform custom logic to determine available routes if necessary.

        return $urls;
    }

    function hookLibraries()
    {
        return array(
            'tiny_cms/TinyCMS.php'
        );
    }

    function hookPage()
    {
        if(Auth::has_authentication('administer_tiny_cms')) {
            Templator::$css[] = Templator::resolve_ext_asset('tiny_cms/css/editor.css');
        }
    }

    function hookTwig($twig)
    {
        $twig->addFunction(new \Twig_SimpleFunction('tiny_cms', function($slug, $template_name=null) {
            TinyCMS::render_stub($slug, $template_name);
        }));
    }
}