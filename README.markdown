# Kohana-Cron

This module provides a way to schedule tasks (jobs) within your Kohana application.


## Installation

Step 1: Download the module into your modules subdirectory.

Step 2: Enable the module in your bootstrap file:

	/**
	 * Enable modules. Modules are referenced by a relative or absolute path.
	 */
	Kohana::modules(array(
		'cron'       => MODPATH.'cron',
		// 'auth'       => MODPATH.'auth',       // Basic authentication
		// 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
		// 'database'   => MODPATH.'database',   // Database access
		// 'image'      => MODPATH.'image',      // Image manipulation
		// 'orm'        => MODPATH.'orm',        // Object Relationship Mapping
		// 'pagination' => MODPATH.'pagination', // Paging of results
		// 'userguide'  => MODPATH.'userguide',  // User guide and API documentation
	));


Step 3: Make sure the settings in `config/cron.php` are correct for your environment.
If not, copy the file to `application/config/cron.php` and change the values accordingly.


## Usage

In its simplest form, a task is a [PHP callback][1] and times at which it should run.
To configure a task call `Cron::set($name, array($frequency, $callback))` where
`$frequency` is a string of date and time fields identical to those found in [crontab][2].
For example,

	Cron::set('reindex_catalog', array('@daily', 'Catalog::regenerate_index'));
	Cron::set('calendar_notifications', array('*/5 * * * *', 'Calendar::send_emails'));

Configured tasks are run with their appropriate frequency by calling `Cron::run()`. Call
this method in your bootstrap file, and you're done!


## Advanced Usage

A task can also be an instance of `Cron` that extends `next()` and/or `execute()` as
needed. Such a task is configured by calling `Cron::set($name, $instance)`.

If you have access to the system crontab, you can run Cron less (or more) than once
every request. You will need to modify the lines where the request is handled in your
bootstrap file to prevent extraneous output. The default is:

	/**
	 * Execute the main request. A source of the URI can be passed, eg: $_SERVER['PATH_INFO'].
	 * If no source is specified, the URI will be automatically detected.
	 */
	echo Request::instance()
		->execute()
		->send_headers()
		->response;

Change it to:

	if ( ! defined('SUPPRESS_REQUEST'))
	{
		/**
		 * Execute the main request. A source of the URI can be passed, eg: $_SERVER['PATH_INFO'].
		 * If no source is specified, the URI will be automatically detected.
		 */
		echo Request::instance()
			->execute()
			->send_headers()
			->response;
	}

Then set up a system cron job to run your application's Cron once a minute:

	* * * * * /usr/bin/php -f /path/to/kohana/modules/cron/run.php

The included `run.php` should work for most cases, but you are free to call `Cron::run()`
in any way you see fit.


  [1]: http://php.net/manual/language.pseudo-types.php#language.types.callback
  [2]: http://linux.die.net/man/5/crontab
