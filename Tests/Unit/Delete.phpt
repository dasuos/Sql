<?php
declare(strict_types = 1);

namespace Dasuos\Sql\Unit;

use Dasuos\Sql;
use Tester;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
final class Delete extends Tester\TestCase {

	public function testReturningDelete(): void {
		Tester\Assert::same('DELETE FROM foo', (new Sql\Delete('foo'))->sql());
	}

	public function testReturningDeleteWithWhere(): void {
		Tester\Assert::same(
			'DELETE FROM foo WHERE bar = ?',
			(new Sql\Delete('foo'))
				->where(new Sql\Where('bar = ?'))
				->sql()
		);
	}
}

(new Delete)->run();