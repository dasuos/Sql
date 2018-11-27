<?php
declare(strict_types = 1);

namespace Dasuos\Sql;

final class Limit implements Clause {

	private const NO_LIMIT = '';

	private $limit;

	public function __construct(int $limit) {
		$this->limit = $limit;
	}

	public function sql(): string {
		return $this->limit === PHP_INT_MAX
			? self::NO_LIMIT
			: 'LIMIT ? OFFSET ?';
	}
}