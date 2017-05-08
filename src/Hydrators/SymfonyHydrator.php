<?php

namespace Rees\JsonRpc\Hydrators;

use Rees\JsonRpc\Method;
use Rees\JsonRpc\Request;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

/**
 * Class SymfonyHydrator
 *
 * @package \Rees\JsonRpc\Hydrators
 */
class SymfonyHydrator implements Hydrator
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $symfony;

    /**
     * Hydrate a request from a Symfony HTTP Foundation request object.
     *
     * @param \Symfony\Component\HttpFoundation\Request $symfony
     */
    public function __construct(SymfonyRequest $symfony)
    {
        $this->symfony = $symfony;
    }

    /**
     * Hydrate a request object.
     *
     * @return \Rees\JsonRpc\Request
     */
    public function hydrate(): Request
    {
        $methods = [];
        $params = json_decode($this->symfony->getContent(), true);

        $content = $this->symfony->getContent();
        $params = array_change_key_case($params);

        if ($this->verifyPayload($params)) {
            $methods[] = $this->hydrateMethod($params);
        } else {
            foreach ($params as $payload) {
                $payload = array_change_key_case($payload);
                if ($this->verifyPayload($payload)) {
                    $methods[] = $this->hydrateMethod($payload);
                }
            }
        }

        return new Request($methods);
    }

    /**
     * Verify that a payload is a valid JSON RPC request.
     *
     * @param array $params
     *
     * @return bool
     */
    protected function verifyPayload(array $params)
    {
        return (
            array_key_exists('jsonrpc', $params) &&
            array_key_exists('method', $params)
        );
    }

    /**
     * Hydrate a method from request payload.
     *
     * @param array $params
     *
     * @return \Rees\JsonRpc\Method
     */
    protected function hydrateMethod(array $params)
    {
        $version    = $params['jsonrpc'];
        $parameters = $params['params'];
        $name       = null;
        $id         = null;

        if (array_key_exists('method', $params)) {
            $name = $params['method'];
        }

        if (array_key_exists('id', $params)) {
            $id = $params['id'];
        }

        return new Method($version, $name, $parameters, $id);
    }
}
