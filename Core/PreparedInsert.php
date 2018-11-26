<?php
declare(strict_types = 1);

namespace Dasuos\Sql;

final class PreparedInsert implements Insert {

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

	public function values(array ...$values): Insert {
		$this->sql['values'] = $values;
		return $this;
	}

	public function sql(): string {
		return sprintf(
			'INSERT INTO %s (%s) VALUES %s',
			$this->sql['table'],
			implode(self::SEPARATOR, $this->sql['columns']),
			implode(
				self::SEPARATOR,
				array_map(
					function ($values) {
						return sprintf(
							'(%s)',
							$this->placeholders($values)
						);
					},
					$this->sql['values']
				)
			)
		);
	}

	private function placeholders(array $values): string {
		return implode(
			self::SEPARATOR,
			array_fill(0, count($values), self::PLACEHOLDER)
		);
	}
}