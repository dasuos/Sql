<?php
declare(strict_types = 1);

namespace Dasuos\Sql\Unit;

use Dasuos\Sql;
use Tester;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
final class PreparedInsert extends Tester\TestCase {

	public function testReturningInsert(): void {
		Tester\Assert::same(
			'INSERT INTO foo (foo, bar) VALUES (?, ?)',
			(new Sql\PreparedInsert('foo'))
				->columns('foo', 'bar')
				->values([1, 1])
				->sql()
		);
	}

	public function testReturningMultiInsert(): void {
		Tester\Assert::same(
			'INSERT INTO foo (foo, bar) VALUES (?, ?), (?, ?), (?, ?)',
			(new Sql\PreparedInsert('foo'))
				->columns('foo', 'bar')
				->values([1, 1], [1, 2], [1, 3])
				->sql()
		);
	}

	public function testReturningInsertWithReturning(): void {
		Tester\Assert::same(
			'INSERT INTO foo (foo, bar) VALUES (?, ?) RETURNING foo',
			(new Sql\Returning(
				(new Sql\PreparedInsert('foo'))
					->columns('foo', 'bar')
					->values([1, 1]),
				'foo'
			))->sql()
		);
	}
}

(new PreparedInsert)->run();