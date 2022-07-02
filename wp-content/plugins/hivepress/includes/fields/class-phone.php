<?php
/**
 * Phone field.
 *
 * @package HivePress\Fields
 */

namespace HivePress\Fields;

use HivePress\Helpers as hp;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Phone number.
 */
class Phone extends Text {

	/**
	 * Country codes.
	 *
	 * @var array
	 */
	protected $countries = [];

	/**
	 * Class initializer.
	 *
	 * @param array $meta Class meta values.
	 */
	public static function init( $meta = [] ) {
		$meta = hp\merge_arrays(
			[
				'label'      => esc_html__( 'Phone', 'hivepress' ),
				'filterable' => false,
				'sortable'   => false,

				'settings'   => [
					'min_length' => null,
					'max_length' => null,
					'pattern'    => null,

					'countries'  => [
						'label'       => esc_html__( 'Countries', 'hivepress' ),
						'description' => esc_html__( 'Select countries to restrict the available calling codes.', 'hivepress' ),
						'type'        => 'select',
						'options'     => 'countries',
						'multiple'    => true,
						'_order'      => 110,
					],
				],
			],
			$meta
		);

		parent::init( $meta );
	}

	/**
	 * Class constructor.
	 *
	 * @param array $args Field arguments.
	 */
	public function __construct( $args = [] ) {
		$args = hp\merge_arrays(
			$args,
			[
				'display_type' => 'tel',
				'pattern'      => '\+?[0-9]+',
				'max_length'   => 24,
			]
		);

		parent::__construct( $args );
	}

	/**
	 * Bootstraps field properties.
	 */
	protected function boot() {
		$attributes = [];

		// Set countries.
		if ( $this->countries ) {
			$attributes['data-countries'] = wp_json_encode( $this->countries );
		}

		// Set utils URL.
		$attributes['data-utils'] = hivepress()->get_url() . '/assets/js/intl-tel-input/utils.min.js';

		// Set component.
		$attributes['data-component'] = 'phone';

		$this->attributes = hp\merge_arrays( $this->attributes, $attributes );

		parent::boot();
	}
}
