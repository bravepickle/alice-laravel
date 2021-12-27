<?php

namespace BravePickle\AliceLaravel\Loader;

use Nelmio\Alice;
use Nelmio\Alice\ObjectSet;
use Nelmio\Alice\Throwable\LoadingThrowable;

class ModelLoader implements Alice\FilesLoaderInterface, Alice\FileLoaderInterface, Alice\DataLoaderInterface
{
    /**
     * Define common parameters for loaders to pass all the time. Can be overridden by redefining them in loader
     * methods
     */
    public const CONTEXT_PARAMETERS = 'parameters';

    /**
     * @var Alice\Loader\NativeLoader
     */
    protected $loader;

    /**
     * Context to use for given loader. It modifies basic loaders logic
     * @var array
     */
    protected $context = [];

    /**
     * @param  Alice\Loader\NativeLoader|null  $loader
     */
    public function __construct(?Alice\Loader\NativeLoader $loader = null)
    {
        $this->loader = $loader ?? new Alice\Loader\NativeLoader();
    }

    /**
     * @param  array  $files
     * @param  array  $parameters
     * @param  array  $objects
     * @return ObjectSet
     * @throws LoadingThrowable
     */
    public function loadFiles(array $files, array $parameters = [], array $objects = []): ObjectSet
    {
        return $this->loader->loadFiles($files, $this->mergeParameters($parameters), $objects);
    }

    /**
     * @param  string  $file
     * @param  array  $parameters
     * @param  array  $objects
     * @return ObjectSet
     * @throws LoadingThrowable
     */
    public function loadFile(string $file, array $parameters = [], array $objects = []): ObjectSet
    {
        return $this->loader->loadFile($file, $this->mergeParameters($parameters), $objects);
    }

    /**
     * @param  array  $data
     * @param  array  $parameters
     * @param  array  $objects
     * @return ObjectSet
     * @throws LoadingThrowable
     */
    public function loadData(array $data, array $parameters = [], array $objects = []): ObjectSet
    {
        return $this->loader->loadData($data, $this->mergeParameters($parameters), $objects);
    }

    /**
     * Define context for loaders
     *
     * @param  array  $context
     * @return $this
     */
    public function withContext(array $context): self
    {
        $this->context = $context;

        return $this;
    }

    /**
     * Read current context for loaders
     *
     * @return array
     */
    public function getContext(): array
    {
        return $this->context;
    }

    protected function mergeParameters(array $parameters): array
    {
        if (!isset($this->context[self::CONTEXT_PARAMETERS])) {
            return $parameters;
        }

        return array_merge($this->context[self::CONTEXT_PARAMETERS], $parameters);
    }
}
