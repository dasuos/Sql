<?php
declare(strict_types = 1);

namespace Dasuos\Sql;

final class BuiltFrom implements From {

	private const NO_CLAUSE = '';

	private $sql;

	public function __construct(string $table) {
		$this->sql['table'] = $table;
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
		return sprintf(
			'FROM %s',
			trim(
				sprintf(
					'%s %s',
					$this->sql['table'],
					$this->sql['joins'] ?? self::NO_CLAUSE
				)
			)
		);
	}
}