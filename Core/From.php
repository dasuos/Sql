<?php
declare(strict_types = 1);

namespace Dasuos\Sql;

interface From extends Clause {

	public function join(Join ...$join): From;
}