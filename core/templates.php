<?php
/**
 * Template functions for displaying publications in HTML
 * @package teachpress\core\templates
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPLv2 or later
 * @since 6.0.0
 */

/**
 * Interface for the template classes
 * @since 6.0.0
 */
interface tp_publication_template {
    /**
     * Returns the settings of the template
     * @return array
     * @since 6.0.0
     */
    public function get_settings();
    
    /**
     * Returns the body element for a publication list
     * @param string $content   The content of the publication list itself
     * @param array $args       An array with some basic settings for the publication list (colspan, user, sort_list, headline, number_publications, years)
     * @return string
     * @since 6.0.0
     */
    public function get_body($content, $args = array());
    
    /**
     * Returns the headline for a publication list or a part of that
     * @param string $content     The content of the headline
     * @param array $args        An array with some basic settings for the publication list (colspan, user, sort_list, headline, number_publications, years)
     * @return string
     * @since 6.0.0
     */
    public function get_headline($content, $args = array());
    
    /**
     * Returns the headline (second level) for a publication list or a part of that
     * @param string $content     The content of the headline
     * @param array $args        An array with some basic settings for the publication list (colspan, user, sort_list, headline, number_publications, years)
     * @return string
     * @since 6.0.0
     */
    public function get_headline_sl($content, $args = array());
    
    /**
     * Returns the single entry of a publication list
     * @param object $interface     The interface object
     * @return string
     * @since 6.0.0
     */
    public function get_entry($interface);
}

/**
 * Contains all interface functions for publication templates
 * @since 6.0.0
 */
class tp_publication_interface {
    protected $data;
    
    /**
     * Returns the data for a publication row
     * @return array
     * @since 6.0.0
     * @access public
     */
    public function get_data() {
        return $this->data;
    }
    
    /**
     * Sets the data for a publication row
     * @param array $data
     * @since 6.0.0
     * @access public
     */
    public function set_data($data) {
        $this->data = $data;
    }
    
    /**
     * Generates a span element for the selected publication data field
     * @param string $element   The data field (for example: status, journal, type )
     * @param array $values     An array of values of the data field, which should be considered as labels
     * @return string
     * @since 6.0.0
     * @access public
     */
    public function get_label ($element, $values = array()) {
        $data = ( isset ($this->data['row'][$element]) ) ? $this->data['row'][$element] : '' ;
        if ( $data === '' ) {
            return '';
        }

        if ( in_array($data, $values) ) {
            $title = ( $element === 'status' && $data === 'forthcoming' ) ? __('Forthcoming','teachpress') : $data;
            // Replace possible chars from the meta data system
            $title = str_replace(array('{','}'), array('',''), $title);
            return '<span class="tp_pub_label_' . $element . ' ' . esc_attr($data) . '">' . $title . '</span>';
        }
    }
    
    /**
     * Returns the number for a numbered publication list
     * @param string $before
     * @param string $after
     * @return string
     * @since 6.0.0
     * @access public
     */
    public function get_number ($before = '', $after = '') {
        $settings = $this->data['settings'];
        
        if ( $settings['style'] === 'std_num' || $settings['style'] === 'std_num_desc' || $settings['style'] === 'numbered' || $settings['style'] === 'numbered_desc' ) {
            return $before . $this->data['counter'] . $after;
        }
        
        return '';
    } 
    
    /**
     * Returns the title
     * @return string
     * @since 6.0.0
     * @access public
     */
    public function get_title () {
        return $this->data['title'];
    }
    
    /**
     * Returns the type of a publication
     * @return string
     * @since 6.0.0
     * @access public
     */
    public function get_type() {
        $type = $this->data['row']['type'];
        return '<span class="tp_pub_type ' . $type . '">' . tp_translate_pub_type($type) . '</span>';
    }
    
    /**
     * Returns the authors
     * @param string $before
     * @param string $after
     * @return string
     * @since 6.0.0
     * @access public
     */
    public function get_author ($before = '', $after = '') {
        if ( $this->data['row']['author'] === '' && $this->data['row']['editor'] === '' ) {
            return '';
        }
        return $before . $this->data['all_authors']  . $after;
    }
    
    /**
     * Returns the meta row
     * @return string
     * @since 6.0.0
     * @access public
     */
    public function get_meta () {
        return tp_html::get_publication_meta_row($this->data['row'], $this->data['settings']);
    }

     /**
     * --------------------------------------HCI-GROUP Custom Functions---------------------
     * APA-Style functions
     */

    public function get_title_linkless () {
        return tp_html::prepare_title($row['title'], 'decode');
    }
    public function get_container_no () {
        return $this->data['container_id'];
    }
    public function get_booktitle () {
        return $this->data['row']['booktitle'];
    }
    
    public function get_address () {
        return $this->data['row']['address'];
    }
    
    public function get_publisher () {
        return $this->data['row']['publisher'];
    }
    
    public function get_type2 () {
        return $this->data['row']['type'];
    }
    
    public function get_volume () {
        return $this->data['row']['volume'];
    }
    
