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
		return '<div class="tp_headline_2 col-12"><h2 class="tp_h2" id="tp_h2_' . esc_attr( $content ) . '">' . $content . '</h2></div>';
	}

	/**
	 * Returns the headline (second level) for a publication list or a part of that
	 * @param type $content     The content of the headline
	 * @param type $args        An array with some basic settings for the publication list (source: shortcode settings)
	 * @return string
	 */
	public

	function get_headline_sl( $content, $args = array() ) {
		return '<div class="tp_headline_3 col-12"><h3 class="tp_h3" id="tp_h3_' . esc_attr( $content ) . '">' . $content . '</h3></div>';
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
		$pub_content = '<article class="col-12 tp_publication">';
		
		$pub_content .= '<div class="tp_pub_info">';
		$pub_content .= '<p class="tp_pub_author">' . $interface->get_author() . ' (' . $interface->get_year() . ').</p>';

		// Journal Article
		if ( $interface->get_type2() == 'article' ) {
			
			$pub_content .= '<h4 class="tp_pub_title">' . $interface->get_title() . '.</h4>';
			$pub_content .= '<p class="tp_pub_additional">';
			
			if ( $interface->get_journal() != "" ) {
				$pub_content .= '' . $interface->get_journal() . ', ';
			}
			if ( $interface->get_volume() != "" ) {
				if ( $interface->get_issueno() != "" ) {
					$pub_content .= $interface->get_volume() . ' (' . $interface->get_issueno() . '). ';
				} else {
					$pub_content .= $interface->get_volume() . '.';
				}
			}
			if ( $interface->get_pages() != "" ) {
				$pub_content .= $interface->get_pages() . '. ';
			}
			
			$pub_content .= '</p>';
		
		// Conference	
		} elseif ( $interface->get_type2() == 'conference' ) {

			$pub_content .= '<h4 class="tp_pub_title">' . $interface->get_title() . '.</h4>';
			$pub_content .= '<p class="tp_pub_additional">';

			if ( $interface->get_booktitle() != "" ) {
				if ( $interface->get_editor() != "" && $interface->get_editor() != " , ." ) {
					$pub_content .= 'In ' . $interface->get_editor() . ' (Eds.), ' . $interface->get_booktitle() . '. ';
				} else {
					$pub_content .= 'In ' . $interface->get_booktitle() . '.';
				}
			}
			if ( $interface->get_address() != "" ) {
				$pub_content .= $interface->get_address() . ': ';
			}
			if ( $interface->get_publisher() != "" ) {
				$pub_content .= $interface->get_publisher() . '.';
			}
			
			$pub_content .= '</p>';
		
		// Book	
		} elseif ( $interface->get_type2() == 'book' ) {

			$pub_content .= '<h4 class="tp_pub_title">' . $interface->get_title() . '.</h4>';
			$pub_content .= '<p class="tp_pub_additional">';
			
			if ( $interface->get_address() != "" ) {
				$pub_content .= '' . $interface->get_address() . ': ';
			}
			if ( $interface->get_publisher() != "" ) {
				$pub_content .= $interface->get_publisher() . '.';
			}
			
			$pub_content .= '</p>';
		
		// Inproceedings	
		} elseif ( $interface->get_type2() == 'inproceedings' ) {

			$pub_content .= '<h4 class="tp_pub_title">' . $interface->get_title() . '.</h4>';
			$pub_content .= '<p class="tp_pub_additional">';

			if ( $interface->get_booktitle() != "" ) {
				if ( $interface->get_editor() != "" && $interface->get_editor() != " , ." ) {
					$pub_content .= 'In ' . $interface->get_editor() . ' (Eds.), ' . $interface->get_booktitle() . '. ';
				} else {
					$pub_content .= 'In ' . $interface->get_booktitle() . '. ';
				}
			}
			if ( $interface->get_address() != "" ) {
				$pub_content .= $interface->get_address() . ': ';
			}
			if ( $interface->get_publisher() != "" ) {
				$pub_content .= $interface->get_publisher() . ', ';
			}
			if ( $interface->get_pages() != "" ) {
				$pub_content .= $interface->get_pages() . '.';
			}
			
			$pub_content .= '</p>';
		
		// Technical report	
		} elseif ( $interface->get_type2() == 'techreport' ) {

			$pub_content .= '<h4 class="tp_pub_title">' . $interface->get_title() . '.</h4>';
			$pub_content .= '<p class="tp_pub_additional">';
			
			if ( $interface->get_address() != "" ) {
				$pub_content .= '' . $interface->get_address() . ': ';
			}
			if ( $interface->get_institution() != "" ) {
				$pub_content .= $interface->get_institution() . '.';
			}
			
			$pub_content .= '</p>';
		
		// Booklet	
		} elseif ( $interface->get_type2() == 'booklet' ) {

			$pub_content .= '<h4 class="tp_pub_title">' . $interface->get_title() . '.</h4>';
			$pub_content .= '<p class="tp_pub_additional">';
			
			if ( $interface->get_address() != "" ) {
				$pub_content .= '' . $interface->get_address() . '.';
			}	
			
			$pub_content .= '</p>';
		
		// Masters thesis
		} elseif ( $interface->get_type2() == 'mastersthesis' ||  $interface->get_type2() == 'phdthesis') {

			$pub_content .= '<h4 class="tp_pub_title">' . $interface->get_title() . '.</h4>';
			$pub_content .= '<p class="tp_pub_additional"><em>';

			if ( $interface->get_address() != "" ) {
				$pub_content .= '' . $interface->get_address() . ': ';
			}
			
			if ( $interface->get_school() != "" ) {
				$pub_content .= '' . $interface->get_school() . '.';
			}	
			
			$pub_content .= '</em></p>';
		
		// Incollection	
		} elseif ( $interface->get_type2() == 'incollection' ) {

			$pub_content .= '<h4 class="tp_pub_title">' . $interface->get_title() . '.</h4>';
			$pub_content .= '<p class="tp_pub_additional">';

			if ( $interface->get_booktitle() != "" ) {
				if ( $interface->get_editor() != "" && $interface->get_editor() != " , ." ) {
					$pub_content .= 'In <em>' . $interface->get_editor() . ' (Eds.), ' . $interface->get_booktitle() . '. </em>';
				} else {
					$pub_content .= 'In <em>' . $interface->get_booktitle() . '. </em>';
				}
			}
			if ( $interface->get_address() != "" ) {
				$pub_content .= $interface->get_address() . ': ';
			}
			if ( $interface->get_publisher() != "" ) {
				$pub_content .= $interface->get_publisher() . ', ';
			}
			if ( $interface->get_pages() != "" ) {
				$pub_content .= $interface->get_pages() . '.';
			}
			
			$pub_content .= '</p>';
			
		} else{
			
			$pub_content .= '<h4 class="tp_pub_title">' . $interface->get_title() . '.</h4>';
			
		}
		$pub_content .= $interface->get_type();
		$pub_content .= '<p class="tp_pub_tags">' . $interface->get_tag_line();
		$pub_content .= '<span class="tp_apa_link"><a id="tp_apa_sh_' . $interface->get_container_no() . '" class="tp_apa_close" onclick="teachpress_pub_showhide(\'';
		$pub_content .= $interface->get_container_no() . '\'';
		$pub_content .= ',\'tp_apa\')">APA-Style</a></span>';
		$pub_content .= '</p>';
		
		$pub_content .= $interface->get_infocontainer();
		$pub_content .= '<div class="tp_apa" id="tp_apa_' . $interface->get_container_no() . '">';
		//open <p> paragraph
		$pub_content .= '<p>' . $interface->get_author() . ' (' . $interface->get_year() . '). ';
		// Journal Article
		if ( $interface->get_type2() == 'article' ) {
			
			$pub_content .= '' . $interface->get_title() . '. ';
			
			if ( $interface->get_journal() != "" ) {
				$pub_content .= '<em>' . $interface->get_journal() . ', ';
			}
			if ( $interface->get_volume() != "" ) {
				if ( $interface->get_issueno() != "" ) {
					$pub_content .= $interface->get_volume() . '</em> (' . $interface->get_issueno() . '). ';
				} else {
					$pub_content .= $interface->get_volume() . '. </em>';
				}
			}
			if ( $interface->get_pages() != "" ) {
				$pub_content .= $interface->get_pages() . '. ';
			}
			
		
		// Conference	
		} elseif ( $interface->get_type2() == 'conference' ) {

			$pub_content .= '' . $interface->get_title() . '. ';

			if ( $interface->get_booktitle() != "" ) {
				if ( $interface->get_editor() != "" && $interface->get_editor() != " , ." ) {
					$pub_content .= 'In ' . $interface->get_editor() . ' (Eds.), <em>' . $interface->get_booktitle() . '. </em>';
				} else {
					$pub_content .= 'In <em>' . $interface->get_booktitle() . '. </em>';
				}
			}
			if ( $interface->get_address() != "" ) {
				$pub_content .= $interface->get_address() . ': ';
			}
			if ( $interface->get_publisher() != "" ) {
				$pub_content .= $interface->get_publisher() . '.';
			}
			
		
		// Book	
		} elseif ( $interface->get_type2() == 'book' ) {

			$pub_content .= '<em>' . $interface->get_title() . '. </em>';
			
			if ( $interface->get_address() != "" ) {
				$pub_content .= '' . $interface->get_address() . ': ';
			}
			if ( $interface->get_publisher() != "" ) {
				$pub_content .= $interface->get_publisher() . '.';
			}
			
		
		// Inproceedings	
		} elseif ( $interface->get_type2() == 'inproceedings' ) {

			$pub_content .= '' . $interface->get_title() . '. ';

			if ( $interface->get_booktitle() != "" ) {
				if ( $interface->get_editor() != "" && $interface->get_editor() != " , ." ) {
					$pub_content .= 'In ' . $interface->get_editor() . ' (Eds.), <em>' . $interface->get_booktitle() . '. </em>';
				} else {
					$pub_content .= 'In <em>' . $interface->get_booktitle() . '. </em>';
				}
			}
			if ( $interface->get_address() != "" ) {
				$pub_content .= $interface->get_address() . '';
			}
			if ( $interface->get_publisher() != "" ) {
				$pub_content .= ': ' . $interface->get_publisher() . ', ';
			}
			if ( $interface->get_pages() != "" ) {
				$pub_content .= ': ' . $interface->get_pages() . '.';
			}
			else {
				$pub_content .= '.';
			}
			
			
		
		// Technical report	
		} elseif ( $interface->get_type2() == 'techreport' ) {

			$pub_content .= '<em>' . $interface->get_title() . '. </em>';
			
			if ( $interface->get_address() != "" ) {
				$pub_content .= '' . $interface->get_address() . ': ';
			}
			if ( $interface->get_institution() != "" ) {
				$pub_content .= $interface->get_institution() . '.';
			}
			
		
		// Booklet	
		} elseif ( $interface->get_type2() == 'booklet' ) {

			$pub_content .= '<em>' . $interface->get_title() . '. </em>';
			//$pub_content .= '<p>';
			
			if ( $interface->get_address() != "" ) {
				$pub_content .= '' . $interface->get_address() . '.';
			}	
	
		
		// Masters thesis
		} elseif ( $interface->get_type2() == 'mastersthesis' ||  $interface->get_type2() == 'phdthesis') {

			$pub_content .= '<em>' . $interface->get_title() . '. </em>';

			if ( $interface->get_address() != "" ) {
				$pub_content .= '' . $interface->get_address() . ': ';
			}
			
			if ( $interface->get_school() != "" ) {
				$pub_content .= '' . $interface->get_school() . '.';
			}	
			
		
		// Incollection	
		} elseif ( $interface->get_type2() == 'incollection' ) {

			$pub_content .= '' . $interface->get_title() . '. ';

			if ( $interface->get_booktitle() != "" ) {
				if ( $interface->get_editor() != "" && $interface->get_editor() != " , ." ) {
					$pub_content .= 'In ' . $interface->get_editor() . ' (Eds.), <em>' . $interface->get_booktitle() . '. </em>';
				} else {
					$pub_content .= 'In <em>' . $interface->get_booktitle() . '. </em>';
				}
			}
			if ( $interface->get_address() != "" ) {
				$pub_content .= $interface->get_address() . ': ';
			}
			if ( $interface->get_publisher() != "" ) {
				$pub_content .= $interface->get_publisher() . ', ';
			}
			if ( $interface->get_pages() != "" ) {
				$pub_content .= $interface->get_pages() . '.';
			}
			
			
		} else{
			
			$pub_content .= '<em>' . $interface->get_title() . '. </em>';
			
		}
		//close <p> paragraph
		$pub_content .= '</p>';
		$pub_content .= '<p class="tp_close_menu"><a class="tp_close" onclick="teachpress_pub_showhide(\'';

		$pub_content .= $interface->get_container_no() . '\'';
		$pub_content .= ',\'tp_apa\')">Close</a></p>';
		
		$pub_content .= '</article>';
		return $pub_content;
	}
}