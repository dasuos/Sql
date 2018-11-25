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

	public function sql(): string {
		return sprintf(
			'SELECT %s %s',
			trim(
				sprintf(
					'%s %s',
					$this->sql['distinct'] ?? self::NO_CLAUSE,
					implode(', ', $this->sql['columns'])
				)
			),
			$this->sql['from']
		);
	}
}