    public function get_issueno () {
        return $this->data['row']['number'];
    }
    
    public function get_pages () {
        return $this->data['row']['pages'];
    }
    
    public function get_journal () {
        return $this->data['row']['journal'];
    }
    
    public function get_institution () {
        return $this->data['row']['institution'];
    }
    
    public function get_chapter () {
        return $this->data['row']['chapter'];
    }
    
    public function get_school () {
        return $this->data['row']['school'];
    }
    
    public function get_editor ($before = '', $after = '') {
        if ( $this->data['row']['author'] === '' && $this->data['row']['editor'] === '' ) {
            return '1';
        }
        return $before . $this->data['all_editors']  . $after;
    }

    /**
     * Returns the tags
     * @param string $before
     * @param string $after
     * @return string
     * @since 6.0.0
     * @access public
     */
    public function get_tag_line_hci ($before = '', $after = '') {
        $tag_string = $this->data['tag_line'];
        $separator = $this->data['template_settings']['button_separator'];
        
        // meta line formatting
        if ( $tag_string !== '' ) {
            // Hack fix: Replace empty sections in tag string
            $tag_string = str_replace('| <span class="tp_resource_link"> |', ' | ', $tag_string);
            $length = mb_strlen($separator);
            $last_chars = mb_substr($tag_string, -$length);
            $tag_string = ( $last_chars === $separator ) ? mb_substr($tag_string, 0, -$length) : $tag_string;
            $tag_string = $before . $tag_string . $after;
        }
        return $tag_string;
    }



     /**
     * --------------------------------------HCI-GROUP Custom Functions---------------------
     */
    
    /**
     * Returns the tags
     * @param string $before
     * @param string $after
     * @return string
     * @since 6.0.0
     * @access public
     */
    public function get_tag_line ($before = '', $after = '') {
        $tag_string = $this->data['tag_line'];
        $separator = $this->data['template_settings']['button_separator'];
        
        // meta line formatting
        if ( $tag_string !== '' ) {
            // Hack fix: Replace empty sections in tag string
            $tag_string = str_replace('| <span class="tp_resource_link"> |', ' | ', $tag_string);
            $length = mb_strlen($separator);
            $last_chars = mb_substr($tag_string, -$length);
            $tag_string = ( $last_chars === $separator ) ? mb_substr($tag_string, 0, -$length) : $tag_string;
            $tag_string = $before . $tag_string . $after;
        }
        return $tag_string;
    }
    
    /**
     * Checks if a publication has a specific tag
     * @param string $tag_name
     * @return boolean
     * @since 6.2.3
     * @access public
     */
    public function has_tag ($tag_name) {
        $tags = $this->data['keywords'];
        foreach ( $tags as $single_array ) {
            if (in_array($tag_name, $single_array) ) {
                return true;
            }
        }

        return false;
    }
    
    /**
     * Returns the year
     * @return string
     * @since 6.0.0
     * @access public
     */
    public function get_year () {
        return $this->data['row']['year'];
    }
    
    /**
     * Returns the images
     * @param string $position
     * @return string
     * @since 6.0.0
     * @access public
     */
    public function get_images ($position) {
        if ( $position === 'right' ) {
            return $this->data['images']['right'];
        }
        if ( $position === 'left' ) {
            return $this->data['images']['left'];
        }
        if ( $position === 'bottom' ) {
            return $this->data['images']['bottom'];
        }
    }
    
    /**
     * Returns an info container
     * @return string
     * @since 6.0.0
     * @access public
     */
    public function get_infocontainer () {
        $content = '';
        $row = $this->data['row'];
        $keywords = $this->data['keywords'];
        $settings = $this->data['settings'];
        $container_id = $this->data['container_id'];

        // div altmetric
        if ( $settings['show_altmetric_entry']  && $row['doi'] != '' ) {
            $content .= tp_html_publication_template::get_info_container( tp_html_publication_template::prepare_altmetric($row['doi']), 'altmetric', $container_id );
        }

        // div bibtex
        $content .= tp_html_publication_template::get_info_container( nl2br( tp_bibtex::get_single_publication_bibtex($row, $keywords, $settings['convert_bibtex']) ), 'bibtex', $container_id );
        
        // div abstract
        if ( $row['abstract'] != '' ) {
            $content .= tp_html_publication_template::get_info_container( tp_html::prepare_text($row['abstract']), 'abstract', $container_id );
        }
        
        // div links
        if ( ($row['url'] != '' || $row['doi'] != '') && ( $settings['link_style'] === 'inline' || $settings['link_style'] === 'direct' ) ) {
            $content .= tp_html_publication_template::get_info_container( tp_html_publication_template::prepare_url($row['url'], $row['doi'], 'list'), 'links', $container_id );
        }

        $content .= tp_html_publication_template::get_info_container( nl2br( tp_bibtex::get_single_publication_bibtex($row, $keywords, $settings['convert_bibtex']) ), 'bibtex', $container_id );

        return $content;

        
    }                      
                        
}


/**
 * This class contains all functions related to the HTML publication template generator
 * @since 6.0.0
 */
