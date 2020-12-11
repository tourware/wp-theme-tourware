<?php

namespace Tourware;

abstract class Model
{
    /**
     * @var object
     */
    protected $rawData;

    /**
     * @var object
     */
    protected $post;

    /**
     * BaseModel constructor.
     * @param $rawData
     * @param $postId
     */
    public function __construct($rawData, $postId)
    {
        $this->postId = $postId;
        $this->rawData = $rawData;
    }

    /**
     * @param $name
     * @return string
     */
    public function __get($name)
    {
        return $this->rawData->$name;
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name) {
        return isset($this->rawData->$name);
    }

    /**
     * @return object
     */
    public function getRawData() {
        return $this->rawData;
    }

}