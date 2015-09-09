<?php

namespace Laravel\Meta;

use Eloquent\Translatable\Translatable;
use Illuminate\Contracts\Support\Arrayable;
use Laravel\Meta\Eloquent\MetaSeoable;
use Localization as Locale;

class MetaManager implements \ArrayAccess, Arrayable {

    /**
     * @var array
     */
    private $attributes = [];

    /**
     * @var array
     */
    protected $cleanAttributes = [];

    /**
     * @var array
     */
    protected $templates = [
        'title'       => '<title>%s</title>',
        'description' => '<meta name="description" content="%s">',
    ];

    /**
     * @var array
     */
    protected $configurations = [];

    public function __construct(array $configurations = [], array $templates = array()) {
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

        $this->configurations = $configurations;
    }


    /**
     * Set attributes ..
     *
     * @param array $attributes
     * @return $this
     */
    public static function fromArray(array $attributes) {
        $metaManager = app('meta');

        array_walk($attributes, function($value, $attribute) use($metaManager) {
            $metaManager->set($attribute, $value);
        });

        return $metaManager;
    }

    /**
     * Get meta from eloquent .
     *
     * @param MetaSeoable $metaable
     * @param null $locale
     * @param array $placeholders
     * @return \Illuminate\Foundation\Application|mixed
     */
    public static function fromEloquent(MetaSeoable $metaable, $locale = null, $placeholders = []) {
        $meta = app('meta');

        if( empty($placeholders) )
            $placeholders = $meta->configurations['placeholders'];

        $locale = isset($locale) ? $locale : Locale\get_active_locale();

        $metaTranslatedRow = [];
        if( $metaRow = $metaable->metaSeo() ) {
            if( $translation =  $metaRow->translate($locale) )
                $metaTranslatedRow = $translation->toArray();
        }

        foreach ($meta->templates as $key => $template) {

            $value       = isset($metaTranslatedRow[$key]) ? $metaTranslatedRow[$key] : '';
            $placeholder = $value;

            if (! $value || $value == '')
                if ($metaable->allowGlobalPlaceholders()) {
                    $placeholder = $placeholders[$key];
                    $value       = $placeholder;
                }


            if (preg_match_all("/%%([a-zA-Z-_]+)%%/", $placeholder, $matches)) {

                foreach ($matches[1] as $place) {
                    if(! $replaced = $metaable->{$place}) {
                        if( $metaable instanceof Translatable )
                            $replaced = isset($metaable->translate($locale)->{$place}) ? $metaable->translate($locale)->{$place} : '';
                    }

                    $value = str_replace('%%'.$place.'%%', $replaced, $value);
                }
            }

            $meta->set($key, trim($value));
        }

        return $meta;
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

        $this->cleanAttributes[$name] = $value;

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
        $attributes = $this->toArray();

        $html = '';
        foreach($attributes as $attribute) {
            $html .= $attribute;
        }

        return $html;
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
     * @param bool $clean
     * @return array
     */
    public function toArray($clean = false) {
        if( $clean )
            return $this->cleanAttributes;

       return $this->attributes;
    }
}