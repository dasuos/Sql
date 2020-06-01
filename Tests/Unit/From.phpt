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

	public function testReturningFromWithSubquery(): void {
		Tester\Assert::same(
			'FROM (SELECT foo FROM bar) foobar',
			(new Sql\From)->select(
				(new Sql\Select('foo'))->from(new Sql\From('bar')),
				'foobar'
			)->sql()
		);
	}

	public function testThrowingOnEmptyTable(): void {
		Tester\Assert::exception(
			static function() {
				(new Sql\From)->sql();
			},
			\InvalidArgumentException::class,
			'Table name must be specified'
		);
	}
}

(new From)->run();
