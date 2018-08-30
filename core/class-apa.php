<?php
/**
 * This file contains all general functions of general APA-Style export functions
 *
 * @package teachpress\core\apa
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPLv2 or later
 * @since 6.2.4
 */

/**
 * teachPress APA class
 *
 * @package teachpress\core\apa
 * @since 6.2.4
 */
class tp_apa
{


    /**
     * Gets a single publication in APA-Style
     * @since 6.2.4
     */
    public static function get_single_publication_apa($row, $all_tags = '', $convert_apa = false)
    {
        $apa_output = '';
        $pub_fields = array('type', 'bibtex', 'title', 'author', 'editor', 'url', 'doi', 'isbn', 'date', 'urldate', 'booktitle', 'issuetitle', 'journal', 'volume', 'number', 'pages', 'publisher', 'address', 'edition', 'chapter', 'institution', 'organization', 'school', 'series', 'crossref', 'abstract', 'howpublished', 'key', 'techtype', 'note');
        $isbn_label = ($row['is_isbn'] == 1) ? 'isbn' : 'issn';

        //parse author name          
        $allbutlast_authors = tp_bibtex::parse_author($row['author'], ', ', 'initials');
        $all_authors = preg_replace('/,([^,]+,[^,]*)$/', ' & \1', $allbutlast_authors);

        //parse editors
        $allbutlast_editors = tp_bibtex::parse_editor($row['editor'], ', ', 'initials');

       $all_editors = preg_replace('/(,(?!.*,.*))/', ' &', $allbutlast_editors);

        //apa output string start
        $apa_output .= $all_authors . ' (' . substr($row['date'], 0, 4) . '). ';
        // Journal Article
        if ($row['type'] == 'article') {

            $apa_output .= $row['title'] . '. ';

            if ($row['journal'] != "") {
                $apa_output .= $row['journal'] . ', ';
            }
            if ($row['volume'] != "") {
                if ($row['number'] != "") {
                    $apa_output .= $row['volume'] . ' (' . $row['number'] . '). ';
                } else {
                    $apa_output .= $row['volume'] . '. ';
                }
            }
            if ($row['pages'] != "") {
                $apa_output .= $row['pages'] . '. ';
            }

            // Conference
        } elseif ($row['type'] == 'conference') {

            $apa_output .= $row['title'] . '. ';

            if ($row['booktitle'] != "") {
                if ($all_editors != "" && $row['editor'] != " , .") {
                    $apa_output .= 'In ' . $all_editors . ' (Eds.), ' . $row['booktitle'] . '. ';
                } else {
                    $apa_output .= 'In ' . $row['booktitle'] . '. ';
                }
            }
            if ($row['address'] != "" && $row['publisher'] == "" && $row['pages'] == "") {
                $apa_output .= $row['address'] . ': ' . $row['date'] . '.';
            } else {
                $apa_output .= $row['address'];
            }

            if ($row['publisher'] != "" && $row['address'] != "") {
                $apa_output .= ': ' . $row['publisher'];
            } else {
                $apa_output .= $row['publisher'];
            }
            if ($row['pages'] != "") {
                $apa_output .= ', ' . 'pp. ' . $row['pages'];
            }
            if ($row['publisher'] != "" && $row['address'] != "" && $row['pages'] != "") {
                $apa_output .= '.';
            }

            // Book
        } elseif ($row['type'] == 'book') {

            $apa_output .= $row['title'] . '. ';

            if ($row['address'] != "") {
                $apa_output .= $row['address'] . ': ';
            }
            if ($row['publisher'] != "") {
                $apa_output .= $row['publisher'] . '.';
            }

            // Inproceedings
        } elseif ($row['type'] == 'inproceedings') {

            $apa_output .= $row['title'] . '. ';

            if ($row['booktitle'] != "") {
                if ($all_editors != "" && $all_editors != " , .") {
                    $apa_output .= 'In ' . $all_editors . ' (Eds.), ' . $row['booktitle'] . '. ';
                } else {
                    $apa_output .= 'In ' . $row['booktitle'] . '. ';
                }
            }
            if ($row['address'] != "" && $row['publisher'] == "" && $row['pages'] == "") {
                $apa_output .= $row['address'] . '.';
            } else {
                $apa_output .= $row['address'];
            }

            if ($row['publisher'] != "" && $row['address'] != "") {
                $apa_output .= ': ' . $row['publisher'];
            } else {
                $apa_output .= $row['publisher'];
            }
            if ($row['pages'] != "") {
                $apa_output .= ', ' . 'pp. ' . $row['pages'];
            }
            if ($row['publisher'] != "" && $row['address'] != "" && $row['pages'] != "") {
                $apa_output .= '.';
            }


            // Technical report
        } elseif ($row['type'] == 'techreport') {

            $apa_output .= $row['title'] . '. ';

            if ($row['address'] != "") {
                $apa_output .= $row['address'] . ': ';
            }
            if ($row['institution'] != "") {
                $apa_output .= $row['institution'] . '.';
            }


            // Booklet
        } elseif ($row['type'] == 'booklet') {

            $apa_output .= $row['title'] . '. ';
            //$apa_output .= '<p>';

            if ($row['address'] != "") {
                $apa_output .= $row['address'] . '.';
            }


            // Masters thesis || PHD thesis
        } elseif ($row['type'] == 'mastersthesis' || $row['type'] == 'phdthesis') {

            $apa_output .= $row['title'] . '. ';

            if ($row['address'] != "") {
                $apa_output .= $row['address'] . ': ';
            }

            if ($row['school'] != "") {
                $apa_output .= $row['school'] . '.';
            }


            // Incollection
        } elseif ($row['type'] == 'incollection') {

            $apa_output .= $row['title'] . '. ';

            if ($row['booktitle'] != "") {
                if ($all_editors != "" && $all_editors != " , .") {
                    $apa_output .= 'In ' . $all_editors . ' (Eds.), ' . $row['booktitle'] . '. ';
                } else {
                    $apa_output .= 'In ' . $row['booktitle'] . '. ';
                }
            }
            if ($row['address'] != "" && $row['publisher'] == "" && $row['pages'] == "") {
                $apa_output .= $row['address'] . '.';
            } else {
                $apa_output .= $row['address'];
            }

            if ($row['publisher'] != "" && $row['address'] != "") {
                $apa_output .= ': ' . $row['publisher'];
            } else {
                $apa_output .= $row['publisher'];
            }
            if ($row['pages'] != "") {
                $apa_output .= ', ' . $row['pages'];
            }
            if ($row['publisher'] != "" && $row['address'] != "" && $row['pages'] != "") {
                $apa_output .= '.';
            }


        } else {

            $apa_output .= $row['title'] . '. ';

        }

        // Convert utf-8 chars
        if ($convert_apa === true) {
            $apa_output = self::convert_utf8_to_apa($apa_output);
        }

        return $apa_output;
    }

