<?php

use PHPUnit\Framework\TestCase;
use Rees\JsonRpc\Hydrators\SymfonyHydrator;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SymfonyHydratorTest
 */
class SymfonyHydratorTest extends TestCase
{
    public function test_hydrator_can_be_created()
    {
        $hydrator = new SymfonyHydrator($this->createSingleRequest());
        $this->assertInstanceOf(SymfonyHydrator::class, $hydrator);
    }

    public function test_hydrator_can_hydrate_rpc_request()
    {
        $hydrator = new SymfonyHydrator($this->createSingleRequest());
        $request = $hydrator->hydrate();
        $this->assertInstanceOf(\Rees\JsonRpc\Request::class, $request);
    }

    public function test_response_contains_methods()
    {
        $hydrator = new SymfonyHydrator($this->createSingleRequest());
        $request = $hydrator->hydrate();
        $this->assertCount(1, $request->getMethods());

        $hydrator = new SymfonyHydrator($this->createBatchRequest());
        $request = $hydrator->hydrate();
        $this->assertCount(3, $request->getMethods());
    }

    public function test_response_methods_contain_valid_properties()
    {
        $hydrator = new SymfonyHydrator($this->createSingleRequest());
        $request = $hydrator->hydrate();
        $method = $request->getMethods()[0];
        $this->assertEquals('2.0', $method->getVersion());
        $this->assertEquals('test.method', $method->getName());
        $this->assertEquals([1, 2, 3], $method->getParameters());
        $this->assertEquals('123', $method->getId());

        $hydrator = new SymfonyHydrator($this->createSingleRequest());
        $request = $hydrator->hydrate();
        $methods = $request->getMethods();
        foreach ($methods as $method) {
            $this->assertEquals('2.0', $method->getVersion());
            $this->assertEquals('test.method', $method->getName());
            $this->assertEquals([1, 2, 3], $method->getParameters());
            $this->assertEquals('123', $method->getId());
        }
    }

    protected function createSingleRequest()
    {
        return new Request([], [], [], [], [], [],
            '{"jsonrpc":"2.0","method":"test.method","params":[1,2,3],"id":"123"}'
        );
    }

    protected function createBatchRequest()
    {
        return new Request([], [], [], [], [], [],
            '[{"jsonrpc":"2.0","method":"test.method","params":[1,2,3],"id":"123"},{"jsonrpc":"2.0"'.
            ',"method":"test.method","params":[1,2,3],"id":"123"},{"jsonrpc":"2.0","method":'.
            '"test.method","params":[1,2,3],"id":"123"}]'
        );
    }
}
