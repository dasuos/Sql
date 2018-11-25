<?php
declare(strict_types = 1);

namespace Dasuos\Sql;

interface Statement {

	public function sql(): string;
}