    /**
     * Replaces some APA special chars with the UTF-8 versions and secures the input.
     * Before teachPress 5.0, this function was called replace_bibtex_chars()
     *
     * @param string $input
     * @return string
     * @since 3.0.0
     * @access public
     */
    public static function convert_apa_to_utf8($input)
    {
        // return the input if there are no bibtex chars
        if (strpos($input, '\\') === false && strpos($input, '{') === false) {return $input;}
        // Step 1: Chars which based on a combination of two chars, delete escapes
        $array_a = array("\'a", "\'A", '\"a', '\"A',
            "\'e", "\'E",
            "\'i",
            "\'o", "\'O", '\"o', '\"O',
            '\"u', '\"U', '\ss',
            '\L', '\l', '\AE', '\ae', '\OE', '\oe', '\t{oo}', '\O', '\o',
            '\textendash', '\textemdash', '\glqq', '\grqq', '\flqq', '\frqq', '\flq', '\frq', '\glq', '\grq', '\dq', chr(92));
        $array_b = array('á', 'Á', 'ä', 'Ä',
            'é', 'É',
            'í',
            'ó', 'Ó',
            'ö', 'Ö',
            'ü', 'Ü', 'ß',
            'Ł', 'ł', 'Æ', 'æ', 'Œ', 'œ', 'o͡o', 'Ø', 'ø',
            '–', '—', '„', '“', '«', '»', '‹', '›', '‚', '‘', '', '');
        $input = str_replace($array_a, $array_b, $input);

        // Step 2: All over special chars
        $array_1 = array('"{a}', '"{A}', '`{a}', '`{A}', "'{a}", "'{A}", '~{a}', '~{A}', '={a}', '={A}', '^{a}', '^{A}', 'u{a}', 'u{A}', 'k{a}', 'k{A}', 'r{a}', 'r{A}', '{aa}', '{AA}',
            '.{b}', '.{B}',
            "'{c}", "'{C}", 'v{c}', 'v{C}', 'c{c}', 'c{C}', '.{c}', '.{C}', '^{c}', '^{C}',
            'v{d}', 'v{D}', '.{d}', '.{D}', 'd{d}', 'd{D}', '{d}', '{D}',
            '"{e}', '"{E}', "'{e}", "'{E}", '`{e}', '`{E}', '^{e}', '^{E}', 'u{e}', 'u{E}', 'v{e}', 'v{E}', '={e}', '={E}', 'k{e}', 'k{E}', '.{e}', '.{E}',
            '.{f}', '.{F}',
            'u{g}', 'u{G}', 'c{g}', 'c{G}', '.{g}', '.{G}', '^{g}', '^{G}',
            '.{h}', '.{H}', 'd{h}', 'd{H}', '^{h}', '^{H}', '{h}', '{H}',
            '"{i}', '"{I}', '~{i}', '~{I}', '`{i}', '`{I}', "'{i}", "'{I}", '^{i}', '^{I}', 'u{i}', 'u{I}', '={i}', '={I}', 'k{i}', 'k{I}', '.{i}', '.{I}',
            '^{j}', '^{J}',
            'c{k}', 'c{K}', 'd{k}', 'd{K}',
            "'{l}", "'{L}", 'v{l}', 'v{L}', 'c{l}', 'c{L}', 'd{l}', 'd{L}',
            '.{m}', '.{M}', 'd{m}', 'd{M}',
            "'{n}", "'{N}", '~{n}', '~{N}', 'v{n}', 'v{N}', 'c{n}', 'c{N}', '.{n}', '.{N}',
            '"{o}', '"{O}', '`{o}', '`{O}', "'{o}", "'{O}", '~{o}', '~{O}', '^{o}', '^{O}', 'u{o}', 'u{O}', '.{o}', '.{O}', '={o}', '={O}', 'H{o}', 'H{O}',
            '.{p}', '.{P}',
            "'{r}", "'{R}", 'v{r}', 'v{R}', 'c{r}', 'c{R}', '.{r}', '.{R}', 'd{r}', 'd{R}',
            "'{s}", "'{S}", 'v{s}', 'v{S}', 'c{s}', 'c{S}', '.{s}', '.{S}', 'd{s}', 'd{S}', '^{s}', '^{S}',
            'v{t}', 'v{T}', 'c{t}', 'c{T}', '.{t}', '.{T}', 'd{t}', 'd{T}', '{t}', '{T}',
            '"{u}', '"{U}', '`{u}', '`{U}', "'{u}", "'{U}", '^{u}', '^{U}', 'd{u}', 'd{U}', '~{u}', '~{U}', 'u{u}', 'u{U}', '={u}', '={U}', 'k{u}', 'k{U}', 'r{u}', 'r{U}', 'H{u}', 'H{U}',
            'd{v}', 'd{V}',
            '^{w}', '^{W}',
            '"{y}', '"{Y}', "'{y}", "'{Y}", '^{y}', '^{Y}',
            "'{z}", "'{Z}", 'v{z}', 'v{Z}', '.{z}', '.{Z}');
        $array_2 = array('ä', 'Ä', 'à', 'À', 'á', 'Á', 'ã', 'Ã', 'ā', 'Ā', 'â', 'Â', 'ă', 'Ă', 'ą', 'Ą', 'å', 'Å', 'å', 'Å',
            'ḃ', 'Ḃ',
            'ć', 'Ć', 'č', 'Č', 'ç', 'Ç', 'ċ', 'Ċ', 'ĉ', 'Ĉ',
            'ď', 'Ď', 'ḋ', 'Ḋ', 'ḍ', 'Ḍ', 'đ', 'Đ',
            'ë', 'Ë', 'é', 'É', 'è', 'È', 'ê', 'Ê', 'ĕ', 'Ĕ', 'ě', 'Ě', 'ē', 'Ē', 'ę', 'Ę', 'ė', 'Ė',
            'ḟ', 'Ḟ',
            'ğ', 'Ğ', 'ģ', 'Ģ', 'ġ', 'Ġ', 'ĝ', 'Ĝ',
            'ḣ', 'Ḣ', 'ḥ', 'Ḥ', 'ĥ', 'Ĥ', 'ħ', 'Ħ',
            'ï', 'Ï', 'ĩ', 'Ĩ', 'ì', 'Ì', 'í', 'Í', 'î', 'Î', 'ĭ', 'Ĭ', 'ī', 'Ī', 'į', 'Į', 'i', 'İ',
            'ĵ', 'Ĵ',
            'ķ', 'Ķ', 'ḳ', 'Ḳ',
            'ĺ', 'Ĺ', 'ľ', 'Ľ', 'ļ', 'Ļ', 'ḷ', 'Ḷ',
            'ṁ', 'Ṁ', 'ṃ', 'Ṃ',
            'ń', 'Ń', 'ñ', 'Ñ', 'ň', 'Ň', 'ņ', 'Ņ', 'ṅ', 'Ṅ',
            'ö', 'Ö', 'ò', 'Ò', 'ó', 'Ó', 'õ', 'Õ', 'ô', 'Ô', 'ŏ', 'Ŏ', 'ȯ', 'Ȯ', 'ō', 'Ō', 'ő', 'Ő',
            'ṗ', 'Ṗ',
            'ŕ', 'Ŕ', 'ř', 'Ř', 'ŗ', 'Ŗ', 'ṙ', 'Ṙ', 'ṛ', 'Ṛ',
            'ś', 'Ś', 'š', 'Š', 'ş', 'Ş', 'ṡ', 'Ṡ', 'ṣ', 'Ṣ', 'ŝ', 'Ŝ',
            'ť', 'Ť', 'ţ', 'Ţ', 'ṫ', 'Ṫ', 'ṭ', 'Ṭ', 'ŧ', 'Ŧ',
            'ü', 'Ü', 'ù', 'Ù', 'ú', 'Ú', 'û', 'Û', 'ụ', 'Ụ', 'ũ', 'Ũ', 'ŭ', 'Ŭ', 'ū', 'Ū', 'ų', 'Ų', 'ů', 'Ů', 'ű', 'Ű',
            'ṿ', 'Ṿ',
            'ŵ', 'Ŵ',
            'ÿ', 'Ÿ', 'ý', 'Ý', 'ŷ', 'Ŷ',
            'ź', 'Ź', 'ž', 'Ž', 'ż', 'Ż');
        $return = str_replace($array_1, $array_2, $input);
        return htmlspecialchars($return, ENT_NOQUOTES);
    }

