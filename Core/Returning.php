<?php
declare(strict_types = 1);

namespace Dasuos\Sql;

final class Returning implements Statement {

	private $origin;
	private $columns;

	public function __construct(Statement $origin, string ...$columns) {
		$this->origin = $origin;
		$this->columns = $columns;
	}

	public function sql(): string {
		return sprintf(
			'%s RETURNING %s',
			$this->origin->sql(),
			implode(', ', $this->columns)
		);
	}
}