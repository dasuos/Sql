<?php
declare(strict_types = 1);

namespace Dasuos\Sql\Unit;

use Dasuos\Sql;
use Tester;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
final class With extends Tester\TestCase {

	public function testReturningCteOutputWithTwoStatements(): void {
		Tester\Assert::same(
			'WITH foobar AS ( UPDATE foo SET foo = ? RETURNING foo ) SELECT foo FROM foobar',
			(new Sql\With(
				'foobar',
				new Sql\FakeStatement('UPDATE foo SET foo = ? RETURNING foo')
			))->output(
				new Sql\FakeStatement('SELECT foo FROM foobar')
			)->sql()
		);
	}

	public function testReturningCteOutputWithMultipleStatements(): void {
		Tester\Assert::same(
			'WITH foobar AS ( UPDATE foo SET foo = ? RETURNING foo ), barfoo AS ( DELETE FROM bar WHERE foo = (SELECT foo FROM foobar) RETURNING foo ) SELECT foo FROM barfoo',
			(new Sql\With(
				'foobar',
				new Sql\FakeStatement('UPDATE foo SET foo = ? RETURNING foo')
			))->statement(
				'barfoo',
				new Sql\FakeStatement('DELETE FROM bar WHERE foo = (SELECT foo FROM foobar) RETURNING foo')
			)->output(
				new Sql\FakeStatement('SELECT foo FROM barfoo')
			)->sql()
		);
	}
}

(new With)->run();