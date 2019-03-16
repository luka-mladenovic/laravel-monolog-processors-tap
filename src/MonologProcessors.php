<?php
namespace MonologTap;

class MonologProcessors
{
    /**
     * Customize the given logger instance.
     *
     * @param \Illuminate\Log\Logger $logger
     * @param array                  $processors
     *
     * @return void
     */
    public function __invoke($logger, ...$processors)
    {
        $processors = $this->resolveProcessors($processors);

        foreach ($logger->getHandlers() as $handler) {
            foreach ($processors as $processor) {
                $handler->pushProcessor($processor);
            }
        }
    }

    /**
     * Resolve monolog processors class names.
     *
     * @param array $processors
     *
     * @return array
     */
    protected function resolveProcessors($processors)
    {
        return collect($processors)->filter()->map(function ($name) {
            return $this->createClass($this->getName($name));
        })->toArray();
    }

    /**
     * Create new class instance for
     * given monolog processor name.
     *
     * @param string $name
     *
     * @return object
     */
    protected function createClass($name)
    {
        if (!class_exists($class = $this->getMonologClass($name))) {
            throw new \InvalidArgumentException("Processor [{$name}] is not defined.");
        }

        return app()->make($class);
    }

    /**
     * Get processors class name.
     *
     * @param string $name
     *
     * @return string
     */
    protected function getName($name)
    {
        return ucfirst(camel_case($name . 'Processor'));
    }

    /**
     * Get fully qualified monolog class name.
     *
     * @param string $name
     *
     * @return string
     */
    protected function getMonologClass($name)
    {
        return '\\Monolog\\Processor\\' . $name;
    }
}
