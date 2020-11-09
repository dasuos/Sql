<?php
declare(strict_types = 1);

namespace Dasuos\Sql;

final class Join implements Clause {

	private const INNER = 'JOIN';

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
		$this->sql['join'] = self::INNER;
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

	public function select(Select $select): Join {
		$this->sql['select'] = sprintf('%s', $select->sql());
		return $this;
	}

	public function sql(): string {
		$join = $this->sql['join'] ?? self::INNER;
		return sprintf(
			'%s %s ON %s = %s',
			isset($this->sql['select'])
				? sprintf('%s (%s) AS', $join, $this->sql['select'])
				: $join,
			$this->sql['table'],
			$this->sql['column1'],
			$this->sql['column2']
		);
	}
}
