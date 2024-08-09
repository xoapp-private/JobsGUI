<?php

declare(strict_types=1);

namespace xoapp\jobs\library\muqsit\invmenu\session\network\handler;

use Closure;
use xoapp\jobs\library\muqsit\invmenu\session\network\NetworkStackLatencyEntry;

interface PlayerNetworkHandler{

	public function createNetworkStackLatencyEntry(Closure $then) : NetworkStackLatencyEntry;
}