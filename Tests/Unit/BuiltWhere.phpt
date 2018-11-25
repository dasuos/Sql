<?php
declare(strict_types = 1);

namespace Dasuos\Sql\Unit;

use Dasuos\Sql;
use Tester;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
final class BuiltWhere extends Tester\TestCase {

	public function testReturningWhereWithSingleCondition(): void {
		Tester\Assert::same(
			'WHERE foo = ?',
			(new Sql\BuiltWhere('foo = ?'))->sql()
		);
	}

	public function testReturningFromWhereWithLogicalConjunction(): void {
		Tester\Assert::same(
			"WHERE foo = ? AND bar IN ('foo', 'bar')",
			(new Sql\BuiltWhere('foo = ?'))
				->and("bar IN ('foo', 'bar')")
				->sql()
		);
	}

	public function testReturningFromWhereWithLogicalDisjunction(): void {
		Tester\Assert::same(
			"WHERE foo = ? OR bar IN ('foo', 'bar')",
			(new Sql\BuiltWhere('foo = ?'))
				->or("bar IN ('foo', 'bar')")
				->sql()
		);
	}

	public function testReturningFromWhereWithManyLogicalOperators(): void {
		Tester\Assert::same(
			"WHERE foo = ? OR bar IN ('foo', 'bar') AND bar = ?",
			(new Sql\BuiltWhere('foo = ?'))
				->or("bar IN ('foo', 'bar')")
				->and('bar = ?')
				->sql()
		);
	}
}

(new BuiltWhere)->run();