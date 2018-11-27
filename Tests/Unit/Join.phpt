<?php
declare(strict_types = 1);

namespace Dasuos\Sql\Unit;

use Dasuos\Sql;
use Tester;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
final class Join extends Tester\TestCase {

	public function testReturningJoin(): void {
		Tester\Assert::same(
			'JOIN foobar ON foo = bar',
			(new Sql\Join('foobar', 'foo', 'bar'))->sql()
		);
	}

	public function testReturningLeftJoin(): void {
		Tester\Assert::same(
			'LEFT JOIN foobar ON foo = bar',
			(new Sql\Join('foobar', 'foo', 'bar'))
				->left()
				->sql()
		);
	}

	public function testReturningRightJoin(): void {
		Tester\Assert::same(
			'RIGHT JOIN foobar ON foo = bar',
			(new Sql\Join('foobar', 'foo', 'bar'))
				->right()
				->sql()
		);
	}
}

(new Join)->run();