<?php
declare(strict_types = 1);

namespace Dasuos\Sql\Unit;

use Dasuos\Sql;
use Tester;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
final class From extends Tester\TestCase {

	public function testReturningFrom(): void {
		Tester\Assert::same(
			'FROM foobar',
			(new Sql\From('foobar'))->sql()
		);
	}

	public function testReturningFromWithJoin(): void {
		Tester\Assert::same(
			'FROM foobar JOIN barfoo ON foo = bar',
			(new Sql\From('foobar'))
				->join(new Sql\Join('barfoo', 'foo', 'bar'))
				->sql()
		);
	}

	public function testReturningFromWithMultipleJoins(): void {
		Tester\Assert::same(
			'FROM foo JOIN barfoo ON foo = bar LEFT JOIN foobar ON bar = foo',
			(new Sql\From('foo'))
				->join(
					new Sql\Join('barfoo', 'foo', 'bar'),
					(new Sql\Join('foobar', 'bar', 'foo'))->left()
				)
				->sql()
		);
	}
}

(new From)->run();