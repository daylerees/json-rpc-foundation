<?php

namespace Rees\JsonRpc\Hydrators;

use Rees\JsonRpc\Request;

/**
 * Interface Hydrator
 *
 * @package \Rees\JsonRpc\Hydrators
 */
interface Hydrator
{
    /**
     * Hydrate a JSON RPC request.
     *
     * @return \Rees\JsonRpc\Request
     */
    public function hydrate(): Request;
}
