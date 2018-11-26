<?php
declare(strict_types = 1);

namespace Dasuos\Sql;

final class Returning implements Clause {

	private $statement;
	private $columns;

	public function __construct(Statement $statement, string ...$columns) {
		$this->statement = $statement;
		$this->columns = $columns;
	}

	public function sql(): string {
		return sprintf(
			'%s RETURNING %s',
			$this->statement->sql(),
			implode(', ', $this->columns)
		);
	}
}