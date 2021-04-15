<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Item;
use GildedRose\Updater;
use GildedRose\UpdaterAgedBrie;
use GildedRose\UpdaterBackstage;
use GildedRose\UpdaterConjured;
use GildedRose\UpdaterFactory;
use GildedRose\UpdaterSulfuras;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    public function testFoo(): void
    {
        $items = [new Item('foo', 0, 0)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame('foo', $items[0]->name);
    }

    public function testRandomItem(): void
    {
        $items = [new Item('foo', 10, 20)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(9, $items[0]->sellIn);
        $this->assertSame(19, $items[0]->quality);
    }

    public function testQualityNotNegative(): void
    {
        $items = [new Item('foo', 5, 10)];
        $gildedRose = new GildedRose($items);
        for($i=0;$i<10;$i++) {
            $gildedRose->updateQuality();
        }
        $this->assertSame(-5, $items[0]->sellIn);
        $this->assertSame(0, $items[0]->quality);
    }

    public function testQualityNotOver50(): void
    {
        $items = [
            new Item('Aged Brie', 5, 45),
            new Item('Backstage passes', 10, 45)
        ];
        $gildedRose = new GildedRose($items);
        for($i=0;$i<10;$i++) {
            $gildedRose->updateQuality();
        }
        $this->assertSame(-5, $items[0]->sellIn);
        $this->assertSame(50, $items[0]->quality);
        $this->assertSame(0, $items[1]->sellIn);
        $this->assertSame(50, $items[1]->quality);
    }

    public function testQualityAfterDate(): void
    {
        $items = [new Item('foo', 1, 10)];
        $gildedRose = new GildedRose($items);

        $gildedRose->updateQuality();
        $this->assertSame(0, $items[0]->sellIn);
        $this->assertSame(9, $items[0]->quality);

        $gildedRose->updateQuality();
        $this->assertSame(-1, $items[0]->sellIn);
        $this->assertSame(7, $items[0]->quality);
    }

    public function testAgedBrie(): void
    {
        $items = [new Item('Aged Brie', 1, 10)];
        $gildedRose = new GildedRose($items);

        $gildedRose->updateQuality();
        $this->assertSame(0, $items[0]->sellIn);
        $this->assertSame(11, $items[0]->quality);

        $gildedRose->updateQuality();
        $this->assertSame(-1, $items[0]->sellIn);
        $this->assertSame(13, $items[0]->quality);
    }

    public function testSulfuras(): void
    {
        $items = [new Item('Sulfuras, Hand of Ragnaros', 0, 80)];
        $gildedRose = new GildedRose($items);
        for($i=0;$i<30;$i++) {
            $gildedRose->updateQuality();
        }
        $this->assertSame(0, $items[0]->sellIn);
        $this->assertSame(80, $items[0]->quality);
    }

    public function testBackstage(): void
    {
        $items = [new Item('Backstage passes', 20, 5)];
        $gildedRose = new GildedRose($items);
        for($i=0;$i<10;$i++) {
            $gildedRose->updateQuality();
        }
        $this->assertSame(10, $items[0]->sellIn);
        $this->assertSame(15, $items[0]->quality);

        for($i=0;$i<5;$i++) {
            $gildedRose->updateQuality();
        }
        $this->assertSame(5, $items[0]->sellIn);
        $this->assertSame(25, $items[0]->quality);

        for($i=0;$i<5;$i++) {
            $gildedRose->updateQuality();
        }
        $this->assertSame(0, $items[0]->sellIn);
        $this->assertSame(40, $items[0]->quality);

        $gildedRose->updateQuality();
        $this->assertSame(-1, $items[0]->sellIn);
        $this->assertSame(0, $items[0]->quality);
    }

    public function testConjured(): void
    {
        $items = [new Item('Conjured truc machin', 20, 20)];
        $gildedRose = new GildedRose($items);

        for($i=0;$i<5;$i++) {
            $gildedRose->updateQuality();
        }
        $this->assertSame(15, $items[0]->sellIn);
        $this->assertSame(10, $items[0]->quality);
    }

    public function testFactory(): void
    {
        $items = [];
        $items = [
            new Item('Un truc', 5, 45),
            new Item('Aged Brie', 5, 45),
            new Item('Sulfuras, Hand of Ragnaros', 5, 45),
            new Item('Backstage passes', 10, 45),
            new Item('Conjured truc machin', 20, 20)
        ];
        $this->assertInstanceOf(Updater::class, UpdaterFactory::getUpdater($items[0]));
        $this->assertInstanceOf(UpdaterAgedBrie::class, UpdaterFactory::getUpdater($items[1]));
        $this->assertInstanceOf(UpdaterSulfuras::class, UpdaterFactory::getUpdater($items[2]));
        $this->assertInstanceOf(UpdaterBackstage::class, UpdaterFactory::getUpdater($items[3]));
        $this->assertInstanceOf(UpdaterConjured::class, UpdaterFactory::getUpdater($items[4]));
    }
}
