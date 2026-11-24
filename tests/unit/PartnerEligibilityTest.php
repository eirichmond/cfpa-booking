<?php
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Duet, trio and quartet eligibility (Duncan's test data, moved on a year for the 2027
 * festival, so ages are taken on 31 August 2026).
 *
 * Class D26 - Cabaret Dance Duet - 9 and 10 years.
 */
class PartnerEligibilityTest extends TestCase {

	const LOWER = '9';
	const UPPER = '10';
	const TODAY = '2026-11-24';

	private function age( $dob ) {
		$public = ( new ReflectionClass( 'CFPA_Booking_System_Public' ) )->newInstanceWithoutConstructor();
		return $public->get_performers_age( $dob, self::TODAY );
	}

	public static function performers() {
		// name => [ dob, age on 31 Aug 2026, ok as performer 2 ]
		return array(
			'Rachel'        => array( '2016-12-26', 9, true ),
			'Rachel2'       => array( '2016-12-25', 9, true ),
			'SlightlyOlder' => array( '2015-12-26', 10, true ),
			'Younger'       => array( '2018-12-26', 7, true ),
			'Older'         => array( '2014-12-26', 11, false ),
		);
	}

	#[DataProvider( 'performers' )]
	public function test_age_is_taken_on_31_august_before_the_festival( $dob, $age ) {
		$this->assertSame( $age, $this->age( $dob ) );
	}

	#[DataProvider( 'performers' )]
	public function test_additional_performers_skip_the_minimum_age( $dob, $age, $ok ) {
		$this->assertSame( ! $ok, CFPA_Booking_System_Public::partner_outside_age( $this->age( $dob ), self::UPPER ) );
	}

	public function test_partner_below_minimum_age_is_allowed() {
		// a 11 year old partner in a 12 year old class
		$this->assertFalse( CFPA_Booking_System_Public::partner_outside_age( 11, '12' ) );
	}

	public function test_partner_at_maximum_age_is_allowed() {
		$this->assertFalse( CFPA_Booking_System_Public::partner_outside_age( 10, '10' ) );
	}

	public function test_partner_over_maximum_age_is_not_allowed() {
		$this->assertTrue( CFPA_Booking_System_Public::partner_outside_age( 11, '10' ) );
	}

	public function test_blank_or_zero_upper_age_means_no_limit() {
		$this->assertFalse( CFPA_Booking_System_Public::partner_outside_age( 80, '' ) );
		$this->assertFalse( CFPA_Booking_System_Public::partner_outside_age( 80, '0' ) );
	}

	public function test_age_reference_rolls_over_on_31_august() {
		// before 31 Aug 2026 ages are taken on 31 Aug 2025, from then on 31 Aug 2026
		$this->assertSame( 9, ( new ReflectionClass( 'CFPA_Booking_System_Public' ) )->newInstanceWithoutConstructor()->get_performers_age( '2015-12-26', '2026-08-30' ) );
		$this->assertSame( 10, ( new ReflectionClass( 'CFPA_Booking_System_Public' ) )->newInstanceWithoutConstructor()->get_performers_age( '2015-12-26', '2026-08-31' ) );
	}
}
