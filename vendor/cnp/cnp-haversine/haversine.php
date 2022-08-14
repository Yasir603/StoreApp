<?php

/**
 * Class CnpPoi
 */
class CnpPoi {

	/**
	 * @var float
	 */
	private $latitude;

	/**
	 * @var float
	 */
	private $longitude;

	/**
	 * CnpPoi constructor.
	 *
	 * @param $latitude
	 * @param $longitude
	 */
	public function __construct( $latitude, $longitude ) {
		$this->latitude  = deg2rad( $latitude );
		$this->longitude = deg2rad( $longitude );
	}

	/**
	 * @return float
	 */
	public function getLatitude() {
		return $this->latitude;
	}

	/**
	 * @return float
	 */
	public function getLongitude() {
		return $this->longitude;
	}

	/**
	 * @param CnpPoi $other
	 *
	 * @return int
	 */
	public function getDistanceInMetersTo( CnpPoi $other ) {
		$radiusOfEarth = 6371000;// Earth's radius in meters.
		$diffLatitude  = $other->getLatitude() - $this->latitude;
		$diffLongitude = $other->getLongitude() - $this->longitude;
		$a             = sin( $diffLatitude / 2 ) * sin( $diffLatitude / 2 ) +
		                 cos( $this->latitude ) * cos( $other->getLatitude() ) *
		                 sin( $diffLongitude / 2 ) * sin( $diffLongitude / 2 );
		$c             = 2 * asin( sqrt( $a ) );
		$distance      = $radiusOfEarth * $c;

		return $distance;
	}

	/**
	 * @param CnpPoi $other
	 *
	 * @return int
	 */
	public function getDistanceInMilesTo( CnpPoi $other ) {
		$radiusOfEarth = 3959;// Earth's radius in miles.
		$diffLatitude  = $other->getLatitude() - $this->latitude;
		$diffLongitude = $other->getLongitude() - $this->longitude;
		$a             = sin( $diffLatitude / 2 ) * sin( $diffLatitude / 2 ) +
		                 cos( $this->latitude ) * cos( $other->getLatitude() ) *
		                 sin( $diffLongitude / 2 ) * sin( $diffLongitude / 2 );
		$c             = 2 * asin( sqrt( $a ) );
		$distance      = $radiusOfEarth * $c;

		return $distance;
	}

}
