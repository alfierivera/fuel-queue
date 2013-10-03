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

namespace Queue;

class Queue_Direct extends Queue_Driver
{

	protected function _init() {}

	protected function _push($job, array $args = array())
	{

		$job = new $job;
		$job->args = $args;

		$job->before();
		$job->run();
		$job->after();
	}
}
