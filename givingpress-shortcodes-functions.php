<?php

/*-----------------------------------------------------------------------------------------------------//
	Toggle Box Shortcode
-------------------------------------------------------------------------------------------------------*/

function givingpress_toggle( $atts, $content = null ) {

    extract(shortcode_atts(array(
    	'title'	=> 'Toggle Item',
   	), $atts));

	$out = '
		<div class="toggle-box">
		<p class="toggle-trigger"><a href="javascript:void(0);">' .$title. '</a></p>
		<div class="toggle-section"><p>' .do_shortcode($content). '</p></div>
		</div>';

    return $out;
}
add_shortcode('toggle', 'givingpress_toggle');

/*-----------------------------------------------------------------------------------------------------//
	Horizontal Rating Bar Shortcode
-------------------------------------------------------------------------------------------------------*/

function givingpress_rating($atts) {
    extract(shortcode_atts(array(
    	"title" => '',
        "number" => '50'
    ), $atts));
    return
    '<div class="rating-container">
    	<p class="rating-title">'.$title.'</p>
    	<div class="bar-rating"><span style="width:'.$number.'%;"></span></div>
    </div>';
}
add_shortcode("rating", "givingpress_rating");

/*-----------------------------------------------------------------------------------------------------//
	Modal Box Shortcode
-------------------------------------------------------------------------------------------------------*/

function givingpress_modal( $atts, $content = null ) {

    extract(shortcode_atts(array(
    	'title'	=> 'Open Modal',
    	'tag'	=> 'givingpress-modal',
	    'color'	=> '',
	    'size'	=> '',
	    'align'	=> '',
    ), $atts));

	$style = ($color) ? ' '.$color.'-btn' : '';
	$align = ($align) ? ' align-'.$align : '';

	$out = '
		<div class="modal-btn '.$align.'"><a class="givingpress-btn '.$style.' '.$size.'-btn '.$align.'" href="#'.$tag.'" rel="modal:open"><span class="btn-holder">' .$title. '</span></a></div>
		<div id="' .$tag. '" class="givingpress-modal" style="display: none;"><span class="modal-title">' .$title. '</span>' .do_shortcode($content). '</div>';

    return $out;
}
add_shortcode('modal', 'givingpress_modal');

/*-----------------------------------------------------------------------------------------------------//
	Accordion Shortcode
-------------------------------------------------------------------------------------------------------*/

function givingpress_accordion($atts, $content = null) {
    extract(shortcode_atts(array(
        "collapsible" => "false"
    ), $atts));

    $GLOBALS["section_count"] = 0;
    // Get the content
    do_shortcode($content);
    // Generate output
    if (is_array( $GLOBALS["sections"] )) {
        foreach ($GLOBALS["sections"] as $section) {
            $panes[] = '<p><a href="#'. str_replace(" ", "-", strtolower($section["name"])) .'">'. $section["name"] .'</a></p>
            <div id="'. str_replace(" ", "-", strtolower($section["name"])) .'">
            	'. do_shortcode($section["content"]) .'
            </div>';
        }
    }
    $output = "\n".'<div class="givingpress-accordion">'. implode("\n", $panes) .'</div>'."\n";

    unset( $GLOBALS["sections"] ); // Clear array fix for multiple shorcodes
    return $output;
}
add_shortcode("accordion", "givingpress_accordion");

function givingpress_accordion_section($atts, $content = null) {
    extract(shortcode_atts(array(
        "name" => "Accordion Section Name"
    ), $atts));

    $x = $GLOBALS["section_count"];
    $GLOBALS["sections"][$x] = array(
        "name"   => sprintf( $name, $GLOBALS["section_count"] ),
        "content" => do_shortcode($content)
    );
    $GLOBALS["section_count"] += 1;
}
add_shortcode("section", "givingpress_accordion_section");

/*-----------------------------------------------------------------------------------------------------//
	Tabs Shortcode
-------------------------------------------------------------------------------------------------------*/

function givingpress_tab_group( $atts, $content ){

	$GLOBALS['tab_count'] = 0;

	do_shortcode( $content );

	if( is_array( $GLOBALS['tabs'] ) ){
		$int = '1';
		foreach( $GLOBALS['tabs'] as $tab ){

			$tabs[] = '<li><a href="#panel-'.$int.'">'.$tab['title'].'</a></li>';

			$panes[] = '
			<div class="ui-tabs-hide" id="panel-'.$int.'">
				<h3>'.$tab['title'].'</h3>
				'.$tab['content'].'
			</div>';

			$int++;
		}

		$return = "\n".'
		<div class="givingpress-tabs">
			<ul id="tabs">'.implode( "\n", $tabs ).'</ul>
			'."\n".' '.implode( "\n", $panes ).'
		</div>'."\n";
	}

	unset( $GLOBALS['tabs'] ); // Clear array fix for multiple shorcodes
	return $return;
}
add_shortcode( 'tabs', 'givingpress_tab_group' );

