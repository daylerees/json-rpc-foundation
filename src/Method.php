<?php

namespace Rees\JsonRpc;

/**
 * Class Method
 *
 * @package \Rees\JsonRpc
 */
class Method
{
    /**
     * Protocol version.
     *
     * @var string
     */
    protected $version;

    /**
     * Method name.
     *
     * @var string
     */
    protected $name;

    /**
     * Parameter array.
     *
     * @var array
     */
    protected $parameters = [];

    /**
     * Method ID.
     *
     * @var string
     */
    protected $id;

    /**
     * Construct an immutable JSON RPC method.
     *
     * @param string|null  $version
     * @param string|null  $name
     * @param array        $parameters
     * @param string|null  $id
     */
    public function __construct($version = null, $name = null, array $parameters = [], $id = null)
    {
        $this->version    = $version;
        $this->name       = $name;
        $this->parameters = $parameters;
        $this->id         = $id;
    }

    /**
     * Get Version.
     *
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * Get Name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get Name.
     *
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Get Parameters.
     *
     * @return array
     */
    public function getParameters() : array
    {
        return $this->parameters;
    }

    /**
     * Get Parameters.
     *
     * @return array
     */
    public function getParams() : array
    {
        return $this->parameters;
    }

    /**
     * Get Parameters.
     *
     * @return array
     */
    public function parameters() : array
    {
        return $this->parameters;
    }

    /**
     * Get Parameters.
     *
     * @return array
     */
    public function params() : array
    {
        return $this->parameters;
    }

    /**
     * Get Id.
     *
     * @return string
     */
    public function getId() : string
    {
        return $this->id;
    }

    /**
     * Get Id.
     *
     * @return string
     */
    public function id() : string
    {
        return $this->id;
    }

    /**
     * Fetch this method as JSON.
     *
     * @return string
     */
    public function toJson() : string
    {
        return json_encode($this->toArray());
    }

    /**
     * Fetch this method as array.
     *
     * @return array
     */
    public function toArray() : array
    {
        $payload = [
            'jsonrpc' => $this->version,
            'method'  => $this->name,
            'params'  => (array) $this->parameters
        ];

        if (!is_null($this->id)) {
            $payload['id'] = $this->id;
        }

        return $payload;
    }

    /**
     * Render the method as string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * Create a successful response for this method.
     *
     * @param mixed $result
     *
     * @return \Rees\JsonRpc\Response
     */
    public function createResponse($result): Response
    {
        return (new Response)
            ->setVersion($this->version)
            ->setId($this->id)
            ->setResult($result);
    }

    /**
     * Create a successful response for this method.
     *
     * @param mixed $result
     *
     * @return \Rees\JsonRpc\Response
     */
    public function response($result): Response
    {
        return (new Response)
            ->setVersion($this->version)
            ->setId($this->id)
            ->setResult($result);
    }

    /**
     * Create an error response for this method.
     *
     * @param $code
     * @param $message
     * @param $data
     *
     * @return \Rees\JsonRpc\Response
     */
    public function createError($code, $message, $data): Response
    {
        return (new Response)
            ->setVersion($this->version)
            ->setId($this->id)
            ->setCode($code)
            ->setMessage($message)
            ->setData($data);
    }

    /**
     * Create an error response for this method.
     *
     * @param $code
     * @param $message
     * @param $data
     *
     * @return \Rees\JsonRpc\Response
     */
    public function error($code, $message, $data): Response
    {
        return (new Response)
            ->setVersion($this->version)
            ->setId($this->id)
            ->setCode($code)
            ->setMessage($message)
            ->setData($data);
    }
}
