<?php

namespace tiny_cms\controller;

use atomar\core\ApiController;
use atomar\core\Auth;

class API extends ApiController {

    function get_delete_stub($id) {
        if (Auth::has_authentication('administer_tiny_cms')) {
            $stub = \R::load('cmslightstub', $id);
            if ($stub->id) {
                \R::trash($stub);
                set_success('Stub successfuly deleted');
            } else {
                set_error('Unknown stub');
            }
        } else {
            set_error('You are not authorized to delete text stubs.');
        }
        $this->go_back();
    }

    /**
     * Allows you to perform any additional actions before get requests are processed
     * @param array $matches
     */
    protected function setup_get($matches = array()) {
        // TODO: Implement setup_get() method.
    }

    /**
     * Allows you to perform any additional actions before post requests are processed
     * @param array $matches
     */
    protected function setup_post($matches = array()) {
        // TODO: Implement setup_post() method.
    }
}