function givingpress_tab( $atts, $content ){
	extract(shortcode_atts(array(
		'title' => 'Tab %d'
	), $atts));

	$x = $GLOBALS['tab_count'];
	$GLOBALS['tabs'][$x] = array( 'title' => sprintf( $title, $GLOBALS['tab_count'] ), 'content' => do_shortcode($content) );

	$GLOBALS['tab_count']++;
}
add_shortcode( 'tab', 'givingpress_tab' );


/*-----------------------------------------------------------------------------------------------------//
	Icons Shortcode
-------------------------------------------------------------------------------------------------------*/

function givingpress_icons( $atts, $content = null ) {

    extract(shortcode_atts(array(
	    'style'	=> '',
	    'color'	=> '',
    ), $atts));

	$out = '<span class="givingpress-icon"><i class="fa fa-'.$style.'" style="color: #'.$color.';"></i> ' .do_shortcode($content). '</span>';

    return $out;
}
add_shortcode('icon', 'givingpress_icons');

/*-----------------------------------------------------------------------------------------------------//
	Headline Shortcode
-------------------------------------------------------------------------------------------------------*/

function givingpress_headline( $atts, $content = null ) {

    extract(shortcode_atts(array(
	    'align'	=> 'left',
	    'color'	=> '000000',
	    'size'	=> 'large',
    ), $atts));

	$out = '<h2 class="givingpress-headline '.$size.'-headline" style="text-align: '.$align.'; color: #'.$color.';">' .do_shortcode($content). '</h2>';

    return $out;
}
add_shortcode('headline', 'givingpress_headline');

/*-----------------------------------------------------------------------------------------------------//
	Button Shortcode
-------------------------------------------------------------------------------------------------------*/

function givingpress_button( $atts, $content = null ) {

    extract(shortcode_atts(array(
	    'link'	=> '#',
	    'target'=> '',
	    'color'	=> '',
	    'size'	=> '',
	    'align'	=> '',
    ), $atts));

	$style = ($color) ? ' '.$color.'-btn' : '';
	$align = ($align) ? ' align-'.$align : '';
	$target = ($target == 'blank') ? ' target="_blank"' : '';

	$out = '<div class="btn-container '.$align.'"><a' .$target. ' class="givingpress-btn '.$style.' '.$size.'-btn '.$align.'" href="' .$link. '"><span class="btn-holder">' .do_shortcode($content). '</span></a></div>';

    return $out;
}
add_shortcode('button', 'givingpress_button');

/*-----------------------------------------------------------------------------------------------------//
	Message Box Shortcode
-------------------------------------------------------------------------------------------------------*/

function givingpress_box( $atts, $content = null ) {

    extract(shortcode_atts(array(
	    'color'	=> '',
	    'align'	=> '',
    ), $atts));

	$style = ($color) ? ' '.$color.'-box' : '';
	$align = ($align) ? ' text-'.$align : '';

	$out = '<div class="givingpress-box '.$style.$align.'"><a href="#blank" class="close"><i class="fa fa-times"></i></a><div class="box-content">' .do_shortcode($content). '</div></div>';

    return $out;
}
add_shortcode('box', 'givingpress_box');

/*-----------------------------------------------------------------------------------------------------//
	Column Shortcodes
-------------------------------------------------------------------------------------------------------*/

function givingpress_one_third( $atts, $content = null ) {
   return '<div class="givingpress-column one-third">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_third', 'givingpress_one_third');

function givingpress_one_third_last( $atts, $content = null ) {
   return '<div class="givingpress-column one-third last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_third_last', 'givingpress_one_third_last');

function givingpress_two_third( $atts, $content = null ) {
   return '<div class="givingpress-column two-third">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_third', 'givingpress_two_third');

