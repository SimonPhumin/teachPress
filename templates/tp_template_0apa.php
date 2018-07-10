<?php
/**
 * teachPress template file
 * @package teachpress\core\templates
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPLv2 or later
 * @since 6.0.0
 */

class tp_template_0apa
implements tp_publication_template {
	/**
	 * Returns the settings of the template
	 * @return array
	 */
	public

	function get_settings() {
		return array( 'name' => 'teachPress APA 2018',
			'description' => 'Show Publications in APA-Style.',
			'author' => 'Joel Rixen / Simon Schweikert',
			'version' => '1.0',
			'button_separator' => ' ',
			'citation_style' => 'APA'
		);
	}

	/**
	 * Returns the body element for a publication list
	 * @param string $content   The content of the publication list itself
	 * @param array $args       An array with some basic settings for the publication list 
	 * @return string
	 */
	public


	/*function get_body( $content, $args = array() ) {
		return '<table class="teachpress_publication_list"><form method="post"><select name="show_all" onchange="this.form.submit()">
		<option value="0">No. of entries per page</option>
		<option value="1">Show 10 entries per page</option>
		<option value="2">Show all entries</option></select></form>' . $content . '</table>';
	}*/

	function get_body( $content, $args = array() ) {
		return '<div class="row teachpress_publication_list">' . $content . '</div>';
	}

	/**
	 * Returns the headline for a publication list or a part of that
	 * @param type $content     The content of the headline
	 * @param type $args        An array with some basic settings for the publication list (source: shortcode settings)
	 * @return string
	 */
	public

	function get_headline( $content, $args = array() ) {
		return '<div class="col-12 ' . $args[ 'colspan' ] . '>
                        <h2 class="tp_h3" id="tp_h3_' . esc_attr( $content ) . '">' . $content . '</h2>
                </div>';
	}

	/**
	 * Returns the headline (second level) for a publication list or a part of that
	 * @param type $content     The content of the headline
	 * @param type $args        An array with some basic settings for the publication list (source: shortcode settings)
	 * @return string
	 */
	public

	function get_headline_sl( $content, $args = array() ) {
		return '<div class="col-12 ' . $args[ 'colspan' ] . '>
                        <h3 class="tp_h4" id="tp_h4_' . esc_attr( $content ) . '">' . $content . '</h3>
                </div>';
	}

	/**
	 * Returns the single entry of a publication list
	 * 
	 * Contents of the interface data array (available over $interface->get_data()):
	 *   'row'               => An array of the related publication data
	 *   'title'             => The title of the publication (completely prepared for HTML output)
	 *   'images'            => The images array (HTML code for left, bottom, right)
	 *   'tag_line'          => The HTML tag string
	 *   'settings'          => The settings array (shortcode options)
	 *   'counter'           => The publication counter (integer)
	 *   'all_authors'       => The prepared author string
	 *   'keywords'          => An array of related keywords
	 *   'container_id'      => The ID of the HTML container
	 *   'template_settings' => The template settings array (name, description, author, citation_style)
	 * 
	 * @param object $interface     The interface object
	 * @return string
	 */
	public

	function get_entry( $interface ) {
		$s = '<article class="col-12 tp_publication">';
		$s .= '<div class="row">';
		$s .= '<div class="tp_pub_info col-12 col-md-10 col-lg-10 col-xl-10">';
		$s .= '<p class="tp_pub_author">' . $interface->get_author() . ' (' . $interface->get_year() . ').</p>';		

		
		// Journal Article
		if ( $interface->get_type2() == 'article' ) {
			
			$s .= '<h4 class="tp_pub_title"><em>' . $interface->get_title() . '.</em></h4>';
			$s .= '<p class="tp_pub_additional">';
			
			if ( $interface->get_journal() != "" ) {
				$s .= '' . $interface->get_journal() . ', ';
			}
			if ( $interface->get_volume() != "" ) {
				if ( $interface->get_issueno() != "" ) {
					$s .= $interface->get_volume() . ' (' . $interface->get_issueno() . ').';
				} else {
					$s .= $interface->get_volume() . '.';
				}
			}
			if ( $interface->get_pages() != "" ) {
				$s .= $interface->get_pages() . '. ';
			}
			
			$s .= '</p>';
		
		// Conference	
		} elseif ( $interface->get_type2() == 'conference' ) {

			$s .= '<h4 class="tp_pub_title">' . $interface->get_title() . '.</h4>';
			$s .= '<p class="tp_pub_additional">';

			if ( $interface->get_booktitle() != "" ) {
				if ( $interface->get_editor() != "" && $interface->get_editor() != " , ." ) {
					$s .= 'In ' . $interface->get_editor() . ' (Eds.), ' . $interface->get_booktitle() . '.';
				} else {
					$s .= 'In ' . $interface->get_booktitle() . '.';
				}
			}
			if ( $interface->get_address() != "" ) {
				$s .= $interface->get_address() . ': ';
			}
			if ( $interface->get_publisher() != "" ) {
				$s .= $interface->get_publisher() . '.';
			}
			
			$s .= '</p>';
		
		// Book	
		} elseif ( $interface->get_type2() == 'book' ) {

			$s .= '<h4 class="tp_pub_title"><i>' . $interface->get_title() . '.</i></h4>';
			$s .= '<p class="tp_pub_additional">';
			
			if ( $interface->get_address() != "" ) {
				$s .= '' . $interface->get_address() . ': ';
			}
			if ( $interface->get_publisher() != "" ) {
				$s .= $interface->get_publisher() . '.';
			}
			
			$s .= '</p>';
		
		// Inproceedings	
		} elseif ( $interface->get_type2() == 'inproceedings' ) {

			$s .= '<h4 class="tp_pub_title">' . $interface->get_title() . '.</h4>';
			$s .= '<p class="tp_pub_additional">';

			if ( $interface->get_booktitle() != "" ) {
				if ( $interface->get_editor() != "" && $interface->get_editor() != " , ." ) {
					$s .= 'In ' . $interface->get_editor() . ' (Eds.), ' . $interface->get_booktitle() . '.';
				} else {
					$s .= 'In ' . $interface->get_booktitle() . '.';
				}
			}
			if ( $interface->get_address() != "" ) {
				$s .= $interface->get_address() . ': ';
			}
			if ( $interface->get_publisher() != "" ) {
				$s .= $interface->get_publisher() . ', ';
			}
			if ( $interface->get_pages() != "" ) {
				$s .= $interface->get_pages() . '.';
			}
			
			$s .= '</p>';
		
		// Technical report	
		} elseif ( $interface->get_type2() == 'techreport' ) {

			$s .= '<h4 class="tp_pub_title"><i>' . $interface->get_title() . '.</i></h4>';
			$s .= '<p class="tp_pub_additional">';
			
			if ( $interface->get_address() != "" ) {
				$s .= '' . $interface->get_address() . ': ';
			}
			if ( $interface->get_institution() != "" ) {
				$s .= $interface->get_institution() . '.';
			}
			
			$s .= '</p>';
		
		// Booklet	
		} elseif ( $interface->get_type2() == 'booklet' ) {

			$s .= '<h4 class="tp_pub_title"><i>' . $interface->get_title() . '.</i></h4>';
			$s .= '<p class="tp_pub_additional">';
			
			if ( $interface->get_address() != "" ) {
				$s .= '' . $interface->get_address() . '.';
			}	
			
			$s .= '</p>';
		
		// Masters thesis
		} elseif ( $interface->get_type2() == 'mastersthesis' ||  $interface->get_type2() == 'phdthesis') {

			$s .= '<h4 class="tp_pub_title"><i>' . $interface->get_title() . '.</i></h4>';
			$s .= '<p class="tp_pub_additional">';

			if ( $interface->get_address() != "" ) {
				$s .= '' . $interface->get_address() . ': ';
			}
			
			if ( $interface->get_school() != "" ) {
				$s .= '' . $interface->get_school() . '.';
			}	
			
			$s .= '</p>';
		
		// Incollection	
		} elseif ( $interface->get_type2() == 'incollection' ) {

			$s .= '<h4 class="tp_pub_title">' . $interface->get_title() . '.</h4>';
			$s .= '<p class="tp_pub_additional">';

			if ( $interface->get_booktitle() != "" ) {
				if ( $interface->get_editor() != "" && $interface->get_editor() != " , ." ) {
					$s .= 'In ' . $interface->get_editor() . ' (Eds.), <i>' . $interface->get_booktitle() . '. </i>';
				} else {
					$s .= 'In <i>' . $interface->get_booktitle() . '. </i>';
				}
			}
			if ( $interface->get_address() != "" ) {
				$s .= $interface->get_address() . ': ';
			}
			if ( $interface->get_publisher() != "" ) {
				$s .= $interface->get_publisher() . ', ';
			}
			if ( $interface->get_pages() != "" ) {
				$s .= $interface->get_pages() . '.';
			}
			
			$s .= '</p>';
			
		} else{
			
			$s .= '<h4 class="tp_pub_title"><i>' . $interface->get_title() . '.</i></h4>';
			
		}

		$s .= '<p class="tp_pub_tags">' . $interface->get_tag_line();
		
		$s .= '</p>';
		$s .= '</div>';
		$s .= '<div class="col-12 col-md-2 col-lg-2 col-xl-2">' . $interface->get_type() . '</div>';
		$s .= '</div>';
		$s .= $interface->get_infocontainer();
		$s .= '</article>';
		return $s;
	}
}