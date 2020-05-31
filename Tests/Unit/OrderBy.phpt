<?php
declare(strict_types = 1);

namespace Dasuos\Sql\Unit;

use Dasuos\Sql;
use Tester;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
final class OrderBy extends Tester\TestCase {

	public function testReturningOrderBySingleColumn(): void {
		Tester\Assert::same(
			'ORDER BY foo ASC',
			(new Sql\OrderBy('foo'))->ascending()->sql()
		);
	}

	public function testReturningOrderByManyColumns(): void {
		Tester\Assert::same(
			'ORDER BY foo, bar ASC',
			(new Sql\OrderBy('foo', 'bar'))->ascending()->sql()
		);
	}

	public function testReturningAscendingOrder(): void {
		Tester\Assert::same(
			'ORDER BY foo, bar ASC',
			(new Sql\OrderBy('foo', 'bar'))->ascending()->sql()
		);
	}

	public function testReturningDescendingOrder(): void {
		Tester\Assert::same(
			'ORDER BY foo DESC',
			(new Sql\OrderBy('foo'))->descending()->sql()
		);
	}

	public function testReturningRandomOrder(): void {
		Tester\Assert::same(
			'ORDER BY random()',
			(new Sql\OrderBy('random()'))->sql()
		);
	}
}

(new OrderBy)->run();
