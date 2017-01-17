<?php

namespace tiny_cms\controller;

use atomar\core\Auth;
use atomar\core\Lightbox;
use atomar\core\Templator;
use tiny_cms\TinyCMS;

class AdminStubEdit extends Lightbox {
    function GET($matches = array()) {
        if (!Auth::has_authentication('administer_tiny_cms')) {
            set_error('You are not authorized to administer CMSLight');
            $this->redirect('/');
        }

        $stub = \R::load('cmslightstub', $matches['id']);
        if ($stub->id) {
            Templator::$js_onload[] = <<<JS
$('[data-validate]').each(function() {
  var v = new Validate($(this));
});
$('#field-name').change(function() {
  var value = human2machine($(this).val());
  $('#field-slug').val(value);
}).keyup( function () {
  $(this).change();
});
JS;
            Templator::$css_inline[] = <<<CSS
#slug {
      margin: 30px 0 0 10px;
    }
CSS;
            // configure lightbox
            $this->height(380);
            $this->width(500);
            $this->header('Edit Stub');
            echo $this->renderView('@tiny_cms/views/modal.stub.edit.html', array(
                'stub' => $stub
            ));
        } else {
            set_error('Unknown stub');
            $this->redirect();
        }
    }

    function POST($matches = array()) {
        if (!Auth::has_authentication('administer_tiny_cms')) {
            set_error('You are not authorized to administer TinyCMS');
            $this->redirect('/');
        }

        $stub = \R::load('cmslightstub', $matches['id']);
        if ($stub->id) {
            if ($_REQUEST['slug'] != $stub->slug) {
                \R::trash($stub);
            }
            $result = TinyCMS::define_stub($_REQUEST['name'], $_REQUEST['text']);
            if ($result) {
                set_success('Stub successfully updated');
            } else {
                set_error('The stub could not be updated');
            }
            $this->redirect();
        } else {
            set_error('Unknown stub');
            $this->redirect('/admin/tiny_cms/');
        }
    }

    /**
     * This method will be called before GET, POST, and PUT when the lightbox is returned to e.g. when using lightbox.dismiss_url or lightbox.return_url
     */
    function RETURNED() {

    }
}