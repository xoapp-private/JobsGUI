<?php

declare(strict_types=1);

namespace xoapp\jobs\library\muqsit\invmenu\type\util\builder;

use xoapp\jobs\library\muqsit\invmenu\type\InvMenuType;

interface InvMenuTypeBuilder{

	public function build() : InvMenuType;
}