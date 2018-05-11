<?php
/**
 * Contains a component class representing a table.
 *
 * @package Apple_News
 * @since 1.4.0
 */

namespace Apple_Exporter\Components;

/**
 * A component class representing a table.
 *
 * @since 1.4.0
 */
class Table extends Component {

	/**
	 * Look for node matches for this component.
	 *
	 * @param \DOMNode $node The node to inspect for matches.
	 *
	 * @access public
	 * @return \DOMNode|null The DOMNode if there is a match, null if not.
	 */
	public static function node_matches( $node ) {

		// First, check to see if the primary node is a table.
		if ( 'table' !== $node->nodeName ) {
			return null;
		}

		// In order to match, HTML support needs to be turned on globally.
		$settings = get_option( \Admin_Apple_Settings::$option_name );
		if ( empty( $settings['html_support'] )
			|| 'yes' !== $settings['html_support']
		) {
			return null;
		}

		return $node;
	}

	/**
	 * Register all specs for the component.
	 *
	 * @access public
	 */
	public function register_specs() {
		$this->register_spec(
			'json',
			__( 'JSON', 'apple-news' ),
			array(
				'role' => 'htmltable',
				'html' => '#html#',
				'style' => array(
					'border' => array(
						'all' => array(
							'color' => '#table_border_color#',
							'style' => '#table_border_style#',
							'width' => '#table_border_width#',
						),
					),
					'tableStyle' => array(
						'cells' => array(
							'backgroundColor' => '#table_body_background_color#',
							'horizontalAlignment' => '#table_body_horizontal_alignment#',
							'padding' => '#table_body_padding#',
							'textStyle' => array(
								'fontName' => '#table_body_font#',
								'fontSize' => '#table_body_size#',
								'lineHeight' => '#table_body_line_height#',
								'textColor' => '#table_body_color#',
								'tracking' => '#table_body_tracking#',
							),
							'verticalAlignment' => '#table_body_vertical_alignment#',
						),
						'columns' => array(
							'divider' => array(
								'color' => '#table_border_color#',
								'style' => '#table_border_style#',
								'width' => '#table_border_width#',
							),
						),
						'headerCells' => array(
							'backgroundColor' => '#table_header_background_color#',
							'horizontalAlignment' => '#table_header_horizontal_alignment#',
							'padding' => '#table_header_padding#',
							'textStyle' => array(
								'fontName' => '#table_header_font#',
								'fontSize' => '#table_header_size#',
								'lineHeight' => '#table_header_line_height#',
								'textColor' => '#table_header_color#',
								'tracking' => '#table_header_tracking#',
							),
							'verticalAlignment' => '#table_header_vertical_alignment#',
						),
						'headerRows' => array(
							'divider' => array(
								'color' => '#table_border_color#',
								'style' => '#table_border_style#',
								'width' => '#table_border_width#',
							),
						),
						'rows' => array(
							'divider' => array(
								'color' => '#table_border_color#',
								'style' => '#table_border_style#',
								'width' => '#table_border_width#',
							),
						),
					),
				),
			)
		);
	}

	/**
	 * Build the component.
	 *
	 * @param string $html The html to convert into a component.
	 *
	 * @access protected
	 */
	protected function build( $html ) {

		// If HTML is not enabled for this component, bail.
		if ( ! $this->html_enabled() ) {
			return;
		}

		/**
		 * Allows for table HTML to be filtered before being applied.
		 *
		 * @param string $html The raw HTML for the table.
		 *
		 * @since 1.4.0
		 */
		$html = apply_filters(
			'apple_news_build_table_html',
			$this->parser->parse( $html )
		);

		// If we don't have any table HTML at this point, bail.
		if ( empty( $html ) ) {
			return;
		}

		// Add the JSON for this component.
		$this->register_json(
			'json',
			array(
				'#html#' => $html,
			)
		);
	}

	/**
	 * Whether HTML format is enabled for this component type.
	 *
	 * @param bool $enabled Optional. Whether to enable HTML support for this component. Defaults to true.
	 *
	 * @access protected
	 * @return bool Whether HTML format is enabled for this component type.
	 */
	protected function html_enabled( $enabled = true ) {
		return parent::html_enabled( $enabled );
	}
}