<?php
declare(strict_types = 1);

namespace Dasuos\Sql;

interface Join extends Clause {

	public function inner(): Join;
	public function left(): Join;
	public function right(): Join;
}