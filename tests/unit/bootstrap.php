<?php
/**
 * Bootstrap for the unit tests: pure logic only, no WordPress test library needed.
 *
 * Run from the plugin root: phpunit -c tests/unit/phpunit.xml
 */
define( 'ABSPATH', __DIR__ );
require_once dirname( __DIR__, 2 ) . '/public/class-cfpa-bookingsystem-public.php';
