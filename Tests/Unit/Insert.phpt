<?php
declare(strict_types = 1);

namespace Dasuos\Sql\Unit;

use Dasuos\Sql;
use Tester;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
final class Insert extends Tester\TestCase {

	public function testReturningInsert(): void {
		Tester\Assert::same(
			'INSERT INTO foo (foo, bar) VALUES (?, ?)',
			(new Sql\Insert('foo'))
				->columns('foo', 'bar')
				->values([[1, 1]])
				->sql()
		);
	}

	public function testReturningMultiInsert(): void {
		Tester\Assert::same(
			'INSERT INTO foo (foo, bar) VALUES (?, ?), (?, ?), (?, ?)',
			(new Sql\Insert('foo'))
				->columns('foo', 'bar')
				->values([[1, 1], [1, 2], [1, 3]])
				->sql()
		);
	}

	public function testReturningInsertWithReturning(): void {
		Tester\Assert::same(
			'INSERT INTO foo (foo, bar) VALUES (?, ?) RETURNING foo',
			(new Sql\Returning(
				(new Sql\Insert('foo'))
					->columns('foo', 'bar')
					->values([[1, 1]]),
				'foo'
			))->sql()
		);
	}

	public function testReturningInsertWithSelectValue(): void {
		Tester\Assert::same(
			'INSERT INTO foo (foo, bar) VALUES (?, ?, (SELECT foo FROM bar)), (?, ?, (SELECT foo FROM bar))',
			(new Sql\Insert('foo'))
				->columns('foo', 'bar')
				->values(
					[[1, 1], [1, 2]],
					(new Sql\Select('foo'))
						->from(new Sql\From('bar'))
				)
				->sql()
		);
	}

	public function testReturningInsertWithManySelectValues(): void {
		Tester\Assert::same(
			'INSERT INTO foo (foo, bar) VALUES (?, ?, (SELECT foo FROM bar), (SELECT bar FROM foo)), (?, ?, (SELECT foo FROM bar), (SELECT bar FROM foo))',
			(new Sql\Insert('foo'))
				->columns('foo', 'bar')
				->values(
					[[1, 1], [1, 2]],
					(new Sql\Select('foo'))->from(new Sql\From('bar')),
					(new Sql\Select('bar'))->from(new Sql\From('foo'))
				)
				->sql()
		);
	}
}

(new Insert)->run();