class tp_html_publication_template {
    
    /**
     * Gets a single publication in html format
     * @param array $row        The publication array (used keys: title, image_url, ...)
     * @param array $all_tags   Array of tags (used_keys: pub_id, tag_id, name)
     * @param array $settings   Array with all settings (keys: author_name, editor_name, style, image, with_tags, link_style, date_format, convert_bibtex, container_suffix)
     * @param object $template  The template object
     * @param int $pub_count    The counter for numbered publications (default: 0)
     * @return string
     * @since 6.0.0
    */
    public static function get_single ($row, $all_tags, $settings, $template, $pub_count = 0) {
        $container_id = ( $settings['container_suffix'] != '' ) ? $row['pub_id'] . '_' . $settings['container_suffix'] : $row['pub_id'];
        $template_settings = $template->get_settings();
        $separator = $template_settings['button_separator'];
        $name = self::prepare_publication_title($row, $settings, $container_id);
        $images = self::handle_images($row, $settings);
        $abstract = '';
        $url = '';
        $bibtex = '';
        $settings['use_span'] = true;
        //$tag_string = '';
        $keywords = '';
        // HCI-Group Custom Code
        $allbutlast_authors = '';
        $all_authors = '';
        $allbutlast_editors = '';
        $all_editors = '';
        // HCI-Group Custom Code End
        $is_button = false;
        $altmetric = '';

        /* show tags
        if ( $settings['with_tags'] == 1 ) {
            $generated = self::get_tags($row, $all_tags, $settings);
            $keywords = $generated['keywords'];
            $tag_string = __('Tags') . ': ' . $generated['tags'];
        }*/
        
        // parse author names for teachPress style
        if ( $row['type'] === 'collection' || $row['type'] === 'periodical' || ( $row['author'] === '' && $row['editor'] !== '' ) ) {
            $all_authors = tp_bibtex::parse_author($row['editor'], $settings['author_separator'], $settings['author_name'] ) . ' (' . __('Ed.','teachpress') . ')';
        }
        else {
             $allbutlast_authors = tp_bibtex::parse_author($row['author'], ', ', $settings['author_name'] );
             $all_authors = preg_replace('/,([^,]+,[^,]*)$/', ' & \1', $allbutlast_authors);
             $allbutlast_editors = tp_bibtex::parse_editor($row['editor'], ', ', $settings['editor_name'] );
             $all_editors = preg_replace('/(,(?!.*,.*))/', ' &', $allbutlast_editors);

        }

        // if the publication has a doi -> altmetric
        if ( $settings['show_altmetric_entry']  &&  $row['doi'] != '' ) {
            $altmetric = self::get_info_button(__('Altmetric','teachpress'), __('Show Altmetric','teachpress'), 'altmetric', $container_id) . $separator;
            $is_button = true;
        }
        
        // if there is an abstract
        if ( $row['abstract'] != '' ) {
            $abstract = self::get_info_button(__('Abstract','teachpress'), __('Show abstract','teachpress'), 'abstract', $container_id) . $separator;
            $is_button = true;
        }
        
                // if there are links
        if ( $row['url'] != '' || $row['doi'] != '' ) {
            if ( $settings['link_style'] === 'inline' || $settings['link_style'] === 'direct' ) {
                if( substr($row['url'], -4) == '.pdf'){
                    $url = self::get_info_button(__('
                    <svg width="22px" height="22px" viewBox="0 0 22 22" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="pdf" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="07-Thesis-Desktop" transform="translate(-417.000000, -466.000000)" fill="#181716"><g id="2017" transform="translate(400.000000, 260.000000)"><g id="Publication-2" transform="translate(0.000000, 75.000000)"><g id="PDF-Button" transform="translate(0.000000, 122.000000)"><g id="PDF-ICON" transform="translate(17.000000, 9.000000)"><path d="M2.29599999,10.75 L2.29599999,6.562 L4.17999999,6.562 C4.37200095,6.562 4.54499922,6.59299969 4.69899999,6.655 C4.85300076,6.71700031 4.98399945,6.80499943 5.09199999,6.919 C5.20000053,7.03300057 5.28199971,7.1699992 5.33799999,7.33 C5.39400027,7.4900008 5.42199999,7.66599904 5.42199999,7.858 C5.42199999,8.05400098 5.39400027,8.23099921 5.33799999,8.389 C5.28199971,8.54700079 5.20000053,8.68299943 5.09199999,8.797 C4.98399945,8.91100057 4.85300076,8.99899969 4.69899999,9.061 C4.54499922,9.12300031 4.37200095,9.154 4.17999999,9.154 L3.08799999,9.154 L3.08799999,10.75 L2.29599999,10.75 Z M3.08799999,8.47 L4.10799999,8.47 C4.26000075,8.47 4.37999955,8.42900041 4.46799999,8.347 C4.55600043,8.26499959 4.59999999,8.14800076 4.59999999,7.996 L4.59999999,7.72 C4.59999999,7.56799924 4.55600043,7.4520004 4.46799999,7.372 C4.37999955,7.2919996 4.26000075,7.252 4.10799999,7.252 L3.08799999,7.252 L3.08799999,8.47 Z M6.292,6.562 L7.816,6.562 C8.08800136,6.562 8.33499889,6.60599956 8.557,6.694 C8.77900111,6.78200044 8.96899921,6.91299913 9.127,7.087 C9.28500079,7.26100087 9.40699957,7.47899869 9.493,7.741 C9.57900043,8.00300131 9.622,8.30799826 9.622,8.656 C9.622,9.00400174 9.57900043,9.30899869 9.493,9.571 C9.40699957,9.83300131 9.28500079,10.0509991 9.127,10.225 C8.96899921,10.3990009 8.77900111,10.5299996 8.557,10.618 C8.33499889,10.7060004 8.08800136,10.75 7.816,10.75 L6.292,10.75 L6.292,6.562 Z M7.816,10.048 C8.11200148,10.048 8.34699913,9.96100087 8.521,9.787 C8.69500087,9.61299913 8.782,9.3460018 8.782,8.986 L8.782,8.326 C8.782,7.9659982 8.69500087,7.69900087 8.521,7.525 C8.34699913,7.35099913 8.11200148,7.264 7.816,7.264 L7.084,7.264 L7.084,10.048 L7.816,10.048 Z M10.576,10.75 L10.576,6.562 L13.27,6.562 L13.27,7.264 L11.368,7.264 L11.368,8.278 L13.024,8.278 L13.024,8.98 L11.368,8.98 L11.368,10.75 L10.576,10.75 Z" id="PDF"></path><g id="pdf-(1)" fill-rule="nonzero"><path d="M3.66666667,0 L3.66666667,4.58333333 L0,4.58333333 L0,12.8333333 L3.66666667,12.8333333 L3.66666667,22 L16.5,22 L22,16.5 L22,0 L3.66666667,0 Z M0.916666667,11.9166667 L0.916666667,5.5 L14.6666667,5.5 L14.6666667,11.9166667 L0.916666667,11.9166667 Z M16.5,20.7038333 L16.5,16.5 L20.7038333,16.5 L16.5,20.7038333 Z M21.0833333,15.5833333 L15.5833333,15.5833333 L15.5833333,21.0833333 L4.58333333,21.0833333 L4.58333333,12.8333333 L15.5833333,12.8333333 L15.5833333,4.58333333 L4.58333333,4.58333333 L4.58333333,0.916666667 L21.0833333,0.916666667 L21.0833333,15.5833333 Z" id="Shape"></path></g></g></g></g></g></g></g></svg> Links ','teachpress'), __('Show links and resources','teachpress'), 'links', $container_id) . $separator;
                    $is_button = true;
                }else{
                    $url = self::get_info_button(__('Links ','teachpress'), __('Show links and resources','teachpress'), 'links', $container_id) . $separator;
                    $is_button = true;
                }                
            }
            else {
                $url = '<span class="tp_resource_link">' . $separator . __('Links','teachpress') . ': ' . self::prepare_url($row['url'], $row['doi'], 'enumeration') . '</span>';
            }           
            
        }
        
        // if with bibtex
        if ( $settings['show_bibtex'] === true ) {
            $bibtex = self::get_info_button(__('<svg width="50px" height="16px" viewBox="0 0 50 16" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="HCIRWD" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="07-Thesis-Desktop" transform="translate(-430.000000, -990.000000)" fill="#181716" fill-rule="nonzero"><g id="2017" transform="translate(400.000000, 781.000000)"><g id="Publication-2" transform="translate(0.000000, 75.000000)"><g id="BibTeX-Button" transform="translate(0.000000, 122.000000)"><g id="BibTeX_logo" transform="translate(30.000000, 12.000000)"><path d="M0,0.00260973299 L0,0.395996553 C1.13942187,0.395996553 1.32186109,0.395996553 1.32186109,1.13077313 L1.32186109,9.98296266 C1.32186109,10.7177392 1.14204978,10.7177392 0,10.7177392 L0,11.1111111 L5.59568104,11.1111111 C7.67693717,11.1111111 9.02777778,9.63103296 9.02777778,8.15095481 C9.02777778,6.68600635 7.69208555,5.43482065 5.95331461,5.31907196 C7.51228083,5.01120255 8.60296442,3.97056289 8.60296442,2.73451345 C8.60296442,1.3853663 7.27056532,0 5.17086768,0 L0,0.00260973299 Z M2.37697233,5.20131036 L2.37697233,1.0386728 C2.37697233,0.483482328 2.40793431,0.401255764 3.05602166,0.401255764 L5.12739841,0.401255764 C6.7271994,0.401255764 7.43983204,1.70635907 7.43983204,2.7187391 C7.43983204,3.96004447 6.45188742,5.20131036 4.70521956,5.20131036 L2.37697233,5.20131036 Z M3.05602166,10.725633 C2.41056881,10.725633 2.37961342,10.6434064 2.37961342,10.0882127 L2.37961342,5.46573784 L5.37174183,5.46573784 C7.0360947,5.46573784 7.84686251,6.9563673 7.84686251,8.15358606 C7.84686251,9.34817358 6.92544564,10.725633 5.16295759,10.725633 L3.05602166,10.725633 Z" id="path14"></path><path d="M11.9938455,3.95080873 C11.9938455,3.25260964 12.072091,3.17051107 13.1944444,3.17051107 L13.1944444,2.77777778 C12.6686347,2.79353414 11.8617671,2.82704349 11.4580204,2.82704349 C11.0548995,2.82704349 10.248032,2.79617443 9.72222222,2.77777778 L9.72222222,3.17051107 C10.7932466,3.17051107 10.8689882,3.25260964 10.8689882,3.95080873 L10.8689882,9.93874352 C10.8689882,10.636253 10.7957505,10.7183515 9.72222222,10.7183515 L9.72222222,11.1111111 C10.248032,11.0953482 11.0548995,11.0651359 11.4580204,11.0651359 C11.8617671,11.0651359 12.6661308,11.0953482 13.1944444,11.1111111 L13.1944444,10.7183515 C12.072091,10.7183515 11.9938455,10.6388801 11.9938455,9.93874352" id="path16"></path><path d="M14.5833333,2.77777778 L19.0279056,2.77777778 C20.7521977,2.77777778 21.8574313,3.81658974 21.8574313,4.83697003 C21.8574313,5.77859384 20.956634,6.50940586 19.8335122,6.75041617 C21.208985,6.92770689 22.2222222,7.82007015 22.2222222,8.87462158 C22.2222222,10.0079689 21.1137943,11.1111111 19.3594756,11.1111111 L14.5833333,11.1111111 L14.5833333,10.718445 C15.6285137,10.718445 15.7058162,10.6212634 15.7058162,9.95412504 L15.7058162,3.93410065 C15.7058162,3.26764515 15.6285137,3.16977411 14.5833333,3.16977411 L14.5833333,2.77777778 Z M16.7292753,6.5862581 L18.5187315,6.5862581 C20.1829705,6.5862581 20.5975928,5.40627021 20.5975928,4.82450058 C20.5975928,4.4371138 20.358019,3.17502717 18.9026883,3.17502717 L17.3681386,3.17502717 C16.8091332,3.17502717 16.7292753,3.22364423 16.7292753,3.87041388 L16.7292753,6.5862581 Z M16.7292753,6.91457424 L16.7318307,10.0132219 C16.7318307,10.6724808 16.8091332,10.7210715 17.3630277,10.7210715 L18.9154656,10.7210715 C20.358019,10.7210715 20.8793315,9.60020025 20.8793315,8.85886241 C20.8793315,8.16677199 20.4500153,6.91457424 19.105208,6.91457424 L16.7292753,6.91457424 Z" id="path18"></path><path d="M31.6828283,0 L22.4909091,0 L22.2222222,3.61202909 L22.5082645,3.61202909 C22.7139578,0.906802432 22.9402204,0.433273839 25.4085399,0.433273839 C25.6945822,0.433273839 26.1593205,0.433273839 26.287236,0.433273839 C26.5912764,0.482099935 26.5912764,0.680583731 26.5912764,1.05650036 L26.5912764,9.9464495 C26.5912764,10.5366942 26.543067,10.7167353 25.2022039,10.7167353 L24.7503214,10.7167353 L24.7503214,11.1111111 C25.5139578,11.0959428 26.3097337,11.080115 27.0907254,11.080115 C27.869146,11.080115 28.6674931,11.0959428 29.4304867,11.1111111 L29.4304867,10.7167353 L28.9863177,10.7167353 C27.6653811,10.7167353 27.6178145,10.5366942 27.6178145,9.9464495 L27.6178145,1.05650036 C27.6178145,0.695758625 27.6178145,0.499891691 27.9044995,0.433273839 C28.0298439,0.433273839 28.492011,0.433273839 28.7780533,0.433273839 C31.2135904,0.433273839 31.4520661,0.904144682 31.6577594,3.61202909 L31.9444444,3.61202909" id="path20"></path><path d="M40.2777778,11.8497765 L39.9855446,11.8497765 C39.629754,14.2686996 39.4200799,15.5835608 36.5658921,15.5835608 L34.3138619,15.5835608 C33.6664933,15.5835608 33.6356974,15.5012173 33.6356974,14.9406227 L33.6356974,10.3807682 L35.1663179,10.3807682 C36.6969384,10.3807682 36.8423997,10.9439978 36.8423997,12.3207814 L37.103837,12.3207814 L37.103837,8.07778476 L36.8423997,8.07778476 C36.8423997,9.4308534 36.6969384,9.98420182 35.1663179,9.98420182 L33.6356974,9.98420182 L33.6356974,5.94146461 C33.6356974,5.39139676 33.6664933,5.30905324 34.3138619,5.30905324 L36.5331305,5.30905324 C39.0439771,5.30905324 39.3355551,6.31233322 39.5635756,8.4684224 L39.8551535,8.4684224 L39.4659461,4.86111111 L31.25,4.86111111 L31.25,5.30905324 C32.3992758,5.30905324 32.5833958,5.30905324 32.5833958,6.04226625 L32.5833958,14.8451042 C32.5833958,15.5782908 32.4018967,15.5782908 31.25,15.5782908 L31.25,15.9722222 L39.6939666,15.9722222" id="path22"></path><path d="M44.7605759,4.94032462 L47.2303109,1.45672437 C47.4776888,1.11473044 47.9805333,0.411034644 49.3502117,0.393292418 L49.3502117,0 C48.9680229,0.0309078931 48.3337378,0.0309078931 47.9333495,0.0309078931 C47.3833212,0.0309078931 46.698482,0.0309078931 46.2825905,0 L46.2825905,0.393292418 C46.8171156,0.441942471 46.9485562,0.768159242 46.9485562,1.03055714 C46.9485562,1.22523627 46.8669956,1.35677391 46.748362,1.51853739 L44.5448785,4.63714552 L42.0751436,1.11015316 C41.9592062,0.932573073 41.9430289,0.881275958 41.9430289,0.832629193 C41.9430289,0.685952326 42.1250236,0.408425725 42.6777481,0.393292418 L42.6777481,0 C42.1432231,0.0309078931 41.3269433,0.0309078931 40.776915,0.0309078931 C40.3448462,0.0309078931 39.510367,0.0309078931 39.1072825,0 L39.1072825,0.393292418 C40.0239963,0.393292418 40.3239505,0.426849939 40.6926582,0.932573073 L43.9126156,5.54667626 L41.0087897,9.68531437 C40.2922699,10.6974459 39.2077166,10.7152026 38.8888889,10.7152026 L38.8888889,11.1084805 C39.2704036,11.0775707 39.9053628,11.0775707 40.305751,11.0775707 C40.7560193,11.0775707 41.5406185,11.0775707 41.95651,11.1084805 L41.95651,10.7152026 C41.4401844,10.6665361 41.2905444,10.3403391 41.2905444,10.0779346 C41.2905444,9.86748489 41.3721049,9.75173755 41.4563617,9.63599022 L44.1262908,5.83408479 L47.0301167,9.9983583 C47.1615573,10.1785559 47.1615573,10.2272224 47.1615573,10.2758888 C47.1615573,10.4041316 47.0119173,10.6842928 46.4275122,10.7178332 L46.4275122,11.1111111 C46.9620373,11.0802013 47.778317,11.0802013 48.3283453,11.0802013 C48.7604141,11.0802013 49.5948934,11.0802013 50,11.1111111 L50,10.7178332 C48.9309499,10.7178332 48.7624363,10.6382569 48.4308016,10.1785559" id="path24"></path></g></g></g></g></g></g></svg>','teachpress'), __('Show BibTeX entry','teachpress'), 'bibtex', $container_id) . $separator;
            $is_button = true;
        }

        // link style
        if ( $settings['link_style'] === 'inline' || $settings['link_style'] === 'direct' ) {
            $tag_string = $abstract . $url . $bibtex . $altmetric ;
        }
        else {
            $tag_string = $abstract . $bibtex . $altmetric . $url ;
        }
        
        // load template interface
        $interface_data = array (
            'row' => $row,
            'title' => $name,
            'images' => $images,
            'tag_line' => $tag_string,
            'settings' => $settings,
            'counter' => $pub_count,
            'all_authors' => $all_authors,
            'all_editors' => $all_editors,
            'keywords' => $keywords,
            'container_id' => $container_id,
            'template_settings' => $template_settings
        );
        
        $interface = new tp_publication_interface();
        $interface->set_data($interface_data);
        
        // load entry template
        $s = $template->get_entry($interface);
        return $s;
    }


    /**
     * Returns the show/hide buttons for the info container
     * @param string $name          The name of the button
     * @param string $title         The title/description of the button
     * @param string $type          bibtex, links, abstract
     * @param string $container_id  The suffix for the container ID
     * @return string
     * @since 6.0.0
     */
    public static function get_info_button ($name, $title, $type, $container_id) {
        $class = ( $type === 'links' ) ? 'resource' : $type;
        $s = '<span class="tp_' . $class . '_link"><a id="tp_' . $type . '_sh_' . $container_id . '" class="tp_show" onclick="teachpress_pub_showhide(' . "'" . $container_id . "','tp_" . $type . "'" . ')" title="' . $title . '" style="cursor:pointer;">' . $name . '</a></span>';
        return $s;
    }
    
    /**
     * Returns the info container for a publication
     * @param string $content       The content you want to show
     * @param string $type          bibtex, links, abstract
     * @param string $container_id  The suffix for the container ID
     * @return string
     * @since 6.0.0
     */
    public static function get_info_container ($content, $type, $container_id) {
        $s = '<div class="tp_' . $type . '" id="tp_' . $type . '_' . $container_id . '" style="display:none;">';
        $s .= '<div class="tp_' . $type . '_entry">' . $content . '</div>';
        $s .= '<p class="tp_close_menu"><a class="tp_close" onclick="teachpress_pub_showhide(' . "'" . $container_id . "','tp_" . $type . "'" . ')">' . __('Close','teachpress') . '</a></p>';
        $s .= '</div>';
        return $s;
    }
    
    /**
     * Generates the visible sorting number of a publication
     * @param int $number_entries       The number of selected publications
     * @param int $tpz                  The publication counter in the list
     * @param int $entry_limit          The current entry limit
     * @param string $style             The sorting styles
     * @since 6.2.2
     * @return int
     */
    public static function prepare_publication_number($number_entries, $tpz, $entry_limit, $style) {
        if ( $style === 'numbered_desc' || $style === 'std_num_desc' ) {
            return $number_entries - $tpz - $entry_limit;
        }
        return $entry_limit + $tpz + 1;
    }
    
    /**
     * This function prepares the publication title for html publication lists.
     * @param array $row                The publication array
     * @param array $settings           Array with all settings (keys: author_name, editor_name, style, image, with_tags, link_style, title_ref, date_format, convert_bibtex, container_suffix,...)
     * @param string $container_id      The basic ID for div container
     * @return string
     * @since 6.0.0
     */
    public static function prepare_publication_title($row, $settings, $container_id) {
        
        // open abstracts instead of links (ignores the rest of the method)
        if ( $settings['title_ref'] === 'abstract' ) {
            return self::prepare_title_link_to_abstracts($row, $container_id);
        }
        
        // Use a related page as link
        if ( $row['rel_page'] != 0 ) {
            return '<a href="' . get_permalink($row['rel_page']) . '">' . stripslashes($row['title']) . '</a>';
        }
        
        // for inline style
        elseif ( ($row['url'] != '' || $row['doi'] != '') && $settings['link_style'] === 'inline' ) {
            return '<a class="tp_title_link" onclick="teachpress_pub_showhide(' . "'" . $container_id . "'" . ',' . "'" . 'tp_links' . "'" . ')" style="cursor:pointer;">' . tp_html::prepare_title($row['title'], 'decode') . '</a>';
        }
        
        // for direct style (if a DOI numer exists)
        elseif ( $row['doi'] != '' && $settings['link_style'] === 'direct' ) {
            $doi_url = TEACHPRESS_DOI_RESOLVER . $row['doi'];
            $title = tp_html::prepare_title($row['title'], 'decode');
            return '<a class="tp_title_link" href="' . $doi_url . '" title="' . $title . '" target="blank">' . $title . '</a>'; 
        }
        
        // for direct style (use the first available URL)
        elseif ( $row['url'] != '' && $settings['link_style'] === 'direct' ) { 
            $parts = tp_bibtex::explode_url($row['url']); 
            return '<a class="tp_title_link" href="' . $parts[0][0] . '" title="' . $parts[0][1] . '" target="blank">' . tp_html::prepare_title($row['title'], 'decode') . '</a>'; 
        } 
        
        // if there is no link
        else {
            return tp_html::prepare_title($row['title'], 'decode');
        }

    }
    
    /**
     * Prepares a title if the link should refer to the abstract
     * @param array $row                The publication array
     * @param string $container_id      The basic ID for div container
     * @return string
     * @since 6.0.0
     * @access private
     */
    private static function prepare_title_link_to_abstracts($row, $container_id) {
        if ( $row['abstract'] != '' ) {
            return '<a class="tp_title_link" onclick="teachpress_pub_showhide(' . "'" . $container_id . "'" . ',' . "'" . 'tp_abstract' . "'" . ')" style="cursor:pointer;">' . tp_html::prepare_title($row['title'], 'decode') . '</a>';
        }
        else {
            return tp_html::prepare_title($row['title'], 'decode');
        }
    }
    
    /**
     * Prepares a url link for publication resources 
     * @param string $url       The url string
     * @param string $doi       The DOI number
     * @param string $mode      list or enumeration
     * @return string
     * @since 3.0.0
     * @version 2
     * @access public
     */
    public static function prepare_url($url, $doi = '', $mode = 'list') {
        $end = '';
        $url = explode(chr(13) . chr(10), $url);
        $url_displayed = array();
        foreach ($url as $url) {
            if ( $url == '' ) {
                continue;
            }
            $parts = explode(', ',$url);
            $parts[0] = trim( $parts[0] );
            $parts[1] = isset( $parts[1] ) ? $parts[1] : $parts[0];
            array_push($url_displayed, $parts[0]);
            // list mode 
            if ( $mode === 'list' ) {
                $length = strlen($parts[1]);
                $parts[1] = substr($parts[1], 0 , 80);
                if ( $length > 80 ) {
                    $parts[1] .= '[...]';
                }
                $end .= '<li><a class="tp_pub_list" href="' . $parts[0] . '" title="' . $parts[1] . '" target="_blank">' . $parts[1] . '</a></li>';
            }
            // enumeration mode
            else {
                $end .= '<a class="tp_pub_link" href="' . $parts[0] . '" title="' . $parts[1] . '" target="_blank"><img class="tp_pub_link_image" alt="" src="' . get_tp_mimetype_images( $parts[0] ) . '"/></a>';
            }
        }
        
        /**
         * Add DOI-URL
         * @since 5.0.0
         */
        if ( $doi != '' ) {
            $doi_url = TEACHPRESS_DOI_RESOLVER . $doi;
            if (in_array($doi_url, $url_displayed) == False){
                if ( $mode === 'list' ) {
                    $end .= '<li><a class="tp_pub_list" style="background-image: url(' . get_tp_mimetype_images( 'html' ) . ')" href="' . $doi_url . '" title="' . __('Follow DOI:','teachpress') . $doi . '" target="_blank">doi:' . $doi . '</a></li>';
                }
                else {
                    $end .= '<a class="tp_pub_link" href="' . $doi_url . '" title="' . __('Follow DOI:','teachpress') . $doi . '" target="_blank"><img class="tp_pub_link_image" alt="" src="' . get_tp_mimetype_images( 'html' ) . '"/></a>';
                }
            }
        }
        
        if ( $mode === 'list' ) {
            $end = '<ul class="tp_pub_list">' . $end . '</ul>';
        }
        
        return $end;
    }




    /**
     * Prepares an altmetric info block 
     * @param string $doi       The DOI number
     * @return string
     * @since 3.0.0
     * @version 2
     * @access public
     */
    public static function prepare_altmetric($doi = '') {
        $end = '';
         /**
         * Add DOI-URL
         * @since 5.0.0
         */
        if ( $doi != '' ) {
            $doi_url = TEACHPRESS_DOI_RESOLVER . $doi;

            $end .= '<div data-badge-details="right" data-badge-type="large-donut" data-doi="'.$doi .'" data-condensed="true" class="altmetric-embed"></div>';
        }
        
        
        return $end;
    }

    

    
    /**
     * Generates the tag string for a single publication
     * @param array $row        The publication array
     * @param array $all_tags   An array of all tags
     * @param type $settings    The settings array
     * @return array Returns an array with tags and keywords
     * @since 6.0.0
     */
    public static function get_tags ($row, $all_tags, $settings) {
        $tag_string = '';
        $keywords = array();
        foreach ($all_tags as $tag) {
            if ($tag["pub_id"] == $row['pub_id']) {
                $keywords[] = array('name' => stripslashes($tag["name"]));
                $tag_string .= '<a rel="nofollow" href="' . $settings['permalink'] . 'tgid=' . $tag["tag_id"] . $settings['html_anchor'] . '" title="' . __('Show all publications which have a relationship to this tag','teachpress') . '">' . stripslashes($tag["name"]) . '</a>, ';
            }
        }
        return array('tags' => substr($tag_string, 0, -2),
                     'keywords' => $keywords);
    }
    
    /**
     * Generates the HTML output for images
     * @param array $row        The publication array
     * @param array $settings   The settings array
     * @return string
     * @since 6.0.0
     */
    public static function handle_images ($row, $settings) {
        $return = array('bottom' => '',
                        'left' => '',
                        'right' => '');
        
        $image = '';

        // return if no images is set
        if ( $settings['image'] === 'none' ) {
            return $return;
        }
        
        // define the width of the image
        $width = ( $settings['image'] === 'bottom' ) ? 'style="max-width:' . ($settings['pad_size']  - 5) .'px;"' : 'width="' . ( $settings['pad_size'] - 5 ) .'"';
        
        // general html output
        if ( $row['image_url'] !== '' ) {
            $image = '<img name="' . tp_html::prepare_title($row['title'], 'replace') . '" src="' . $row['image_url'] . '" ' . $width . ' alt="' . tp_html::prepare_title($row['title'], 'replace') . '" />';
        }
        
        // image link
        if ( $settings['image_link'] === 'self' ) {
            $image = '<a href="' . $row['image_url'] . '" target="_blank">' . $image . '</a>';
        }
        if ( $settings['image_link'] === 'post' && $row['rel_page'] != 0 ) {
            $image = '<a href="' . get_permalink($row['rel_page']) . '" title="' . stripslashes($row['title']) . '">' . $image . '</a>';
        }
        
        // Altmetric donut
        $altmetric = '';
        if( $settings['show_altmetric_donut']) {
           $altmetric = '<div class="tp_pub_image_bottom"><div data-badge-type="medium-donut" data-doi="' . $row['doi']  . '" data-condensed="true" data-hide-no-mentions="true" class="altmetric-embed"></div></div>';
        }
        // left position
        if ( $settings['image'] === 'left' ) {
            $return['left'] = '<td class="tp_pub_image_left" width="' . $settings['pad_size'] . '">' . $image . $altmetric . '</td>';
        }
        
        // right position
        if ( $settings['image'] === 'right' ) {
            $return['right'] = '<td class="tp_pub_image_right" width="' . $settings['pad_size']  . '">' . $image . $altmetric . '</td>';
        }
        
        // bottom position
        if ( $settings['image'] === 'bottom' ) {
          $return['bottom'] = '<div class="tp_pub_image_bottom">' . $image . '</div>'. $altmetric;
        }
        
        return $return;
    }
    
}

