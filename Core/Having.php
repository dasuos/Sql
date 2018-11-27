<?php
declare(strict_types = 1);

namespace Dasuos\Sql;

final class Having implements Clause {

	private $condition;

	public function __construct(string $condition) {
		$this->condition = $condition;
	}

	public function sql(): string {
		return sprintf('HAVING %s', $this->condition);
	}
}