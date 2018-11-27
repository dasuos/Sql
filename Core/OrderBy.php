<?php
declare(strict_types = 1);

namespace Dasuos\Sql;

final class OrderBy implements Clause {

	private const DEFAULT = 'ASC';

	private $sql;

	public function __construct(string ...$columns) {
		$this->sql['columns'] = $columns;
	}

	public function ascending(): OrderBy {
		$this->sql['sort'] = self::DEFAULT;
		return $this;
	}

	public function descending(): OrderBy {
		$this->sql['sort'] = 'DESC';
		return $this;
	}

	public function sql(): string {
		return sprintf(
			'ORDER BY %s %s',
			implode(', ', $this->sql['columns']),
			$this->sql['sort'] ?? self::DEFAULT
		);
	}
}