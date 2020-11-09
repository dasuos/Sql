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

	public function testReturningJoinedSelect(): void {
		Tester\Assert::same(
			'JOIN (SELECT foo FROM bar) AS f ON f.foo = b.bar',
			(new Sql\Join('f', 'f.foo', 'b.bar'))
				->select(
					(new Sql\Select('foo'))
						->from(new Sql\From('bar'))
				)
				->sql()
		);
	}
}

(new Join)->run();
