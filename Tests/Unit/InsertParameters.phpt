<?php
declare(strict_types = 1);

namespace Dasuos\Sql\Unit;

use Dasuos\Sql;
use Tester;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
final class InsertParameters extends Tester\TestCase {

	public function testFlatteningNestedTwoDimensionalArray(): void {
		Tester\Assert::same(
			[0, 1, 2, 3, 4, 5, 6, 7],
			(new Sql\InsertParameters(
				[0, ['one' => 1, 'two' => 2], 3, 4, [5, 6], 7]
			))->values()
		);
	}

	public function testFlatteningNestedThreeAndMoreDimensionalArray(): void {
		Tester\Assert::same(
			[0, 1, 2, 3, 4, 5, 6, 'seven'],
			(new Sql\InsertParameters(
				[0, [1, [2]], [3, 4, [5, [6]]], 'seven']
			))->values()
		);
	}

	public function testFlatteningAlreadyFlatArray(): void {
		Tester\Assert::same(
			[0, 1, 2, 3, 4, 5, 'six', 7],
			(new Sql\InsertParameters(
				[0, 1, 2, 3, 4, 5, 'six', 7]
			))->values()
		);
	}
}

(new InsertParameters)->run();