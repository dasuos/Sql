<?php
declare(strict_types = 1);

namespace Dasuos\Sql;

interface Insert extends Statement {

	public function columns(string ...$columns): Insert;
	public function values(array ...$values): Insert;
}