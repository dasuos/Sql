<?php
declare(strict_types = 1);

namespace Dasuos\Sql;

interface OrderBy extends Clause {

	public function ascending(): OrderBy;
	public function descending(): OrderBy;
}