<?php
declare(strict_types = 1);

namespace Dasuos\Sql;

final class BuiltSelect implements Select {

	private const NO_CLAUSE = '';

	private $sql;

	public function __construct(string ...$columns) {
		$this->sql['columns'] = $columns;
	}

	public function distinct(): Select {
		$this->sql['distinct'] = 'DISTINCT';
		return $this;
	}

	public function from(From $from): Select {
		$this->sql['from'] = $from->sql();
		return $this;
	}

	public function where(Where $where): Select {
		$this->sql['where'] = $where->sql();
		return $this;
	}

	public function sql(): string {
		return $this->trim(
			'SELECT %s',
			implode(
				' ',
				[
					$this->columns($this->sql),
					$this->sql['from'],
					$this->sql['where'] ?? self::NO_CLAUSE,
				]
			)
		);
	}

	private function columns(array $sql): string {
		return $this->trim(
			'%s %s',
			$sql['distinct'] ?? self::NO_CLAUSE,
			implode(', ', $sql['columns'])
		);
	}

	private function trim(string $sql, string ...$clauses): string {
		return trim(sprintf($sql, ...$clauses));
	}
}