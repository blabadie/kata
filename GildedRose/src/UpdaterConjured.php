<?php


namespace GildedRose;


class UpdaterConjured extends Updater
{
    protected static UpdaterInterface $instance;

    protected function updateQuality(Item $item)
    {
        if ($item->quality > 0) {
            $item->quality = $item->quality - ($item->sellIn >= 0 ? 2 : 4);
        } else {
            $item->quality = 0;
        }
    }
}