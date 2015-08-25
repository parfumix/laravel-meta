<?php

namespace Laravel\Meta;

use Illuminate\Contracts\Support\Arrayable;
use Laravel\Meta\Eloquent\Metaable;

class MetaManager implements \ArrayAccess, Arrayable {

    /**
     * @var array
     */
    private $attributes = [];

    protected $templates = [
        'title'       => '<title>%s</title>',
        'description' => '<meta name="description" content="%s">',
    ];

    public function __construct(array $attributes = [], array $templates = array()) {
        $this->templates['keywords'] = function($keywords) {
            if ($keywords === null)
                return;

            if( is_array($keywords) )
                $keywords = implode(', ', $keywords);

            $keywords = sprintf('<meta name="keywords" content="%s"/>', strtolower(
                strip_tags($keywords)
            ));

            return $keywords;
        };

        $this->addTemplates($templates);

        $this->fromArray($attributes);
    }


    /**
     * Set attributes ..
     *
     * @param array $attributes
     * @return $this
     */
    public function fromArray(array $attributes) {
        array_walk($attributes, function($value, $attribute) {
            $this->set($attribute, $value);
        });

        return $this;
    }

    /**
     * Set meta from entity ..
     *
     * @param Metaable $metaable
     * @return $this
     */
    public function fromEloquent(Metaable $metaable) {
        $prefix = 'getMeta';

        array_walk($this->templates, function($template, $key) use($prefix, $metaable) {
            $funcName = sprintf('%s%s', $prefix, ucfirst($key));

            if( in_array($funcName, get_class_methods(get_class($metaable))) )
                $this->set(
                    $key,
                    $metaable->{$funcName}()
                );
        });

        return $this;
    }


    /**
     * Set meta .
     *
     * @param $name
     * @param $value
     * @param bool $replace
     * @return $this
     */
    public function set($name, $value, $replace = true) {
        $template = null;

        if( $replace ) {
            if( array_key_exists( $name, $this->templates ) )
                $template = $this->templates[$name];
        } else {
            if( ! array_key_exists($name, $this->attributes) )
                $template = $this->templates[$name];
        }

        if( !is_null($template) )
            if( is_callable($template) )
                $this->attributes[$name] = call_user_func($template, $value);
            else
                $this->attributes[$name] = str_replace('%s', $value, $template);

        return $this;
    }

    /**
     * Get meta by key.
     *
     * @param $key
     * @param string $default
     * @return string
     */
    public function get($key, $default = '') {
        if( isset($this->attributes[$key]) )
            return $this->attributes[$key];

        return $default;
    }


    /**
     * Reset all meta ..
     *
     * @return $this
     */
    public function flush() {
        $this->attributes = [];

        return $this;
    }

    /**
     * Clear specific meta tag ..
     *
     * @param null $key
     * @return $this|MetaManager|void
     */
    public function clear($key = null) {
        if( $key === null )
            return $this->flush();

        if( ! array_key_exists($key, $this->attributes) )
            return;

        unset($this->attributes[$key]);

        return $this;
    }


    /**
     * Render all attributes.
     *
     * @return \Illuminate\View\View
     */
    public function render() {
        $attributes = $this->attributes;

        return view('meta::meta', compact('attributes'));
    }

    public function __toString() {
        return $this->render();
    }


    /**
     * Add more templates .
     *
     * @param array $templates
     * @return $this
     */
    public function addTemplates(array $templates = array()) {
        $this->templates = array_merge(
            $templates,
            $this->templates
        );

        return $this;
    }


    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     */
    public function offsetExists($offset) {
        return isset($this->attributes[$offset]);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset) {
        return $this->offsetExists($offset) ? $this->get($offset) : null;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     */
    public function offsetSet($offset, $value) {
        if (! is_null($offset)) {
            $this->set($offset, $value);
        }
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     */
    public function offsetUnset($offset) {
        if ($this->offsetExists($offset)) {
            unset($this->attributes[$offset]);
        }
    }


    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray() {
       return $this->attributes;
    }
}