    /**
     * Cleans the author names after bibtex to UTF-8 convertion
     * @param string $input
     * @return string
     * @since 6.1.0
     */
    public static function clean_author_names($input)
    {
        $array_a = array('{á}', '{Á}', '{ä}', '{Ä}',
            '{é}', '[É}',
            '{í}',
            '{ó}', '{Ó}', '{ö}', '{Ö}',
            '{ü}', '{Ü}', '{ß}', '{š}', '{ø}', '{Ø}', '{å}', '{Å}');
        $array_b = array('á', 'Á', 'ä', 'Ä',
            'é', 'É',
            'í',
            'ó', 'Ó', 'ö', 'Ö',
            'ü', 'Ü', 'ß', 'š', 'ø', 'Ø', 'å', 'Å');
        $ret = str_replace($array_a, $array_b, $input);
        return $ret;
    }

    /**
     * Replaces some UTF-8 chars with their BibTeX/LaTeX expression.
     * @param string $input
     * @return string
     * @since 5.0.0
     */
    public static function convert_utf8_to_apa($input)
    {
        $array_a = array('ä', 'Ä', 'à', 'À', 'á', 'Á', 'â', 'Â', 'ã', 'Ã', 'ą', 'Ą', 'ā', 'Ā', 'ă', 'Ă', 'å', 'Å',
            'ḃ', 'Ḃ',
            'ć', 'Ć', 'č', 'Č', 'ç', 'Ç', 'ċ', 'Ċ', 'ĉ', 'Ĉ',
            'ď', 'Ď', 'ḋ', 'Ḋ', 'đ', 'Đ', 'ḍ', 'Ḍ',
            'ë', 'Ë', 'é', 'É', 'è', 'È', 'ê', 'Ê', 'ė', 'Ė', 'ĕ', 'Ĕ', 'ě', 'Ě', 'ē', 'Ē', 'ę', 'Ę',
            'ḟ', 'Ḟ',
            'ğ', 'Ğ', 'ģ', 'Ģ', 'ġ', 'Ġ', 'ĝ', 'Ĝ',
            'ḣ', 'Ḣ', 'ħ', 'Ħ', 'ḥ', 'Ḥ', 'ĥ', 'Ĥ',
            'ï', 'Ï', 'ĩ', 'Ĩ', 'ì', 'Ì', 'í', 'Í', 'î', 'Î', 'ĭ', 'Ĭ', 'ī', 'Ī', 'į', 'Į', 'İ',
            'ĵ', 'Ĵ',
            'ķ', 'Ķ', 'ḳ', 'Ḳ',
            'ĺ', 'Ĺ', 'ľ', 'Ľ', 'ļ', 'Ļ', 'ḷ', 'Ḷ',
            'ṁ', 'Ṁ', 'ṃ', 'Ṃ',
            'ń', 'Ń', 'ñ', 'Ñ', 'ň', 'Ň', 'ņ', 'Ņ', 'ṅ', 'Ṅ',
            'ö', 'Ö', 'ò', 'Ò', 'ó', 'Ó', 'ô', 'Ô', 'õ', 'Õ', 'ŏ', 'Ŏ', 'ȯ', 'Ȯ', 'ō', 'Ō', 'ő', 'Ő',
            'ṗ', 'Ṗ',
            'ŕ', 'Ŕ', 'ř', 'Ř', 'ŗ', 'Ŗ', 'ṙ', 'Ṙ', 'ṛ', 'Ṛ',
            'ś', 'Ś', 'š', 'Š', 'ş', 'Ş', 'ṡ', 'Ṡ', 'ṣ', 'Ṣ', 'ŝ', 'Ŝ',
            'ť', 'Ť', 'ţ', 'Ţ', 'ṫ', 'Ṫ', 'ŧ', 'Ŧ', 'ṭ', 'Ṭ',
            'ü', 'Ü', 'ù', 'Ù', 'ú', 'Ú', 'û', 'Û', 'ụ', 'Ụ', 'ũ', 'Ũ', 'ŭ', 'Ŭ', 'ū', 'Ū', 'ű', 'Ű', 'ů', 'Ů', 'ų', 'Ų',
            'ṿ', 'Ṿ',
            'ŵ', 'Ŵ',
            'ÿ', 'Ÿ', 'ý', 'Ý', 'ŷ', 'Ŷ',
            'ź', 'Ź', 'ž', 'Ž', 'ż', 'Ż',
            'ß', 'Ø', 'ø', 'Ł', 'ł', 'Æ', 'æ', 'Œ', 'œ', 'o͡o', '–', '—');

        $array_b = array('\"{a}', '\"{A}', '\`{a}', '\`{A}', "\'{a}", "\'{A}", '\^{a}', '\^{A}', '\~{a}', '\~{A}', '\k{a}', '\k{A}', '\={a}', '\={A}', '\u{a}', '\u{A}', 'r{a}', 'r{A}',
            '\.{b}', '\.{B}',
            "\'{c}", "\'{C}", '\v{c}', '\v{C}', '\c{c}', '\c{C}', '\.{c}', '\.{C}', '\^{c}', '\^{C}',
            '\v{d}', '\v{D}', '\.{d}', '\.{D}', '{d}', '{D}', '\d{d}', '\d{D}',
            '\"{e}', '\"{E}', "\'{e}", "\'{E}", "\`{e}", "\`{E}", '\^{e}', '\^{E}', '\.{e}', '\.{E}', '\u{e}', '\u{E}', 'v{e}', 'v{E}', '={e}', '={E}', '\k{e}', '\k{E}',
            '\.{f}', '\.{F}',
            '\u{g}', '\u{G}', '\c{g}', '\c{G}', '\.{g}', '\.{G}', '\^{g}', '\^{G}',
            '\.{h}', '\.{H}', '{h}', '{H}', '\d{h}', '\d{H}', '\^{h}', '\^{H}',
            '\"{i}', '\"{I}', '\~{i}', '\~{I}', '\`{i}', '\`{I}', "\'{i}", "\'{I}", '\^{i}', '\^{I}', '\u{i}', '\u{I}', '\={i}', '\={I}', '\k{i}', '\k{I}', '\.{I}',
            '\^{j}', '\^{J}',
            '\c{k}', '\c{K}', '\d{k}', '\d{K}',
            "\'{l}", "\'{L}", '\v{l}', '\v{L}', '\c{l}', '\c{L}', '\d{l}', '\d{L}',
            '\.{m}', '\.{M}', '\d{m}', '\d{M}',
            "\'{n}", "\'{N}", '\~{n}', '\~{N}', 'v{n}', 'v{N}', '\c{n}', '\c{N}', '\.{n}', '\.{N}',
            '\"{o}', '\"{O}', '\`{o}', '\`{O}', "\'{o}", "\'{O}", '\^{o}', '\^{O}', '\~{o}', '\~{O}', '\u{o}', '\u{O}', '\.{o}', '\.{O}', '\={o}', '\={O}', '\H{o}', '\H{O}',
            '\.{p}', '\.{P}',
            "\'{r}", "\'{R}", '\v{r}', '\v{R}', '\c{r}', '\c{R}', '\.{r}', '\.{R}', '\d{r}', '\d{R}',
            "\'{s}", "\'{S}", '\v{s}', '\v{S}', '\c{s}', '\c{S}', '\.{s}', '\.{S}', '\d{s}', '\d{S}', '\^{s}', '\^{S}',
            '\v{t}', '\v{T}', '\c{t}', '\c{T}', '\.{t}', '\.{T}', '{t}', '{T}', '\d{t}', '\d{T}',
            '\"{u}', '\"{U}', '\`{u}', '\`{U}', "\'{u}", "\'{U}", '\^{u}', '\^{U}', '\d{u}', '\d{U}', '\~{u}', '\~{U}', '\u{u}', '\u{U}', '\={u}', '\={U}', '\H{u}', '\H{U}', 'r{u}', 'r{U}', '\k{u}', '\k{U}',
            '\d{v}', '\d{V}',
            '\^{w}', '\^{W}',
            '\"{y}', '\"{Y}', "\'{y}", "\'{Y}", '\^{y}', '\^{Y}',
            "\'{z}", "\'{Z}", '\v{z}', '\v{Z}', '\.{z}', '\.{Z}',
            '\ss', '\O', '\o', '\L', '\l', '\AE', '\ae', '\OE', '\oe', '\t{oo}', '\textendash', '\textemdash',
        );
        $return = str_replace($array_a, $array_b, $input);
        return $return;
    }

    /**
     * Explodes an url string into array
     * @param string $url_string
     * @return array
     * @since 4.3.5
     */
    public static function explode_url($url_string)
    {
        $all_urls = explode(chr(13) . chr(10), $url_string);
        $end      = array();
        foreach ($all_urls as $url) {
            $parts    = explode(', ', $url);
            $parts[0] = trim($parts[0]);
            if (!isset($parts[1])) {
                $parts[1] = $parts[0];
            }
            $end[] = $parts;
        }
        return $end;
    }

}