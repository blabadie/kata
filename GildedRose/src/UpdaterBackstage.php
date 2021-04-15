<?php


namespace GildedRose;


class UpdaterBackstage extends Updater
{
    protected static UpdaterInterface $instance;

    protected function updateQuality(Item $item)
    {
        $offset = 1;
        if ($item->sellIn < 10) {
            $offset = 2;
        }
        if ($item->sellIn < 5) {
            $offset = 3;
        }

        if($item->sellIn >= 0) {
            if ($item->quality+$offset <= 50) {
                $item->quality = $item->quality + $offset;
            } else {
                $item->quality=50;
            }
        } else {
            $item->quality = 0;
        }
    }
}