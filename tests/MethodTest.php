<?php

use Rees\JsonRpc\Method;
use Rees\JsonRpc\Response;
use PHPUnit\Framework\TestCase;

/**
 * Class MethodTest
 */
class MethodTest extends TestCase
{
    public function test_method_can_be_created()
    {
        $this->assertInstanceOf(Method::class, new Method);
    }

    public function test_method_values_can_be_set()
    {
        $method = new Method('2.0', 'Test method', ['foo' => 'bar'], '123');

        $this->assertEquals('2.0', $method->getVersion());
        $this->assertEquals('Test method', $method->getName());
        $this->assertEquals(['foo' => 'bar'], $method->getParameters());
        $this->assertEquals('123', $method->getId());
    }

    public function test_method_can_be_presented_as_array()
    {
        $method = new Method('2.0', 'Test method', ['foo' => 'bar'], '123');

        $this->assertEquals([
            'jsonrpc' => '2.0',
            'method'  => 'Test method',
            'params'  => ['foo' => 'bar'],
            'id'      => 123
        ], $method->toArray());
    }

    public function test_method_can_be_presented_as_json()
    {
        $method = new Method('2.0', 'Test method', ['foo' => 'bar'], '123');

        $this->assertEquals(
            '{"jsonrpc":"2.0","method":"Test method","params":{"foo":"bar"},"id":"123"}',
            $method->toJson()
        );
    }

    public function test_method_can_be_presented_as_string()
    {
        $method = new Method('2.0', 'Test method', ['foo' => 'bar'], '123');

        $this->assertEquals(
            '{"jsonrpc":"2.0","method":"Test method","params":{"foo":"bar"},"id":"123"}',
            (string) $method
        );
    }

    public function test_method_can_create_successful_response()
    {
        $method = new Method('2.0', 'Test method', ['foo' => 'bar'], '123');

        $response = $method->createResponse([1, 2, 3]);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('2.0', $response->getVersion());
        $this->assertEquals([1, 2, 3], $response->getResult());
        $this->assertEquals(123, $response->getId());
    }
}
