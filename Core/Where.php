<?php
declare(strict_types = 1);

namespace Dasuos\Sql;

interface Where extends Clause {

	public function and(string $condition): Where;
	public function or(string $condition): Where;
}