<?php
declare(strict_types = 1);

namespace Dasuos\Sql;

interface Update extends Statement {

	public function set(array $values): Update;
	public function where(Where $where): Update;
}