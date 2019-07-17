<?php

namespace Numbers;

use RuntimeException;

/**
 * Simple dependency injections container
 */
class DiContainer
{
    private $service = [];
    private $instance = [];
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function set(string $name, callable $factory): void
    {
        $this->service[$name] = $factory;
    }

    /**
     * @param string $name
     * @return mixed
     */
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

    /**
     * @param string $optName
     * @return mixed|null
     */
    public function cfg(string $optName)
    {
        return $this->config[$optName] ?? null;
    }
}
