<?php
/*
 * This file is part of the Invoker package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Invoker;

/**
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 */
class DefaultResolver implements Resolver
{
    /**
     * @param mixed $callable
     * @return callable
     */
    public function getCallable($callable)
    {
        if (is_string($callable) && strpos($callable, '::') !== false) {
            list($class, $method) = explode('::', $callable);
            
            return [new $class, $method];
        }
        
        if (is_callable($callable)) {
            return $callable;
        }
        
        if (method_exists($callable, '__invoke')) {
            return new $callable();
        }
        
        throw new \InvalidArgumentException();
    }

    /**
     * @param callable $callable
     * @param array $values
     * @return array
     */
    public function getArguments(callable $callable, array $values)
    {
        $reflected = $this->getReflected($callable);

        $arguments = [];
        foreach ($reflected->getParameters() as $parameter) {
            if (isset($values[$parameter->getName()])) {
                $arguments[] = $values[$parameter->getName()];
            } elseif ($parameter->isDefaultValueAvailable()) {
                $arguments[] = $parameter->getDefaultValue();
            } else {
                $arguments[] = null;
            }
        }

        return $arguments;
    }
    
    /**
     * @param callable $callable
     * @return \ReflectionFunctionAbstract
     */
    private function getReflected(callable $callable)
    {
        if (is_array($callable)) {
            return new \ReflectionMethod($callable[0], $callable[1]);
        }

        if (is_object($callable) && !$callable instanceof \Closure) {
            return (new \ReflectionObject($callable))->getMethod('__invoke');
        }

        return new \ReflectionFunction($callable);
    }
}
