<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Models;

class FileModel extends FileSystemModel
{
    const TYPE_INTERFACE = 'interface';
    const TYPE_ABSTRACT = 'abstract';
    const TYPE_CLASS = 'class';
    const TYPE_LIST = [self::TYPE_INTERFACE, self::TYPE_ABSTRACT];

    /**
     * @var string
     */
    public string $type = '';

    /**
     * @var string
     */
    public string $nameSpace;

    /**
     * @param string $name
     * @param string $nameSpace
     */
    public function __construct(string $name, string $nameSpace = '')
    {
        parent::__construct($name);
        $this->nameSpace = $nameSpace;
        $this->determinedType();
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return bool
     */
    public function isAbstract(): bool
    {
        return 'abstract' === strtolower($this->type);
    }

    /**
     * @return void
     */
    public function setTypeAbstract(): void
    {
        $this->setType(self::TYPE_ABSTRACT);
    }

    /**
     * @return bool
     */
    public function isClass(): bool
    {
        return 'class' === strtolower($this->type);
    }

    /**
     * @return void
     */
    public function setTypeCLass(): void
    {
        $this->setType(self::TYPE_CLASS);
    }

    /**
     * @return bool
     */
    public function isInterface(): bool
    {
        return 'interface' === strtolower($this->type);
    }

    /**
     * @return void
     */
    public function setTypeInterface(): void
    {
        $this->setType(self::TYPE_INTERFACE);
    }

    /**
     * @return void
     */
    private function determinedType(): void
    {
        foreach (self::TYPE_LIST as $type) {
            if (str_contains(strtolower($this->getName()), $type)) {
                $this->setType($type);
            } else {
                $this->setTypeCLass();
            }
        }
    }
}
