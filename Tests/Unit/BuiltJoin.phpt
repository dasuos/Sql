<?php
declare(strict_types = 1);

namespace Dasuos\Sql\Unit;

use Dasuos\Sql;
use Tester;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
final class BuiltJoin extends Tester\TestCase {

	public function testReturningJoin(): void {
		Tester\Assert::same(
			'JOIN foobar ON foo = bar',
			(new Sql\BuiltJoin('foobar', 'foo', 'bar'))->sql()
		);
	}

	public function testReturningLeftJoin(): void {
		Tester\Assert::same(
			'LEFT JOIN foobar ON foo = bar',
			(new Sql\BuiltJoin('foobar', 'foo', 'bar'))
				->left()
				->sql()
		);
	}

	public function testReturningRightJoin(): void {
		Tester\Assert::same(
			'RIGHT JOIN foobar ON foo = bar',
			(new Sql\BuiltJoin('foobar', 'foo', 'bar'))
				->right()
				->sql()
		);
	}
}

(new BuiltJoin)->run();