function givingpress_two_third_last( $atts, $content = null ) {
   return '<div class="givingpress-column two-third last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('two_third_last', 'givingpress_two_third_last');

function givingpress_one_half( $atts, $content = null ) {
   return '<div class="givingpress-column one-half">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_half', 'givingpress_one_half');

function givingpress_one_half_last( $atts, $content = null ) {
   return '<div class="givingpress-column one-half last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_half_last', 'givingpress_one_half_last');

function givingpress_one_fourth( $atts, $content = null ) {
   return '<div class="givingpress-column one-fourth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_fourth', 'givingpress_one_fourth');

function givingpress_one_fourth_last( $atts, $content = null ) {
   return '<div class="givingpress-column one-fourth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_fourth_last', 'givingpress_one_fourth_last');

function givingpress_three_fourth( $atts, $content = null ) {
   return '<div class="givingpress-column three-fourth">' . do_shortcode($content) . '</div>';
}
add_shortcode('three_fourth', 'givingpress_three_fourth');

function givingpress_three_fourth_last( $atts, $content = null ) {
   return '<div class="givingpress-column three-fourth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('three_fourth_last', 'givingpress_three_fourth_last');

function givingpress_one_fifth( $atts, $content = null ) {
   return '<div class="givingpress-column one-fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_fifth', 'givingpress_one_fifth');

function givingpress_one_fifth_last( $atts, $content = null ) {
   return '<div class="givingpress-column one-fifth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_fifth_last', 'givingpress_one_fifth_last');

function givingpress_two_fifth( $atts, $content = null ) {
   return '<div class="givingpress-column two-fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_fifth', 'givingpress_two_fifth');

function givingpress_two_fifth_last( $atts, $content = null ) {
   return '<div class="givingpress-column two-fifth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('two_fifth_last', 'givingpress_two_fifth_last');

function givingpress_three_fifth( $atts, $content = null ) {
   return '<div class="givingpress-column three-fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('three_fifth', 'givingpress_three_fifth');

function givingpress_three_fifth_last( $atts, $content = null ) {
   return '<div class="givingpress-column three-fifth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('three_fifth_last', 'givingpress_three_fifth_last');

function givingpress_four_fifth( $atts, $content = null ) {
   return '<div class="givingpress-column four-fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('four_fifth', 'givingpress_four_fifth');

function givingpress_four_fifth_last( $atts, $content = null ) {
   return '<div class="givingpress-column four-fifth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('four_fifth_last', 'givingpress_four_fifth_last');

function givingpress_one_sixth( $atts, $content = null ) {
   return '<div class="givingpress-column one-sixth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_sixth', 'givingpress_one_sixth');

function givingpress_one_sixth_last( $atts, $content = null ) {
   return '<div class="givingpress-column one-sixth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_sixth_last', 'givingpress_one_sixth_last');

function givingpress_five_sixth( $atts, $content = null ) {
   return '<div class="givingpress-column five-sixth">' . do_shortcode($content) . '</div>';
}
add_shortcode('five_sixth', 'givingpress_five_sixth');

function givingpress_five_sixth_last( $atts, $content = null ) {
   return '<div class="givingpress-column five-sixth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('five_sixth_last', 'givingpress_five_sixth_last');

/*-----------------------------------------------------------------------------------------------------//
	Public Donor List Shortcode
-------------------------------------------------------------------------------------------------------*/

function givingpress_public_donor_list( $atts ) {

    extract(shortcode_atts(array(
    	'title'	=> 'Recent Donors',
   	), $atts));

    //Initialize Output String
    $out = '';

    //Get number of donors to show (Defaults to 50, max is 1000)
    if ( isset( $atts['number'] ) ) { $number_to_show = (int) $atts['number']; }
    if ( '0' >= $number_to_show || '1000' < $number_to_show ) {
      $number_to_show = 50;
    }

    //Get the latest 20 Give Donors
    $args = array(
      'number' => $number_to_show,
      'orderby' => 'date',
      'order' => 'DESC'
    );
    //First check that Give exist
    if ( class_exists( 'Give' ) ) {


      $out .= '<table class="donor-list"><tr><th>Donor</th><th>Amount</th></tr>';
      $donors = Give()->customers->get_customers( $args );
      //Loop Through Customers
      foreach ( $donors as $donor ) {
        $out .='<tr><td>'.$donor->name.'</td>';
        setlocale(LC_MONETARY, 'en_US');
        $out .= '<td>$'.money_format( '%i', $donor->purchase_value ).'</td></tr>';
      }

      $out.= '</table>';

    }
    return $out;

}
add_shortcode('donor_list', 'givingpress_public_donor_list');

/*-----------------------------------------------------------------------------------------------------//
	Empty paragraph tag and line break fix for shortcodes
-------------------------------------------------------------------------------------------------------*/

add_filter('the_content', 'shortcode_empty_paragraph_fix');

function shortcode_empty_paragraph_fix($content) {
    $array = array (
        '<p>[' => '[',
        ']</p>' => ']',
        ']<br />' => ']'
    );

    $content = strtr($content, $array);
    return $content;
}
