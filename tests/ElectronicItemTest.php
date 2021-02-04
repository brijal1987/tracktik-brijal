<?php
/**
 * Unit testing.
 * @author Brijal Savaliya <brijal.savaliyar@gmail.com>
 * @created on 4th February 2021
 */
use \Backend\Classes\Base\ElectronicItem;
use \Backend\Classes\Controller;
use \Backend\Classes\Console;
use \Backend\Classes\Television;
use \Backend\Classes\Microwave;

class ElectronicItemTest extends PHPUnit\Framework\TestCase
{
	// Test adding Console items
	public function testConsoleItemInsertion()
	{
		$item = new Console();
		$this->assertSame(ElectronicItem::ELECTRONIC_ITEM_CONSOLE, $item->getType());

		$consolePrice =  199.99;
		$item->setPrice($consolePrice);
		// Test Set - setPrice() and Get - getPrice()
		$this->assertSame($consolePrice, $item->getPrice());
		$extraPrice = 1.99;
		for ($i=0; $i < $item->maxExtras(); ++$i)
		{
			$extra = new Controller();
			$extra->setWired(true);
			$extra->setPrice($extraPrice);
			$item->addExtra($extra);
		}
		// Check getExtrasPrice()
		$this->assertSame($extraPrice * 4, $item->getExtrasPrice());

		// Check getExtras()
		$this->assertSame($item->maxExtras(), count($item->getExtras()));

		// Check getExtrasCount()
		$this->assertSame($item->maxExtras(), $item->getExtrasCount());

		// The console can have a maximum of 4 extras
		$this->expectException(Exception::class);
		$extra = new Controller();
		$item->addExtra($extra);
	}

	// Test adding Television items
	public function testTelevisionItemInsertion()
	{
		$item = new Television();
		$this->assertSame(ElectronicItem::ELECTRONIC_ITEM_TELEVISION, $item->getType());

		$televisionPrice = 299.99;
		$item->setPrice($televisionPrice);
		$this->assertSame($televisionPrice, $item->getPrice());

		$extra = new Controller();
		$extra->setWired(false);
		$item->addExtra($extra);

		$this->expectException(Exception::class);
		$extra = new Controller();
		$extra->setWired(true);
		$item->addExtra($extra);
	}

	// Test adding Microwave items
	public function testMicrowaveItemInsertion()
	{
		$item = new Microwave();
		$this->assertSame(ElectronicItem::ELECTRONIC_ITEM_MICROWAVE, $item->getType());

		$microwavePrice = 299.99;
		$item->setPrice($microwavePrice);
		$this->assertSame($microwavePrice, $item->getPrice());

		// The microwave can't have any extras
		$this->expectException(Exception::class);
		$extra = new Controller();
		$extra->setWired(true);
		$item->addExtra($extra);
	}
}