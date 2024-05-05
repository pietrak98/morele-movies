<?php

namespace App\Shared\Loader\Application;

use App\Shared\Loader\Domain\Repository\LoaderRepositoryInterface;

readonly class LoaderService
{
    public function __construct(
        private LoaderRepositoryInterface $loaderRepository
    ) {
    }

    public function load()
    {
        $loader = $this->loaderRepository->find();
        $source = $loader->getSource();
        // Handle different types of sources, e.g., file, database, XML, etc.
        if (is_string($source) && file_exists($source)) {
            return require $source;
        }

        if ($source instanceof \PDO) {
            // Handle database loading
        } elseif ($source instanceof \SimpleXMLElement) {
            // Handle XML loading
        } else {
            throw new \Exception('Unsupported source type');
        }

        return null;
    }
}
