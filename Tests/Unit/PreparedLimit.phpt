<?php
declare(strict_types = 1);

namespace Dasuos\Sql\Unit;

use Dasuos\Sql;
use Tester;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
final class PreparedLimit extends Tester\TestCase {

	public function testReturningEmptyStringWithMaximumInteger(): void {
		Tester\Assert::same(
			'',
			(new Sql\PreparedLimit(PHP_INT_MAX))->sql()
		);
	}

	public function testReturningLimitWithOffset(): void {
		Tester\Assert::same(
			'LIMIT ? OFFSET ?',
			(new Sql\PreparedLimit(10))->sql()
		);
	}
}

(new PreparedLimit)->run();