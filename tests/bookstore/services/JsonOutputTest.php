<?php

namespace bookstore\services;

use PHPUnit\Framework\TestCase;

class JsonOutputTest extends TestCase
{

    /**
     * @throws \Exception
     */
    public function testReturnsJson(): void
    {
        $jsonOutput = new JsonOutput();
        $expected = '{"id":1,"name":"Name"}';
        $testObject = new TestClass();
        $testObject->id = 1;
        $testObject->name = 'Name';

        $this->assertSame($jsonOutput->convertToJson($testObject), $expected);
    }

    /**
     * Make it fail
     */
    public function testThrowsInternalServerError(): void
    {
        $jsonOutput = new JsonOutput();
        $testObject = fopen(__DIR__ . '/testfile', 'r');
        try {
            //fails to encode resources
            $jsonOutput->convertToJson($testObject);
        } catch (\Exception $actualException) {
            $this->assertInstanceOf('bookstore\exceptions\Exception500', $actualException);
        }
    }
}

class TestClass
{
    public int $id;
    public string $name;
}