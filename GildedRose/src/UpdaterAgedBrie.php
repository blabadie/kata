<?php


namespace GildedRose;


class UpdaterAgedBrie extends Updater
{
    protected static UpdaterInterface $instance;

    public function updateQuality(Item $item)
    {
        $offset = $item->sellIn >= 0 ? 1 : 2;
        if ($item->quality+$offset <= 50) {
            $item->quality = $item->quality + ($offset);
        } else {
            $item->quality=50;
        }
    }
}