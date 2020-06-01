<?php
declare(strict_types = 1);

namespace Dasuos\Sql;

final class From implements Statement {

	private const NO_CLAUSE = '';

	private $sql;

	public function __construct(string $table = '') {
		$this->sql['table'] = $table;
	}

	public function select(Select $select, string $name): From {
		$this->sql['select'] = sprintf(
			'FROM (%s) %s',
			$select->sql(),
			$name
		);
		return $this;
	}

	public function join(Join ...$joins): From {
		$this->sql['joins'] = implode(
			' ',
			array_map(
				static function(Join $join) {
					return $join->sql();
				},
				$joins
			)
		);
		return $this;
	}

	public function sql(): string {
		return $this->sql['select'] ?? sprintf(
			'FROM %s',
			trim(
				sprintf(
					'%s %s',
					$this->table($this->sql),
					$this->sql['joins'] ?? self::NO_CLAUSE
				)
			)
		);
	}

	private function table(array $sql): string {
		if ($sql['table'])
			return $sql['table'];
		throw new \InvalidArgumentException('Table name must be specified');
	}
}
