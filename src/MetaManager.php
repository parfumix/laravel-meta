<?php

namespace Terranet\Metaable\Eloquent;

class MetaManager implements \ArrayAccess {

    /**
     * @var array
     */
    private $attributes;

    public function __construct(array $attributes = []) {

        $this->setFromArray($attributes);
    }

    /**
     * Set attributes ..
     *
     * @param array $attributes
     * @return $this
     */
    public function setFromArray(array $attributes) {
        array_walk($attributes, function($value, $attribute) {
            $this->set{ucfirst($attribute)}($value);
        });

        return $this;
    }

    /**
     * Set title ..
     *
     * @param $title
     * @return $this
     */
    public function setTitle($title) {
        $this->attributes['title'] = $title;

        return $this;
    }

    /**
     * Set description ..
     *
     * @param $description
     * @return $this
     */
    public function setDescription($description) {
        if( $description === null )
            return;

        $this->attributes['description'] = $description;

        return $this;
    }

    /**
     * Set keywords ..
     *
     * @param $keywords
     * @return $this|void
     */
    public function setKeywords($keywords) {
        if ($keywords === null)
            return;

        if( is_array($keywords) )
            $keywords = implode(', ', $keywords);

        $this->attributes['keywords'] = strtolower(
            strip_tags($keywords)
        );

        return $this;
    }

    /**
     * Get title .
     *
     * @return mixed
     */
    public function getTitle() {
        return $this->attributes['title'];
    }

    /**
     * Get description .
     *
     * @return mixed
     */
    public function getDescription() {
        return $this->attributes['description'];
    }

    /**
     * Get keywords .
     *
     * @return mixed
     */
    public function getKeywords() {
        return $this->attributes['keywords'];
    }

    /**
     * Set meta from entity ..
     *
     * @param Metaable $metaable
     * @return $this
     */
    public function setFromEntity(Metaable $metaable) {
        $this->setTitle(
            $metaable->getMetaTitle()
        );

        $this->setDescription(
            $metaable->getMetaDescription()
        );

        $this->setKeywords(
            $metaable->getMetaKeywords()
        );

        return $this;
    }

    /**
     * Reset all meta ..
     *
     * @return $this
     */
    public function flush() {
        unset($this->attributes);

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

        if( array_key_exists($key, $this->attributes) )
            return;

        unset($this->attributes[$key]);

        return $this;
    }

    public function toHtml($key = null) {
        return 1;
        #@todo .
    }

    public function __toString() {
        return $this->toHtml();
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
        // TODO: Implement offsetExists() method.
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
        // TODO: Implement offsetGet() method.
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
        // TODO: Implement offsetSet() method.
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
        // TODO: Implement offsetUnset() method.
    }
}