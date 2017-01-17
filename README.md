Tiny CMS
========

This extension provides a very lightweight content management system. By placing tags in templates you can
quickly create editable content on  your pages.

###Using In Templates
To add a tag to a template use the twig function provided below:

    {{ tiny_cms('my-snippet', sys.template) }}

Where `my_snippet` is the machine readable name of the snippet that will be inserted.
The second parameter is the template path which is only useful to help determine where snippets are located when
viewing the current snippets.
You can easily provide this second parameter by just using the predefined template variable `sys.template`.

> NOTE: for now only dashes (not underscores) are supported in slug names.

###Using in PHP
There are a few different methods available via the php api.

* `TinyCMS::render_stub($stub_slug, $template=null)` - this is the method that does all the work in the template
function shown above.
* `TinyCMS::define_stub($name, value)` - creates a new stub with the given name and value.
* `TinyCMS::get_all_stubs()` - returns all of the stub beans.