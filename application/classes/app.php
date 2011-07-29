<?php
/**
 * Created by JetBrains PhpStorm.
 * User: paul
 * Date: 7/28/11
 * Time: 11:43 PM
 * To change this template use File | Settings | File Templates.
 */
 
class App {
	const cacheIncrement = 1;

	/**
	 * Get a cache constant, useful for forcing the reload of cached files on browsers.
	 *
	 * @static
	 * @return int|string
	 */
	public static function c() {
		if(Kohana::$environment == Kohana::PRODUCTION) {
			return self::cacheIncrement;
		} else {
			return self::cacheIncrement;
		}
	}
}
