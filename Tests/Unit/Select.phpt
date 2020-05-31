<?php
declare(strict_types = 1);

namespace Dasuos\Sql\Unit;

use Dasuos\Sql;
use Tester;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
final class Select extends Tester\TestCase {

	public function testReturningSelectWithSingleColumn(): void {
		Tester\Assert::same(
			'SELECT foo FROM foobar',
			(new Sql\Select('foo'))
				->from(new Sql\From('foobar'))
				->sql()
		);
	}

	public function testReturningSelectWithMultipleColumns(): void {
		Tester\Assert::same(
			'SELECT foo, bar FROM foobar',
			(new Sql\Select('foo', 'bar'))
				->from(new Sql\From('foobar'))
				->sql()
		);
	}

	public function testReturningSelectWithWhere(): void {
		Tester\Assert::same(
			'SELECT foo FROM foobar WHERE foo = ?',
			(new Sql\Select('foo'))
				->from(new Sql\From('foobar'))
				->where(new Sql\Where('foo = ?'))
				->sql()
		);
	}

	public function testReturningSelectWithDescendingOrderBy(): void {
		Tester\Assert::same(
			'SELECT foo FROM foobar ORDER BY foo DESC',
			(new Sql\Select('foo'))
				->from(new Sql\From('foobar'))
				->order(
					(new Sql\OrderBy('foo'))
						->descending()
				)
				->sql()
		);
	}

	public function testReturningSelectWithLimit(): void {
		Tester\Assert::same(
			'SELECT foo FROM foobar LIMIT ? OFFSET ?',
			(new Sql\Select('foo'))
				->from(new Sql\From('foobar'))
				->limit(10)
				->sql()
		);
	}

	public function testReturningSelectWithJoin(): void {
		Tester\Assert::same(
			'SELECT foo, bar FROM foobar JOIN barfoo ON bar = foo',
			(new Sql\Select('foo', 'bar'))
				->from(
					(new Sql\From('foobar'))
						->join(new Sql\Join('barfoo', 'bar', 'foo'))
				)
				->sql()
		);
	}

	public function testReturningSelectWithJoinAndWhere(): void {
		Tester\Assert::same(
			'SELECT foo, bar FROM foobar JOIN barfoo ON bar = foo WHERE foo = ?',
			(new Sql\Select('foo', 'bar'))
				->from(
					(new Sql\From('foobar'))
						->join(new Sql\Join('barfoo', 'bar', 'foo'))
				)
				->where(new Sql\Where('foo = ?'))
				->sql()
		);
	}

	public function testReturningSelectWithLeftJoin(): void {
		Tester\Assert::same(
			'SELECT foo, bar FROM foobar LEFT JOIN barfoo ON bar = foo',
			(new Sql\Select('foo', 'bar'))
				->from(
					(new Sql\From('foobar'))
						->join(
							(new Sql\Join('barfoo', 'bar', 'foo'))->left()
						)
				)
				->sql()
		);
	}

	public function testReturningSelectWithRightJoin(): void {
		Tester\Assert::same(
			'SELECT foo, bar FROM foobar RIGHT JOIN barfoo ON bar = foo',
			(new Sql\Select('foo', 'bar'))
				->from(
					(new Sql\From('foobar'))
						->join(
							(new Sql\Join('barfoo', 'bar', 'foo'))->right()
						)
				)
				->sql()
		);
	}

	public function testReturningSelectWithMultipleJoins(): void {
		Tester\Assert::same(
			'SELECT foo, bar FROM foobar JOIN barfoo ON bar = foo LEFT JOIN foobar ON foo = bar',
			(new Sql\Select('foo', 'bar'))
				->from(
					(new Sql\From('foobar'))
						->join(
							new Sql\Join('barfoo', 'bar', 'foo'),
							(new Sql\Join('foobar', 'foo', 'bar'))->left()
						)
				)
				->sql()
		);
	}

	public function testReturningSelectWithMultipleJoinsWhereOrderAndLimit(): void {
		Tester\Assert::same(
			'SELECT foo, bar FROM foobar JOIN barfoo ON bar = foo RIGHT JOIN foobar ON foo = bar WHERE foo = ? OR bar = ? AND foobar = ? ORDER BY foo ASC LIMIT ? OFFSET ?',
			(new Sql\Select('foo', 'bar'))
				->from(
					(new Sql\From('foobar'))
						->join(
							new Sql\Join('barfoo', 'bar', 'foo'),
							(new Sql\Join('foobar', 'foo', 'bar'))->right()
						)
				)
				->where(
					(new Sql\Where('foo = ?'))
						->or('bar = ?')
						->and('foobar = ?')
				)
				->order((new Sql\OrderBy('foo'))->ascending())
				->limit(10)
				->sql()
		);
	}

	public function testReturningSelectWithGroupBy(): void {
		Tester\Assert::same(
			'SELECT foo, SUM(bar) FROM foobar GROUP BY foo',
			(new Sql\Select('foo', 'SUM(bar)'))
				->from(new Sql\From('foobar'))
				->group('foo')
				->sql()
		);
	}

	public function testReturningSelectWithGroupByAndHaving(): void {
		Tester\Assert::same(
			'SELECT foo, bar FROM foobar GROUP BY foo HAVING COUNT(foo) > 2',
			(new Sql\Select('foo', 'bar'))
				->from(new Sql\From('foobar'))
				->group('foo')
				->having('COUNT(foo) > 2')
				->sql()
		);
	}
}

(new Select)->run();
