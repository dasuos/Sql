<?php
declare(strict_types = 1);

namespace Dasuos\Sql;

interface Clause {

	public function sql(): string;
}