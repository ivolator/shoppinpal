<?php
namespace bookstore\services;
use PHPUnit\Framework\TestCase;
require_once $SRC_ROOT . 'src/bookstore/services/JsonOutput.php';

final class TestJsonOutput extends TestCase
{
    public function testReturnsJson() : void {
        $jsonOutput = new JsonOutput();
        $expected = '{"id":1,"name":"Name"}';
        $testObject = new TestClass();
        $testObject->id = 1;
        $testObject->name = 'Name';

        $this->assertSame($jsonOutput->convertToJson($testObject), $expected);
    }

    public function testThrowsInternalServerError() : void {
        $jsonOutput = new JsonOutput();
        $expected = '{"id":}';
        $testObject = new TestClass();
        $testObject->id = 1;
        $testObject->name = 'Name';
        try{
            $jsonOutput->convertToJson($testObject);
        } catch (\Exception $actualException) {
            $this->assertInstanceOf('bookstore\exceptions\Exception500',$actualException);
        }
    }
}

class TestClass {
    public int $id;
    public string $name;
}