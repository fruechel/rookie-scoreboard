<?php


class TemplateException extends Exception {}


/**
 * Generic Template class.
 *
 * Includes the templates, so PHP Code in templates is possible, but this should
 * be kept to a minimum.
 *
 * Example of usage:
 * $template = new Template('templates/template.php');
 * $template->assign('key', 'value');
 * $output = $template->render();
 *
 * That's it, folks!
 *
 * @author qll
 */
class Template
{
    public static $encoding = 'utf-8';
    public static $functions = array();  // available in templates

    private $template;  // path to the template
    private $path;  // path to the templates directory
    private $vars;  // variables for this template
    private $blocks;  // blocks defined in child templates
    private $parent;  // parent Template
    private $current_block;
    private $bound_functions;  // template functions bound to this template 

    public function __construct($template, $path = '')
    {
        if (!file_exists($path . $template)) {
            $msg = "Template $path$template does not exist.";
            throw new TemplateException($msg);
        }
        $this->template = $template;
        $this->path = $path;
        $this->vars = array();
        $this->blocks = array();
        $this->parent = null;
        $this->current_block = '';
        foreach (self::$functions as $name => $function) {
            $this->bound_functions[$name] = apply_partial($function, $this);
        }
    }

    /** Assign a variable $key to a $value fo use in the template. */
    public function assign($key, $value)
    {
        $this->vars[$key] = $value;
    }

    /** Retrieve previously assigned template variable. */
    public function get($key, $default = null)
    {
        if (!isset($this->vars[$key])) {
            if (!is_null($default)) {
                return $default;
            }
            throw new TemplateException("Undefined key: $key");
        }
        if (empty($this->vars[$key]) && !is_null($default)) {
            return $default;
        }
        return $this->vars[$key];
    }

    /** Render template to output. */
    public function render()
    {
        extract($this->bound_functions, EXTR_SKIP);  // alias template functions
        extract($this->vars, EXTR_SKIP);  // make template vars local

        ob_start();
        include $this->path . $this->template;
        $output = ob_get_contents();
        ob_end_clean();

        if (!is_null($this->parent)) {
            foreach ($this->vars as $key => $value) {
                $this->parent->assign($key, $value);
            }
            $output .= $this->parent->render();
        }

        return $output;
    }

    /** Convert HTML special chars (<>"'&) to their HTML entities. */
    static public function encode($string)
    {
        if (is_int($string)) {
            $string = strval($string);
        }
        if (!is_string($string)) {
            $string = 'ERRROR ERRROR';
        }
        return htmlentities($string, ENT_QUOTES, self::$encoding);
    }

    /** Assigns a block to a Template which can be filled by child Templates. */
    private function assignBlock($key, $content)
    {
        $this->blocks[$key] = $content;
    }

    /** Extend the current template with a base template. */
    private function extend($base_template)
    {
        $this->parent = new Template($base_template, $this->path);
    }

    /**
     * Define a block for the parent template.
     *
     * MUST be followed by $this->endBlock($name);
     *
     * Example:
     * <?php $this->extend('main.html.php'); ?>
     * <?php $this->startBlock('content'); ?>
     *   <div id="something">
     *     Some content
     *   </div>
     * <?php $this->endBlock('content'); ?>
     *
     * The variable content will be available in the parent template now.
     * Parents print it like this: <?php echo $this->block('content'); ?>
     */
    private function startBlock($name)
    {
        if (empty($this->parent)) {
            $msg = "Parent needs to be defined with "
                   . "\$this->extend('file.html.php') before a block can be "
                   . "started.";
            throw new TemplateException($msg);
        }
        $this->current_block = $name;
        ob_start();
    }

    /** Stop the definition of a block. Name is optional. */
    private function endBlock($name = null)
    {
        if (empty($this->current_block)) {
            throw new TemplateException('No block was opened.');
        }
        if (!is_null($name) && $name != $this->current_block) {
            $msg = "Closing a block that wasn't open in the first place ($name "
                   . "closed, but {$this->current_block} was open).";
            throw new TemplateException($msg);
        }
        $content = ob_get_contents();
        ob_end_clean();
        $this->parent->assignBlock($this->current_block, $content);
        $this->current_block = '';
    }

    /** Print a block if it exists. */
    private function block($key)
    {
        echo (isset($this->blocks[$key])) ? $this->blocks[$key] : '';
    }
}


// default template functions
Template::$functions = array(
    'get' => function($template, $key, $default = null) {
        return $template->get($key, $default);
    },
    'encode' => function($template, $string) {
        return Template::encode($string);
    }
);
