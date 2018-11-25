<?php
declare(strict_types = 1);

namespace Dasuos\Sql\Unit;

use Dasuos\Sql;
use Tester;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
final class BuiltFrom extends Tester\TestCase {

	public function testReturningFrom(): void {
		Tester\Assert::same(
			'FROM foobar',
			(new Sql\BuiltFrom('foobar'))->sql()
		);
	}

	public function testReturningFromWithJoin(): void {
		Tester\Assert::same(
			'FROM foobar JOIN barfoo ON foo = bar',
			(new Sql\BuiltFrom('foobar'))
				->join(new Sql\BuiltJoin('barfoo', 'foo', 'bar'))
				->sql()
		);
	}

	public function testReturningFromWithMultipleJoins(): void {
		Tester\Assert::same(
			'FROM foo JOIN barfoo ON foo = bar LEFT JOIN foobar ON bar = foo',
			(new Sql\BuiltFrom('foo'))
				->join(
					new Sql\BuiltJoin('barfoo', 'foo', 'bar'),
					(new Sql\BuiltJoin('foobar', 'bar', 'foo'))->left()
				)
				->sql()
		);
	}
}

(new BuiltFrom)->run();