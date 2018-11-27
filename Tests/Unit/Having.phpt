<?php
declare(strict_types = 1);

namespace Dasuos\Sql\Unit;

use Dasuos\Sql;
use Tester;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
final class Having extends Tester\TestCase {

	public function testReturningHavingWithCondition(): void {
		Tester\Assert::same(
			'HAVING COUNT(foo) > 5',
			(new Sql\Having('COUNT(foo) > 5'))->sql()
		);
	}
}

(new Having)->run();