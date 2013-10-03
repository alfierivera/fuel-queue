<?php
/**
 * Fuel Queue
 *
 * @package 	Fuel
 * @subpackage	Queue
 * @version		1.0
 * @author 		Márk Sági-Kazár <mark.sagikazar@gmail.com>
 * @license 	MIT License
 * @link 		https://github.com/indigo-soft
 */

Config::load('queue', true);

Autoloader::add_core_namespace('Queue');

Autoloader::add_classes(array(
	'Queue\\Queue'             => __DIR__ . '/classes/queue.php',
	'Queue\\Queue_Driver'      => __DIR__ . '/classes/queue/driver.php',
	'Queue\\QueueException'    => __DIR__ . '/classes/queue.php',

	'Queue\\Worker'            => __DIR__ . '/classes/worker.php',
	'Queue\\Worker_Driver'     => __DIR__ . '/classes/worker/driver.php',
	'Queue\\WorkerException'   => __DIR__ . '/classes/worker.php',


	'Queue\\Queue_Direct'      => __DIR__ . '/classes/queue/direct.php',

	'Queue\\Queue_Resque'      => __DIR__ . '/classes/queue/resque.php',
	'Queue\\Worker_Resque'     => __DIR__ . '/classes/worker/resque.php',

	'Queue\\Queue_Beanstalkd'  => __DIR__ . '/classes/queue/beanstalkd.php',
	'Queue\\Worker_Beanstalkd' => __DIR__ . '/classes/worker/beanstalkd.php',
));

if (\Fuel::$is_cli)
{
	$event = \Event::instance('queue');

	$event->register('resque_init', function(){
		if (class_exists('\\Resque_Event'))
		{
			\Resque_Event::listen('onFailure', function($e, $job) {
				if ($job instanceof \Resque_Job)
				{
					$instance = $job->getInstance();
					$instance->failure($e);
				}
			});
		}
	});
}
