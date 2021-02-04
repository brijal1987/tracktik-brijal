<?php
namespace Backend\Classes;

/**
 * Console Class
 * @author Brijal Savaliya <brijal.savaliya@gmail.com>
 * @created on 3rd February 2021
 */
class Console extends Base\ElectronicItem
{
	public function __construct()
	{
		$this->type = parent::ELECTRONIC_ITEM_CONSOLE;
		$this->isWired = true;
		$this->isWireless = true;
	}

	/**
	 * Limits the number of extras an Console item can have.
	 * @return int Max number of extras or 0 for no extra
	 */
	public function maxExtras()
	{
        // The console can have a maximum of 4 extras
		return 4;
	}
}