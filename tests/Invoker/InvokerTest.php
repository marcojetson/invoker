<?php
/*
 * This file is part of the Invoker package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Invoker;

class InvokerTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $invoker = new Invoker();
        $this->assertInstanceOf('Invoker\Invoker', $invoker);
    }
    
    public function testCreateWithResolver()
    {
        $resolver = $this->getMock('Invoker\Resolver');
        $invoker = new Invoker($resolver);
        $this->assertInstanceOf('Invoker\Invoker', $invoker);
    }
    
    public function testInvoke()
    {
        $invoker = new Invoker();
        $result = $invoker->invoke(function () {
            return 'result';
        });
        
        $this->assertSame('result', $result);
    }
    
    public function testInvokeWithArguments()
    {
        $invoker = new Invoker();
        $result = $invoker->invoke(function ($a) {
            return 'result';
        }, ['a' => 'value1']);
        
        $this->assertSame('result', $result);
    }
}
