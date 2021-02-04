<?php
namespace Backend\Classes;

/**
 * Microwave Class
 * @author Brijal Savaliya <brijal.savaliya@gmail.com>
 * @created on 3rd February 2021
 */
class Microwave extends Base\ElectronicItem
{
	public function __construct()
	{
		$this->type = parent::ELECTRONIC_ITEM_MICROWAVE;
		$this->isWired = false;
		$this->isWireless = false;
	}

	/**
	 * Limits the number of extras an Mocrowave item can have.
	 * @return int Max number of extras or 0 for no extra
	 */
	public function maxExtras()
	{
        // The microwave can't have any extras
		return 0;
	}
}