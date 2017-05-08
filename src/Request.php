<?php

namespace Rees\JsonRpc;

/**
 * Class Request
 *
 * @package \Rees\JsonRpc
 */
class Request
{
    /**
     * Method collection.
     *
     * @var array
     */
    protected $methods = [];

    /**
     * Construct an immutable JSON RPC request.
     *
     * @param array $methods
     */
    public function __construct(array $methods = [])
    {
        $this->methods = $methods;
    }

    /**
     * Get the methods for this request.
     *
     * @return array
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    /**
     * Fetch the request as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return array_map(function (Method $method){
            return $method->toArray();
        }, $this->methods);
    }

    /**
     * Fetch the request as JSON.
     *
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    /**
     * Render the request as string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }
}
