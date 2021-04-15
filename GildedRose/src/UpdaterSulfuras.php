<?php


namespace GildedRose;


class UpdaterSulfuras extends Updater
{
    protected static UpdaterInterface $instance;

    protected function updateQuality(Item $item)
    {
        $item->quality = 80;
    }

    protected function updateAge(Item $item)
    {

    }
}