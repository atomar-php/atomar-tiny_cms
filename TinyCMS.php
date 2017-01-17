<?php

namespace tiny_cms;
use atomar\core\Auth;

/**
 * This is the internal api class that can be used by third party extensions
 */
class TinyCMS {
    /**
     * Render the text given the text id
     *
     */
    public static function render_stub($stub_slug, $template_name = null) {
        if(!is_string($template_name)) {
            $template_name = null;
        }
        $stub = \R::findOne('cmslightstub', 'slug=? LIMIT 1', array($stub_slug));
        if ($stub->id) {
            // update the stub location in case we moved it.
            if ($template_name != null) {
                if (stripos($stub->location, $template_name) === false) {
                    if ($stub->location == '') {
                        $stub->location = $template_name;
                    } else {
                        $stub->location .= ', ' . $template_name;
                    }
                }
            }
            store($stub);
        } else {
            // create the stub for the backend and return nothing
            $stub = \R::dispense('cmslightstub');
            $stub->slug = $stub_slug;
            $stub->name = machine_to_human($stub_slug);
            $stub->value = ' ';
            if ($template_name != null) {
                $stub->location = $template_name;
            }
            store($stub);
        }

        // display editing shortcuts if viewed by administrator.
        if (Auth::has_authentication('administer_cms_light')) {
            $value = $stub->value;
            if (trim($value) == '') {
                $value = '[CMS Light: ' . $stub->name . ']';
                $muted = 'text-muted';
            }
            $name = $stub->name;
            $id = $stub->id;
            $response = <<<HTML
<div id="cms-light-container-$id" class="cms-light-editor">
  <a data-lightbox="/admin/cms_light/stub/$id/edit/" class="cms-light-controls pull-right">Edit '$name' <span class="glyphicon glyphicon-cog"></span></a>
  <span class="cms-light-value muted">$value</span>
</div>
HTML;
            return $response;
        } else {
            return $stub->value;
        }
    }

    /**
     * Define a new text stub or replace an existing one.
     *
     */
    public static function define_stub($name, $value) {
        $slug = human_to_machine($name);
        $stub = \R::findOne('cmslightstub', 'name=? OR slug=? LIMIT 1', array($name, $slug));
        if ($stub->id) {
            $stub->name = $name;
            $stub->slug = $slug;
            $stub->value = $value;
        } else {
            unset($stub);
            $stub = \R::dispense('cmslightstub');
            $stub->name = $name;
            $stub->slug = $slug;
            $stub->value = $value;
        }
        return store($stub);
    }

    /**
     * Get all the stubs
     *
     */
    public static function get_all_stubs() {
        return \R::findAll('cmslightstub');
    }
}