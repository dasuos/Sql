<?php
declare(strict_types = 1);

namespace Dasuos\Sql;

final class Select implements Statement {

	private const NO_CLAUSE = '';

	private $sql;

	public function __construct(string ...$columns) {
		$this->sql['columns'] = $columns;
	}

	public function from(From $from): Select {
		$this->sql['from'] = $from->sql();
		return $this;
	}

	public function where(Where $where): Select {
		$this->sql['where'] = $where->sql();
		return $this;
	}

	public function group(string ...$columns): Select {
		$this->sql['group'] = (new GroupBy(...$columns))->sql();
		return $this;
	}

	public function having(string $condition): Select {
		$this->sql['having'] = (new Having($condition))->sql();
		return $this;
	}

	public function order(OrderBy $order): Select {
		$this->sql['order'] = $order->sql();
		return $this;
	}

	public function limit($limit): Select {
		$this->sql['limit'] = (new Limit($limit))->sql();
		return $this;
	}

	public function sql(): string {
		return trim(
			sprintf(
				'SELECT %s %s %s',
				implode(', ', $this->sql['columns']),
				$this->sql['from'],
				implode(
					' ',
					array_filter(
						array_map(
							function($clause) {
								return $this->sql[$clause] ?? self::NO_CLAUSE;
							},
							['where', 'group', 'having', 'order', 'limit']
						)
					)
				)
			)
		);
	}
}