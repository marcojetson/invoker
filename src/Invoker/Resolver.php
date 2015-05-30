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
interface Resolver
{
    /**
     * @param mixed $callable
     * @return callable
     */
    public function getCallable($callable);

    /**
     * @param callable $callable
     * @param array $values
     * @return array
     */
    public function getArguments(callable $callable, array $values);
}
