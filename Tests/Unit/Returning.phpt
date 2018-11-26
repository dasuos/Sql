<?php
declare(strict_types = 1);

namespace Dasuos\Sql\Unit;

use Dasuos\Sql;
use Tester;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
final class Returning extends Tester\TestCase {

	public function testReturningStatementWithReturningSingleColumn(): void {
		Tester\Assert::same(
			'UPDATE foo SET bar = ? WHERE foo = ? RETURNING foo',
			(new Sql\Returning(
				new Sql\FakeStatement('UPDATE foo SET bar = ? WHERE foo = ?'),
				'foo'
			))->sql()
		);
	}

	public function testReturningStatementWithReturningMultipleColumns(): void {
		Tester\Assert::same(
			'UPDATE foo SET foo = ? WHERE bar = ? RETURNING foo, bar',
			(new Sql\Returning(
				new Sql\FakeStatement('UPDATE foo SET foo = ? WHERE bar = ?'),
				'foo',
				'bar'
			))->sql()
		);
	}
}

(new Returning)->run();