<?php

namespace Numbers\Application;

use RuntimeException;

/**
 * Simple dependency injections container
 */
class Container
{
    private $service = [];
    private $instance = [];
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function set(string $name, callable $factory)
    {
        $this->service[$name] = $factory;
    }

    public function get(string $name)
    {
        if (false == isset($this->instance[$name])) {
            if (false == isset($this->service[$name])) {
                throw new RuntimeException("Unknown service: {$name}");
            }
            $this->instance[$name] = $this->service[$name]($this);
        }

        return $this->instance[$name];
    }

    public function cfg(string $optName)
    {
        return $this->config[$optName] ?? null;
    }
}
