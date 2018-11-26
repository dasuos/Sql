<?php
declare(strict_types = 1);

namespace Dasuos\Sql\Unit;

use Dasuos\Sql;
use Tester;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
final class PreparedUpdate extends Tester\TestCase {

	public function testReturningUpdateWithSingleColumn(): void {
		Tester\Assert::same(
			'UPDATE foo SET foo = :foo WHERE id = :id',
			(new Sql\PreparedUpdate('foo'))
				->set(['foo' => 'bar'])
				->where(new Sql\BuiltWhere('id = :id'))
				->sql()
		);
	}

	public function testReturningOutputWithManyColumns(): void {
		Tester\Assert::same(
			'UPDATE foo SET foo = :foo, bar = :bar WHERE id = :id',
			(new Sql\PreparedUpdate('foo'))
				->set(['foo' => 'bar', 'bar' => 'foo'])
				->where(new Sql\BuiltWhere('id = :id'))
				->sql()
		);
	}

	public function testReturningUpdateWithoutWhere(): void {
		Tester\Assert::same(
			'UPDATE foo SET foo = :foo',
			(new Sql\PreparedUpdate('foo'))
				->set(['foo' => 'bar'])
				->sql()
		);
	}
}

(new PreparedUpdate)->run();