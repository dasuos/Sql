<?php
declare(strict_types = 1);

namespace Dasuos\Sql;

final class PreparedUpdate implements Update {

	private const NO_CLAUSE = '';

	private $sql;

	public function __construct(string $table) {
		$this->sql['table'] = $table;
	}

	public function set(array $values): Update {
		$this->sql['set'] = $values;
		return $this;
	}

	public function where(Where $where): Update {
		$this->sql['where'] = $where->sql();
		return $this;
	}

	public function sql(): string {
		return trim(
			sprintf(
				'UPDATE %s SET %s %s',
				$this->sql['table'],
				implode(
					', ',
					array_map(
						function ($column) {
							return $this->placeholder($column);
						},
						array_keys($this->sql['set'])
					)
				),
				$this->sql['where'] ?? self::NO_CLAUSE
			)
		);
	}

	private function placeholder(string $column): string {
		return sprintf('%1$s = :%1$s', $column);
	}
}