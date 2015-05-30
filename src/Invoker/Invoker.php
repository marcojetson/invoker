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
class Invoker
{
    /** @var Resolver */
    private $resolver;

    public function __construct(Resolver $resolver = null)
    {
        $this->resolver = $resolver ? : new DefaultResolver();
    }

    /**
     * @param mixed $callable
     * @param array $arguments
     */
    public function invoke($callable, array $arguments = [])
    {
        $callable = $this->resolver->getCallable($callable);
        $arguments = $this->resolver->getArguments($callable, $arguments);

        return $callable(...$arguments);
    }
}
