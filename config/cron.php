<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * @package Cron
 *
 * @author      Chris Bandy
 * @copyright   (c) 2010 Chris Bandy
 * @license     http://www.opensource.org/licenses/isc-license.txt
 */

return array
(
	// Path to a writable directory and lock file
	'lock' => Kohana::$cache_dir.DIRECTORY_SEPARATOR.'cron.lck',

	/**
	 * Cron does not run EXACTLY when tasks are scheduled.
	 * A task can be executed up to this many seconds AFTER its scheduled time.
	 *
	 * For example, Cron is run at 10:48 and a task was scheduled to execute at
	 * 10:45, 180 seconds ago. If window is greater than 180, the task will be
	 * executed.
	 *
	 * This value should always be larger than the time it takes to run all
	 * your tasks.
	 */
	'window' => 300,
);
