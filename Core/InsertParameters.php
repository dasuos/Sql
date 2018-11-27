<?php
declare(strict_types = 1);

namespace Dasuos\Sql;

final class InsertParameters implements Parameters {

	private $nested;

	public function __construct(array $nested) {
		$this->nested = $nested;
	}

	public function values(): array {
		$flatten = [];
		array_walk_recursive(
			$this->nested,
			static function ($elements) use (&$flatten): void {
				$flatten[] = $elements;
			}
		);
		return $flatten;
	}
}