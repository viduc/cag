<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Spec\Implentation\Containers;

use Cag\Adapters\FileServiceInterface;
use Cag\Containers\ContainerInterface;
use Cag\Exceptions\ContainerException;
use Cag\Exceptions\NotFoundException;
use Spec\Implentation\Service\FileServiceImp;

class Container implements ContainerInterface
{
    private FileServiceInterface $file;

    public function get(string $id)
    {
        if ($this->has($id)) {
            if (null === $this->$id) {
                $this->instancierService($id);
            }

            return $this->$id;
        }

        throw new NotFoundException(
            "No entry found for ".$id." indenntifier"
        );
    }

    public function has(string $id): bool
    {
        return isset($this->$id);
    }

    private function instancierService(string $service): void
    {
        try {
            switch (strtolower($service)) {
                case 'file':
                    $this->file = new FileServiceImp();
                    break;
            }
        } catch (\Exception $exception) {
            throw new ContainerException(
                'Error when trying to load '.$service.' class'
            );
        }
    }
}