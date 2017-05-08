<?php

use Rees\JsonRpc\Method;
use Rees\JsonRpc\Request;
use PHPUnit\Framework\TestCase;

/**
 * Class RequestTest
 */
class RequestTest extends TestCase
{
    public function test_that_request_can_be_created()
    {
        $this->assertInstanceOf(Request::class, new Request);
    }

    public function test_that_methods_can_be_added_to_request()
    {
        $methods[] = $this->createTestMethod();
        $methods[] = $this->createTestMethod();
        $methods[] = $this->createTestMethod();
        $request = new Request($methods);

        $this->assertCount(3, $request->getMethods());
        $this->assertInstanceOf(Method::class, $request->getMethods()[0]);
    }

    public function test_that_request_can_be_expressed_as_array()
    {
        $methods[] = $this->createTestMethod();
        $methods[] = $this->createTestMethod();
        $methods[] = $this->createTestMethod();
        $request = new Request($methods);

        $this->assertCount(3, $request->toArray());
        $this->assertEquals(123, $request->toArray()[0]['id']);
        $this->assertEquals('2.0', $request->toArray()[1]['jsonrpc']);
        $this->assertEquals([1, 2, 3], $request->toArray()[2]['params']);
    }

    public function test_that_request_can_be_expressed_as_json()
    {
        $methods[] = $this->createTestMethod();
        $methods[] = $this->createTestMethod();
        $methods[] = $this->createTestMethod();
        $request = new Request($methods);

        $this->assertEquals('[{"jsonrpc":"2.0","method":"test.method","params":[1,2,3],"id":"123"},{"jsonrpc":"2.0"'.
            ',"method":"test.method","params":[1,2,3],"id":"123"},{"jsonrpc":"2.0","method":'.
            '"test.method","params":[1,2,3],"id":"123"}]', $request->toJson());
    }

    protected function createTestMethod()
    {
        return new Method('2.0', 'test.method', [1, 2, 3], '123');
    }
}
