<?php
declare(strict_types = 1);

namespace Dasuos\Sql;

final class Delete implements Statement {

	private const NO_CLAUSE = '';

	private $sql;

	public function __construct(string $table) {
		$this->sql['table'] = $table;
	}

	public function where(Where $where): Delete {
		$this->sql['where'] = $where->sql();
		return $this;
	}

	public function sql(): string {
		return trim(
			sprintf(
				'DELETE FROM %s %s',
				$this->sql['table'],
				$this->sql['where'] ?? self::NO_CLAUSE
			)
		);
	}
}