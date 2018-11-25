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

	public function testReturningDistinctSelect(): void {
		Tester\Assert::same(
			'SELECT DISTINCT foo, bar FROM foobar',
			(new Sql\BuiltSelect('foo', 'bar'))
				->distinct()
				->from(new Sql\BuiltFrom('foobar'))
				->sql()
		);
	}

	public function testReturningSelectWithJoinedTable(): void {
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

	public function testReturningSelectWithInnerJoinedTable(): void {
		Tester\Assert::same(
			'SELECT foo, bar FROM foobar JOIN barfoo ON bar = foo',
			(new Sql\BuiltSelect('foo', 'bar'))
				->from(
					(new Sql\BuiltFrom('foobar'))
						->join(
							(new Sql\BuiltJoin('barfoo', 'bar', 'foo'))->inner()
						)
				)
				->sql()
		);
	}

	public function testReturningSelectWithLeftJoinedTable(): void {
		Tester\Assert::same(
			'SELECT foo, bar FROM foobar LEFT JOIN barfoo ON bar = foo',
			(new Sql\BuiltSelect('foo', 'bar'))
				->from(
					(new Sql\BuiltFrom('foobar'))
						->join(
							(new Sql\BuiltJoin('barfoo', 'bar', 'foo'))->left()
						)
				)
				->sql()
		);
	}

	public function testReturningSelectWithRightJoinedTable(): void {
		Tester\Assert::same(
			'SELECT foo, bar FROM foobar RIGHT JOIN barfoo ON bar = foo',
			(new Sql\BuiltSelect('foo', 'bar'))
				->from(
					(new Sql\BuiltFrom('foobar'))
						->join(
							(new Sql\BuiltJoin('barfoo', 'bar', 'foo'))->right()
						)
				)
				->sql()
		);
	}

	public function testReturningSelectWithMultipleJoinedTables(): void {
		Tester\Assert::same(
			'SELECT foo, bar FROM foobar JOIN barfoo ON bar = foo LEFT JOIN foobar ON foo = bar',
			(new Sql\BuiltSelect('foo', 'bar'))
				->from(
					(new Sql\BuiltFrom('foobar'))
						->join(
							new Sql\BuiltJoin('barfoo', 'bar', 'foo'),
							(new Sql\BuiltJoin('foobar', 'foo', 'bar'))->left()
						)
				)
				->sql()
		);
	}
}

(new BuiltSelect)->run();