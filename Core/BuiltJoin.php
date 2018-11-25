<?php
declare(strict_types = 1);

namespace Dasuos\Sql;

final class BuiltJoin implements Join {

	private const DEFAULT = 'JOIN';

	private $sql;

	public function __construct(
		string $table,
		string $column1,
		string $column2
	) {
		$this->sql['table'] = $table;
		$this->sql['column1'] = $column1;
		$this->sql['column2'] = $column2;
	}

	public function inner(): Join {
		$this->sql['join'] = self::DEFAULT;
		return $this;
	}

	public function left(): Join {
		$this->sql['join'] = 'LEFT JOIN';
		return $this;
	}

	public function right(): Join {
		$this->sql['join'] = 'RIGHT JOIN';
		return $this;
	}

	public function sql(): string {
		return sprintf(
			'%s ON %s = %s',
			sprintf(
				'%s %s',
				$this->sql['join'] ?? self::DEFAULT,
				$this->sql['table']
			),
			$this->sql['column1'],
			$this->sql['column2']
		);
	}
}