<?php
/*
 * This file is part of the Invoker package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Invoker;

class DefaultResolverTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $resolver = new DefaultResolver();
        $this->assertInstanceOf('Invoker\DefaultResolver', $resolver);
        $this->assertInstanceOf('Invoker\Resolver', $resolver);
    }
    
    public function testGetCallableCallable()
    {
        $resolver = new DefaultResolver();
        $callable = function () {};
        $this->assertSame($callable, $resolver->getCallable($callable));
    }
    
    public function testGetCallableClass()
    {
        $resolver = new DefaultResolver();
        $this->assertInstanceOf('Invoker\Object', $resolver->getCallable('Invoker\Object'));
    }
    
    public function testGetCallableMethod()
    {
        $resolver = new DefaultResolver();
        $callable = $resolver->getCallable('Invoker\DefaultResolverTest::testGetCallableMethod');
        $this->assertEquals([new self(), 'testGetCallableMethod'], $callable);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetCallableUnknown()
    {
        $resolver = new DefaultResolver();
        $resolver->getCallable(null);
    }
    
    public function testGetArguments()
    {
        $resolver = new DefaultResolver();
        $arguments = $resolver->getArguments(function ($a, $b) {}, [
            'a' => 'value1',
            'b' => 'value2',
        ]);
        
        $this->assertSame(['value1', 'value2'], $arguments);
    }
    
    public function testGetArgumentsLessValues()
    {
        $resolver = new DefaultResolver();
        $arguments = $resolver->getArguments(function ($a, $b) {}, [
            'a' => 'value1',
        ]);
        
        $this->assertSame(['value1', null], $arguments);
    }
    
    public function testGetArgumentsMoreValues()
    {
        $resolver = new DefaultResolver();
        $arguments = $resolver->getArguments(function ($a, $b) {}, [
            'a' => 'value1',
            'b' => 'value2',
            'c' => 'value3',
        ]);
        
        $this->assertSame(['value1', 'value2'], $arguments);
    }
    
    public function testGetArgumentsWithDefault()
    {
        $resolver = new DefaultResolver();
        $arguments = $resolver->getArguments(function ($a, $b = 'value2') {}, [
            'a' => 'value1',
        ]);
        
        $this->assertSame(['value1', 'value2'], $arguments);
    }
    
    public function testGetArgumentsObject()
    {
        $resolver = new DefaultResolver();
        $arguments = $resolver->getArguments(new Object(), [
            'a' => 'value1',
        ]);
        
        $this->assertSame(['value1'], $arguments);
    }
    
    public function testGetArgumentsMethod()
    {
        $resolver = new DefaultResolver();
        $arguments = $resolver->getArguments([new Object(), '__invoke'], [
            'a' => 'value1',
        ]);
        
        $this->assertSame(['value1'], $arguments);
    }
    
    /**
     * @expectedException \PHPUnit_Framework_Error
     */
    public function testGetArgumentsUnknown()
    {
        $resolver = new DefaultResolver();
        $resolver->getArguments(null, []);
    }
}

class Object
{
    public function __invoke($a)
    {
    }
}
