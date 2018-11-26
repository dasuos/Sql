<?php
declare(strict_types = 1);

namespace Dasuos\Sql;

final class FakeStatement implements Statement {

	private $sql;

	public function __construct(string $sql) {
		$this->sql = $sql;
	}

	public function sql(): string {
		return $this->sql;
	}
}