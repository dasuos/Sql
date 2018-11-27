<?php
declare(strict_types = 1);

namespace Dasuos\Sql;

final class With implements Statement {

	private const NAME = 0;
	private const STATEMENT = 1;

	private $sql;

	public function __construct(string $name, Statement $origin) {
		$this->sql['statements'][] = [$name, $origin->sql()];
	}

	public function statement(string $name, Statement $origin): With {
		$this->sql['statements'][] = [$name, $origin->sql()];
		return $this;
	}

	public function output(Statement $origin): With {
		$this->sql['output'] = $origin->sql();
		return $this;
	}

	public function sql(): string {
		return sprintf(
			'WITH %s %s',
			implode(', ',
				array_map(
					static function($statement) {
						return sprintf(
							'%s AS ( %s )',
							$statement[self::NAME],
							$statement[self::STATEMENT]
						);
					},
					$this->sql['statements']
				)
			),
			$this->sql['output']
		);
	}
}