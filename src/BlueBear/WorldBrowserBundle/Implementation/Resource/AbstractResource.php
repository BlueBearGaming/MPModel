<?php

namespace BlueBear\WorldBrowserBundle\Implementation\Resource;

use BlueBear\WorldBrowserBundle\Game\Exception\InsufficientResourceException;
use BlueBear\WorldBrowserBundle\Game\Map\CellInterface;
use BlueBear\WorldBrowserBundle\Game\Resource\ResourceExtractionInterface;
use BlueBear\WorldBrowserBundle\Game\Resource\ResourceInterface;
use BlueBear\WorldBrowserBundle\Game\Storage\StorageManagerInterface;

/**
 * Base implementation for resources
 */
abstract class AbstractResource implements ResourceInterface
{
    /** @var StorageManagerInterface */
    protected $storageManager;

    /** @var string|ResourceExtractionInterface */
    protected $resourceExtractionClass;

    /**
     * @param StorageManagerInterface $storageManager
     * @param string                  $resourceExtractionClass
     */
    public function __construct(StorageManagerInterface $storageManager, string $resourceExtractionClass)
    {
        $this->storageManager = $storageManager;
        $this->resourceExtractionClass = $resourceExtractionClass;
    }

    /**
     * Unique code identifying the resource
     *
     * @throws \ReflectionException
     *
     * @return string
     */
    public function getCode(): string
    {
        return (new \ReflectionClass($this))->getShortName();
    }

    /**
     * @param CellInterface $cell
     * @param int           $quantity
     *
     * @throws \BlueBear\WorldBrowserBundle\Game\Exception\InsufficientResourceException
     */
    public function extract(CellInterface $cell, int $quantity): void
    {
        if ($this->getAvailableQuantity($cell) < $quantity) {
            throw InsufficientResourceException::create($this, $cell, $quantity);
        }

        $extraction = $this->resourceExtractionClass::create($this, $cell, $quantity);

        $this->storageManager->addElement($this->resourceExtractionClass, $cell, $extraction);
    }

    /**
     * Give the available quantity at a given round
     *
     * @param CellInterface $cell
     *
     * @return int
     */
    public function getAvailableQuantity(CellInterface $cell): int
    {
        /** @var ResourceExtractionInterface[] $extractedResources */
        $extractedResources = $this->storageManager->getElements($this->resourceExtractionClass, $cell);
        $extractedQuantity = 0;
        foreach ($extractedResources as $extractedResource) {
            if ($extractedResource->getResource() === $this) {
                $extractedQuantity += $extractedResource->getQuantity();
            }
        }

        return $this->getInitialQuantity($cell) - $extractedQuantity;
    }

    /**
     * @param CellInterface $cell
     *
     * @return int
     */
    abstract protected function getInitialQuantity(CellInterface $cell): int;
}
