<?php
declare(strict_types = 1);

namespace Dasuos\Sql\Unit;

use Dasuos\Sql;
use Tester;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
final class GroupBy extends Tester\TestCase {

	public function testReturningGroupByWithSingleColumn(): void {
		Tester\Assert::same('GROUP BY foo', (new Sql\GroupBy('foo'))->sql());
	}

	public function testReturningGroupByWithManyColumns(): void {
		Tester\Assert::same(
			'GROUP BY foo, bar',
			(new Sql\GroupBy('foo', 'bar'))->sql()
		);
	}
}

(new GroupBy)->run();