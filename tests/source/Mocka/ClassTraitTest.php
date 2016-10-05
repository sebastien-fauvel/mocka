<?php

namespace MockaTests\Mocka;

use Mocka\ClassMock;
use \Mocka\Mocka;

class ClassTraitTest extends \PHPUnit_Framework_TestCase {

    public function testMockClass() {
        $mocka = new Mocka();
        $mockClass = $mocka->mockClass('\MockaMocks\AbstractClass');
        $this->assertInstanceOf('\\Mocka\\ClassMock', $mockClass);
    }

    public function testMockInterface() {
        $mocka = new Mocka();
        $mockClass = $mocka->mockInterface('\MockaMocks\InterfaceMock');
        $this->assertInstanceOf('\\Mocka\\ClassMock', $mockClass);
    }

    public function testCallMockedMethod() {
        $mocka = new Mocka();
        $mockClass = $mocka->mockClass('\MockaMocks\AbstractClass');
        /** @var \MockaMocks\AbstractClass|\Mocka\ClassMockTrait $object */
        $object = $mockClass->newInstanceWithoutConstructor();
        $this->assertNull($object->foo());
        $this->assertSame('bar', $object->bar());

        $mockClass->mockMethod('foo')->set(function () {
            return 'foo';
        });
        $this->assertSame('foo', $object->foo());

        $object->mockMethod('foo')->set(function () {
            return 'bar';
        });
        $this->assertSame('bar', $object->foo());

        $objectAnother = $mockClass->newInstanceWithoutConstructor();
        $this->assertSame('foo', $objectAnother->foo());

        $mockClass->mockMethod('foo')->set(function () {
            return 'zoo';
        });
        $this->assertSame('bar', $object->foo());
    }
}
