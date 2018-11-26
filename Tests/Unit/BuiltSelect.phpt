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

	public function testReturningSelectWithDescendingOrderBy(): void {
		Tester\Assert::same(
			'SELECT foo FROM foobar ORDER BY foo DESC',
			(new Sql\BuiltSelect('foo'))
				->from(new Sql\BuiltFrom('foobar'))
				->order(
					(new Sql\BuiltOrderBy('foo'))
						->descending()
				)
				->sql()
		);
	}

	public function testReturningSelectWithLimit(): void {
		Tester\Assert::same(
			'SELECT foo FROM foobar LIMIT ? OFFSET ?',
			(new Sql\BuiltSelect('foo'))
				->from(new Sql\BuiltFrom('foobar'))
				->limit(new Sql\PreparedLimit(10))
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

	public function testReturningSelectWithMultipleJoinsWhereOrderAndLimit(): void {
		Tester\Assert::same(
			'SELECT foo, bar FROM foobar JOIN barfoo ON bar = foo RIGHT JOIN foobar ON foo = bar WHERE foo = ? OR bar = ? AND foobar = ? ORDER BY foo ASC LIMIT ? OFFSET ?',
			(new Sql\BuiltSelect('foo', 'bar'))
				->from(
					(new Sql\BuiltFrom('foobar'))
						->join(
							new Sql\BuiltJoin('barfoo', 'bar', 'foo'),
							(new Sql\BuiltJoin('foobar', 'foo', 'bar'))
								->right()
						)
				)
				->where(
					(new Sql\BuiltWhere('foo = ?'))
						->or('bar = ?')
						->and('foobar = ?')
				)
				->order(new Sql\BuiltOrderBy('foo'))
				->limit(new Sql\PreparedLimit(10))
				->sql()
		);
	}
}

(new BuiltSelect)->run();