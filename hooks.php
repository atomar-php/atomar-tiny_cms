<?php

namespace cms_light;
use atomic\Atomic;
use atomic\core\Auth;
use atomic\core\Templator;

/**
 * Implements hook_permission()
 */
function permission() {
    return array(
        'administer_cms_light',
        'access_cms_light'
    );
}

/**
 * Implements hook_menu()
 */
function menu() {
    $items['secondary_menu']['/admin/cms_light'] = array(
        'link' => l('CMS Light', '/admin/cms_light/'),
        'class' => array(),
        'weight' => 0,
        'access' => 'administer_cms_light',
        'menu' => array()
    );
    return $items;
}

/**
 * Implements hook_url()
 */
function url() {
    return array(
        '/admin/cms_light/?(\?.*)?' => 'cms_light\controller\AdminIndex',
        '/admin/cms_light/stub/new/?(\?.*)?' => 'cms_light\controller\AdminStubNew',
        '/!/cms_light/(?P<api>[a-zA-Z\_-]+)/?(\?.*)?' => 'cms_light\controller\API',
        '/admin/cms_light/stub/(?P<id>\d+)/edit/?(\?.*)?' => 'cms_light\controller\AdminStubEdit',
    );
}

/**
 * Implements hook_libraries()
 */
function libraries() {
    return array(
        'CmsLightAPI.php'
    );
}

/**
 * Implements hook_cron()
 */
function cron() {
    // execute actions to be performed on cron
}

/**
 * Implements hook_twig_function()
 */
function twig_function() {
    // return an array of key value pairs.
    // key: twig_function_name
    // value: actual_function_name
    // You may use object functions as well
    // e.g. ObjectClass::actual_function_name
    if(Auth::has_authentication('administer_cms_light')) {
        Templator::$css[] = Templator::resolve_ext_asset('cms_light/css/editor.css');
    }
    return array(
        'cms_light' => 'cms_light\CmsLightAPI::render_stub'
    );
}
