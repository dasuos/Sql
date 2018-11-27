<?php
declare(strict_types = 1);

namespace Dasuos\Sql;

final class Insert implements Statement {

	private const SEPARATOR = ', ';
	private const PLACEHOLDER = '?';

	private $sql;

	public function __construct(string $table) {
		$this->sql['table'] = $table;
	}

	public function columns(string ...$columns): Insert {
		$this->sql['columns'] = $columns;
		return $this;
	}

	public function values(array $values, Select ...$selects): Insert {
		$this->sql['values'] = array_map(
			function ($values) use ($selects) {
				return sprintf(
					'(%s)',
					implode(
						self::SEPARATOR,
						array_merge(
							$this->placeholders($values),
							$this->selects($selects)
						)
					)
				);
			},
			$values
		);
		return $this;
	}

	public function sql(): string {
		return sprintf(
			'INSERT INTO %s (%s) VALUES %s',
			$this->sql['table'],
			implode(self::SEPARATOR, $this->sql['columns']),
			implode(
				self::SEPARATOR,
				$this->sql['values']
			)
		);
	}

	private function placeholders(array $values): array {
		return array_fill(0, count($values), self::PLACEHOLDER);
	}

	private function selects(array $selects): array {
		return array_map(
			static function(Select $select) {
				return sprintf('(%s)', $select->sql());
			},
			$selects
		);
	}
}