<?php
/**
 * Unit testing.
 * @author Brijal Savaliya <brijal.savaliyar@gmail.com>
 * @created on 4th February 2021
 */
use \Backend\Classes\Base\ElectronicItems;
use \Backend\Classes\Base\ElectronicItem;
use \Backend\Classes\Controller;
use \Backend\Classes\Console;
use \Backend\Classes\Television;
use \Backend\Classes\Microwave;
use PHPUnit\Framework\TestCase;

class ElectronicItemsTest extends TestCase
{
	static $items;

	/**
	 * Scenario in the Question 1.
	 * Setup all the default items
	 */
	public static function setUpBeforeClass(): void
	{
		$items = new ElectronicItems();
		self::$items = $items->setUpDefaultItems();
	}

	/**
	 * Question 1.
	 * Sort the items by price
	 */
	public function testSortItemsByPrice()
	{
		//Check sorted array with reverse of original array
		$this->assertSame(self::$items->getSortedItemsByPrice('desc'), array_reverse(self::$items->getSortedItemsByPrice()));
	}

	/**
	 * Question 1.
	 * The total pricing.
	 */
	public function testTotalPriceOfAllItems()
	{
		$this->assertSame(579.89, self::$items->getTotalPrice());
	}

	/**
	 * Answer to the question 2.
	 * That person's friend saw her with her new purchase and asked her how much the
	 * console and its controllers had cost her. Give the answer.
	 */
	public function testGetOnlyConsoleItems()
	{
		$items = self::$items->getItemsByType(ElectronicItem::ELECTRONIC_ITEM_CONSOLE);
		$this->assertSame(99.99, $items[0]->getPrice());
		$this->assertSame(19.96, $items[0]->getExtrasPrice());
	}
}
