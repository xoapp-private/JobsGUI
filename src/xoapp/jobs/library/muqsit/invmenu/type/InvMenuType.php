<?php

declare(strict_types=1);

namespace xoapp\jobs\library\muqsit\invmenu\type;

use pocketmine\inventory\Inventory;
use pocketmine\player\Player;
use xoapp\jobs\library\muqsit\invmenu\InvMenu;
use xoapp\jobs\library\muqsit\invmenu\type\graphic\InvMenuGraphic;

interface InvMenuType{

	public function createGraphic(InvMenu $menu, Player $player) : ?InvMenuGraphic;

	public function createInventory() : Inventory;
}