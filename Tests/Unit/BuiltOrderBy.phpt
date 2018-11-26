<?php
declare(strict_types = 1);

namespace Dasuos\Sql\Unit;

use Dasuos\Sql;
use Tester;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
final class BuiltOrderBy extends Tester\TestCase {

	public function testReturningOrderBySingleColumn(): void {
		Tester\Assert::same(
			'ORDER BY foo ASC',
			(new Sql\BuiltOrderBy('foo'))->sql()
		);
	}

	public function testReturningOrderByManyColumns(): void {
		Tester\Assert::same(
			'ORDER BY foo, bar ASC',
			(new Sql\BuiltOrderBy('foo', 'bar'))->sql()
		);
	}

	public function testReturningAscendingOrder(): void {
		Tester\Assert::same(
			'ORDER BY foo, bar ASC',
			(new Sql\BuiltOrderBy('foo', 'bar'))->ascending()->sql()
		);
	}

	public function testReturningDescendingOrder(): void {
		Tester\Assert::same(
			'ORDER BY foo DESC',
			(new Sql\BuiltOrderBy('foo'))->descending()->sql()
		);
	}
}

(new BuiltOrderBy)->run();