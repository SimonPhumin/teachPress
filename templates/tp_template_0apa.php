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
		return '<table class="teachpress_publication_list">' . $content . '</table>';
	}

	/**
	 * Returns the headline for a publication list or a part of that
	 * @param type $content     The content of the headline
	 * @param type $args        An array with some basic settings for the publication list (source: shortcode settings)
	 * @return string
	 */
	public

	function get_headline( $content, $args = array() ) {
		return '<tr>
                    <td' . $args[ 'colspan' ] . '>
                        <h3 class="tp_h3" id="tp_h3_' . esc_attr( $content ) . '">' . $content . '</h3>
                    </td>
                </tr>';
	}

	/**
	 * Returns the headline (second level) for a publication list or a part of that
	 * @param type $content     The content of the headline
	 * @param type $args        An array with some basic settings for the publication list (source: shortcode settings)
	 * @return string
	 */
	public

	function get_headline_sl( $content, $args = array() ) {
		return '<tr>
                    <td' . $args[ 'colspan' ] . '>
                        <h4 class="tp_h4" id="tp_h4_' . esc_attr( $content ) . '">' . $content . '</h4>
                    </td>
                </tr>';
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
		$s = '<tr class="tp_publication">';
		$s .= $interface->get_number( '<td class="tp_pub_number">', '.</td>' );
		$s .= $interface->get_images( 'left' );
		$s .= '<td class="tp_pub_info">';
		//$s .= $interface->get_author('<p class="tp_pub_author">', '</p>');
		$s .= '<p class="tp_pub_author">' . $interface->get_author() . ' (' . $interface->get_year() . ').</p>';		
		//$s .= '' . $interface->get_editor() . ' (Eds.),';
		

		//Types: Journal Article, Conference, Book, Inproceedings, Technical Report, Incollection, Booklet, Masters Thesis, PhD Thesis
		
		if ( $interface->get_type2() == 'article' ) {
			
			$s .= '<p class="tp_pub_title">' . $interface->get_title() . '.</p>';
			$s .= '<p class="tp_pub_additional">';
			
			if ( $interface->get_journal() != "" ) {
				$s .= '<i>' . $interface->get_journal() . ', ';
			}
			if ( $interface->get_volume() != "" ) {
				if ( $interface->get_issueno() != "" ) {
					$s .= $interface->get_volume() . '</i> (' . $interface->get_issueno() . '). ';
				} else {
					$s .= $interface->get_volume() . '. </i> ';
				}
			}
			if ( $interface->get_pages() != "" ) {
				$s .= $interface->get_pages() . '. ';
			}
			
			$s .= '</p>';
			
		} elseif ( $interface->get_type2() == 'conference' ) {

			$s .= '<p class="tp_pub_title">' . $interface->get_title() . '.</p>';
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
				$s .= $interface->get_publisher() . '.';
			}
			
			$s .= '</p>';
			
		} elseif ( $interface->get_type2() == 'book' ) {

			$s .= '<p class="tp_pub_title"><i>' . $interface->get_title() . '.</i></p>';
			$s .= '<p class="tp_pub_additional">';
			
			if ( $interface->get_address() != "" ) {
				$s .= '' . $interface->get_address() . ': ';
			}
			if ( $interface->get_publisher() != "" ) {
				$s .= $interface->get_publisher() . '.';
			}
			
			$s .= '</p>';
			
		} elseif ( $interface->get_type2() == 'inproceedings' ) {

			$s .= '<p class="tp_pub_title">' . $interface->get_title() . '.</p>';
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
			
		} elseif ( $interface->get_type2() == 'techreport' ) {

			$s .= '<p class="tp_pub_title"><i>' . $interface->get_title() . '.</i></p>';
			$s .= '<p class="tp_pub_additional">';
			
			if ( $interface->get_address() != "" ) {
				$s .= '' . $interface->get_address() . ': ';
			}
			if ( $interface->get_institution() != "" ) {
				$s .= $interface->get_institution() . '.';
			}
			
			$s .= '</p>';
			
		} elseif ( $interface->get_type2() == 'booklet' ) {

			$s .= '<p class="tp_pub_title"><i>' . $interface->get_title() . '.</i></p>';
			$s .= '<p class="tp_pub_additional">';
			
			if ( $interface->get_address() != "" ) {
				$s .= '' . $interface->get_address() . '.';
			}	
			
			$s .= '</p>';
			
		} elseif ( $interface->get_type2() == 'mastersthesis' ||  $interface->get_type2() == 'phdthesis') {

			$s .= '<p class="tp_pub_title"><i>' . $interface->get_title() . '.</i></p>';
			$s .= '<p class="tp_pub_additional">';

			if ( $interface->get_address() != "" ) {
				$s .= '' . $interface->get_address() . ': ';
			}
			
			if ( $interface->get_school() != "" ) {
				$s .= '' . $interface->get_school() . '.';
			}	
			
			$s .= '</p>';
			
		} elseif ( $interface->get_type2() == 'incollection' ) {

			$s .= '<p class="tp_pub_title">' . $interface->get_title() . '.</p>';
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
			
			$s .= '<p class="tp_pub_title"><i>' . $interface->get_title() . '.</i></p>';
			
		}

		$s .= '<p class="tp_pub_tags">' . $interface->get_tag_line();
		$s .= $interface->get_type();
		$s .= '</p>';
		$s .= $interface->get_infocontainer();
		$s .= $interface->get_images( 'bottom' );
		$s .= '</td>';
		$s .= $interface->get_images( 'right' );
		$s .= '</tr>';
		return $s;
	}
}