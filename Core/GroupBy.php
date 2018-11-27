<?php
declare(strict_types = 1);

namespace Dasuos\Sql;

final class GroupBy implements Clause {

	private $columns;

	public function __construct(string ...$columns) {
		$this->columns = $columns;
	}

	public function sql(): string {
		return sprintf('GROUP BY %s', implode(', ', $this->columns));
	}
}