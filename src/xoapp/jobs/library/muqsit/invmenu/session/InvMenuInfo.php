<?php

declare(strict_types=1);

namespace xoapp\jobs\library\muqsit\invmenu\session;

use xoapp\jobs\library\muqsit\invmenu\InvMenu;
use xoapp\jobs\library\muqsit\invmenu\type\graphic\InvMenuGraphic;

final class InvMenuInfo{

	public function __construct(
		readonly public InvMenu $menu,
		readonly public InvMenuGraphic $graphic,
		readonly public ?string $graphic_name
	){}
}