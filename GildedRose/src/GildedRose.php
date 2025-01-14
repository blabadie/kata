<?php

declare(strict_types=1);

namespace GildedRose;

final class GildedRose
{
    /** @var Item[] */
    private array $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            UpdaterFactory::getUpdater($item)->update($item);
        }
    }
}
