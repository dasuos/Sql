<?php
declare(strict_types = 1);

namespace Dasuos\Sql;

interface Select extends Statement {

	public function from(From $table): Select;
	public function where(Where $where): Select;
}