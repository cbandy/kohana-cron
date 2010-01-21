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

			array(
				'* * * * 0',                    // Sundays
				mktime(0, 0, 0, 11, 30, 2009),  // Monday, Nov 30, 2009
				mktime(0, 0, 0, 12, 6, 2009)    // Sunday, Dec 6, 2009
			),

			array(
				'* * 15 * 6',                   // 15th and Saturdays
				mktime(0, 0, 0, 11, 29, 2009),  // Sunday, Nov 29, 2009
				mktime(0, 0, 0, 12, 5, 2009)    // Saturday, Dec 5, 2009
			),

			array(
				'* * * * 1,5',                  // Mondays and Fridays
				mktime(0, 0, 0, 11, 24, 2009),  // Tuesday, Nov 24, 2009
				mktime(0, 0, 0, 11, 27, 2009)   // Friday, Nov 27, 2009
			),

			array(
				'* * 15 * 6-7',                 // 15th, Saturdays, and Sundays
				mktime(0, 0, 0, 11, 23, 2009),  // Monday, Nov 23, 2009
				mktime(0, 0, 0, 11, 28, 2009)   // Saturday, Nov 28, 2009
			),

			array(
				'* * 15,30 * 2',                // 15th, 30th, and Tuesdays
				mktime(0, 0, 0, 11, 29, 2009),  // Sunday, Nov 29, 2009
				mktime(0, 0, 0, 11, 30, 2009)   // Monday, Nov 30, 2009
			),

			array(
				'0 0 * * 4',                    // Midnight on Thursdays
				mktime(1, 0, 0, 11, 19, 2009),  // 01:00 Thursday, Nov 19, 2009
				mktime(0, 0, 0, 11, 26, 2009)   // 00:00 Thursday, Nov 26, 2009
			),

			array(
				'0 0 */2 * 4',                  // Midnight on odd days and Thursdays
				mktime(1, 0, 0, 11, 19, 2009),  // 01:00 Thursday, Nov 19, 2009
				mktime(0, 0, 0, 11, 21, 2009)   // 00:00 Saturday, Nov 21, 2009
			),
		);
	}
}
