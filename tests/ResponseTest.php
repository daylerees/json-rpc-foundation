<?php

use Rees\JsonRpc\Response;
use PHPUnit\Framework\TestCase;

/**
 * Class ResponseTest
 */
class ResponseTest extends TestCase
{
    public function test_that_response_can_be_created()
    {
        $this->assertInstanceOf(Response::class, new Response);
    }
}
