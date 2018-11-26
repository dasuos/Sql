<?php
declare(strict_types = 1);

namespace Dasuos\Sql;

interface Parameters {

	public function values(): array;
}