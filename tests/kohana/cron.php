<?php

/**
 * @package Cron
 * @group   kohana
 * @group   kohana.cron
 *
 * @author      Chris Bandy
 * @copyright   (c) 2010 Chris Bandy
 * @license     http://www.opensource.org/licenses/isc-license.txt
 */
class Kohana_Cron_Test extends PHPUnit_Framework_TestCase
{

	public function provider_next()
	{
		return array
		(
			array('@annually',  mktime(8, 45, 0, 11, 19, 2009), mktime(0, 0, 0, 1, 1, 2010)),
			array('@monthly',   mktime(8, 45, 0, 11, 19, 2009), mktime(0, 0, 0, 12, 1, 2009)),
			array('@weekly',    mktime(8, 45, 0, 11, 19, 2009), mktime(0, 0, 0, 11, 22, 2009)),
			array('@daily',     mktime(8, 45, 0, 11, 19, 2009), mktime(0, 0, 0, 11, 20, 2009)),
			array('@hourly',    mktime(8, 45, 0, 11, 19, 2009), mktime(9, 0, 0, 11, 19, 2009)),

			array('* * * * *',  mktime(8, 45, 0, 11, 19, 2009), mktime(8, 46, 0, 11, 19, 2009)),

			// Sundays          // Monday, Nov 30, 2009
			array('* * * * 0',  mktime(0, 0, 0, 11, 30, 2009),  mktime(0, 0, 0, 12, 6, 2009)),

			// 15th and Saturdays // Sunday, Nov 29, 2009
			array('* * 15 * 6', mktime(0, 0, 0, 11, 29, 2009),  mktime(0, 0, 0, 12, 5, 2009)),

			// Mondays and Fridays  // Tuesday, Nov 24, 2009
			array('* * * * 1,5',    mktime(0, 0, 0, 11, 24, 2009),  mktime(0, 0, 0, 11, 27, 2009)),

			// 15th, Saturdays, and Sundays // Monday, Nov 23, 2009
			array('* * 15 * 6-7',   mktime(0, 0, 0, 11, 23, 2009),  mktime(0, 0, 0, 11, 28, 2009)),

			// 15th, 30th, and Tuesdays // Sunday, Nov 29, 2009
			array('* * 15,30 * 2',  mktime(0, 0, 0, 11, 29, 2009),  mktime(0, 0, 0, 11, 30, 2009)),

			// Midnight on Thursdays // 1am, Thursday, Nov 19, 2009
			array('0 0 * * 4',  mktime(1, 0, 0, 11, 19, 2009),  mktime(0, 0, 0, 11, 26, 2009)),

			// Midnight on odd days and Thursdays // 1am, Thursday, Nov 19, 2009
			array('0 0 */2 * 4',    mktime(1, 0, 0, 11, 19, 2009),  mktime(0, 0, 0, 11, 21, 2009)),
		);
	}

	/**
	 * @test
	 * @dataProvider    provider_next
	 *
	 * @param   string  Period
	 * @param   integer Timestamp from which to calculate
	 * @param   integer Next timestamp in period
	 */
	public function test_next($period, $from, $expected_result)
	{
		$cron = new Cron($period, NULL);
		$result = $cron->next($from);

		$this->assertSame($expected_result, $result);
	}
}
