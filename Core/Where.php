<?php
declare(strict_types = 1);

namespace Dasuos\Sql;

final class Where implements Clause {

	private $sql;

	public function __construct(string $condition) {
		$this->sql['criteria'] = $condition;
	}

	public function and(string $condition): Where {
		$this->sql['criteria'] = $this->criteria(
			$this->sql['criteria'],
			'AND',
			$condition
		);
		return $this;
	}

	public function or(string $condition): Where {
		$this->sql['criteria'] = $this->criteria(
			$this->sql['criteria'],
			'OR',
			$condition
		);
		return $this;
	}

	public function sql(): string {
		return sprintf('WHERE %s', $this->sql['criteria']);
	}

	private function criteria(
		string $criteria,
		string $operator,
		string $condition
	): string {
		return implode(' ', [$criteria, $operator, $condition]);
	}
}