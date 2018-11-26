<?php
declare(strict_types = 1);

namespace Dasuos\Sql\Unit;

use Dasuos\Sql;
use Tester;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
final class BuiltSelect extends Tester\TestCase {

	public function testReturningSelectWithSingleColumn(): void {
		Tester\Assert::same(
			'SELECT foo FROM foobar',
			(new Sql\BuiltSelect('foo'))
				->from(new Sql\BuiltFrom('foobar'))
				->sql()
		);
	}

	public function testReturningSelectWithMultipleColumns(): void {
		Tester\Assert::same(
			'SELECT foo, bar FROM foobar',
			(new Sql\BuiltSelect('foo', 'bar'))
				->from(new Sql\BuiltFrom('foobar'))
				->sql()
		);
	}

	public function testReturningSelectWithWhere(): void {
		Tester\Assert::same(
			'SELECT foo FROM foobar WHERE foo = ?',
			(new Sql\BuiltSelect('foo'))
				->from(new Sql\BuiltFrom('foobar'))
				->where(new Sql\BuiltWhere('foo = ?'))
				->sql()
		);
	}

	public function testReturningSelectWithJoin(): void {
		Tester\Assert::same(
			'SELECT foo, bar FROM foobar JOIN barfoo ON bar = foo',
			(new Sql\BuiltSelect('foo', 'bar'))
				->from(
					(new Sql\BuiltFrom('foobar'))
						->join(new Sql\BuiltJoin('barfoo', 'bar', 'foo'))
				)
				->sql()
		);
	}

	public function testReturningSelectWithJoinAndWhere(): void {
		Tester\Assert::same(
			'SELECT foo, bar FROM foobar JOIN barfoo ON bar = foo WHERE foo = ?',
			(new Sql\BuiltSelect('foo', 'bar'))
				->from(
					(new Sql\BuiltFrom('foobar'))
						->join(new Sql\BuiltJoin('barfoo', 'bar', 'foo'))
				)
				->where(new Sql\BuiltWhere('foo = ?'))
				->sql()
		);
	}

	public function testReturningSelectWithLeftJoin(): void {
		Tester\Assert::same(
			'SELECT foo, bar FROM foobar LEFT JOIN barfoo ON bar = foo',
			(new Sql\BuiltSelect('foo', 'bar'))
				->from(
					(new Sql\BuiltFrom('foobar'))
						->join(
							(new Sql\BuiltJoin('barfoo', 'bar', 'foo'))
								->left()
						)
				)
				->sql()
		);
	}

	public function testReturningSelectWithRightJoin(): void {
		Tester\Assert::same(
			'SELECT foo, bar FROM foobar RIGHT JOIN barfoo ON bar = foo',
			(new Sql\BuiltSelect('foo', 'bar'))
				->from(
					(new Sql\BuiltFrom('foobar'))
						->join(
							(new Sql\BuiltJoin('barfoo', 'bar', 'foo'))
								->right()
						)
				)
				->sql()
		);
	}

	public function testReturningSelectWithMultipleJoins(): void {
		Tester\Assert::same(
			'SELECT foo, bar FROM foobar JOIN barfoo ON bar = foo LEFT JOIN foobar ON foo = bar',
			(new Sql\BuiltSelect('foo', 'bar'))
				->from(
					(new Sql\BuiltFrom('foobar'))
						->join(
							new Sql\BuiltJoin('barfoo', 'bar', 'foo'),
							(new Sql\BuiltJoin('foobar', 'foo', 'bar'))
								->left()
						)
				)
				->sql()
		);
	}
}

(new BuiltSelect)->run();