<?php
/*------------------------------------------------------*/
/* CLIENT TESTIMONIALS
/*------------------------------------------------------*/
vc_map( array(
	"name"                      => __("Client Testimonial", "js_composer"),
	"base"                      => 'wpc_testimonial',
	"category"                  => __('WPC Elements', 'js_composer'),
	"description"               => '',
	"params"                    => array(
		array(
			'type'        => 'dropdown',
			'heading'     => __( 'Testimonial Style', 'js_composer' ),
			'param_name'  => 'style',
			'description' => __( 'Choose your testimonial style', 'js_composer' ),
			'default'	  => 'default',
			'value'       => array(
				__("Default, on a white background color", "js_composer") => "default",
				__("Inverted, on a dark background color", "js_composer") => "inverted"
			)
		),
		array(
			"type"			=> "textfield",
			"class"			=> "",
			"heading"		=> __("Client Name","js_composer"),
			"param_name"	=> "name",
			"value"			=> ""
		),
		array(
			"type"        => "attach_image",
			"class"       => "",
			"heading"     => __("Client Avatar","js_composer"),
			"param_name"  => "avatar",
			"value"       => "",
			"description" => "Client image, the size should be smaller than 200 x 200px"
		),
		array(
			'type'        => 'textarea',
			'heading'     => __( 'Testimonial Content', 'js_composer' ),
			'param_name'  => 'testimonial_content',
			'value'       => ''
		),
	),
) );
function wpc_shortcode_testimonial($atts, $content = null) {
	extract(shortcode_atts(array(
		'style'               => '',
		'name'                => '',
		'avatar'              => '',
		'testimonial_content' => ''
	), $atts));

	$output = null;
	$style_class = null;

	if ( $style == 'inverted' ) $style_class = ' inverted';

	$output .= '
	<div class="testimonial'. $style_class .'">';

		$output .= '
		<div class="testimonial-content">';

			if ( $testimonial_content ) {
			$output .= '
			<p>'. wp_kses_post($testimonial_content) .'</p>';
			}

		$output .= '
		</div>';

		$output .= '
		<div class="testimonial-header clearfix">';

			$output .= '
			<div class="testimonial-avatar"><img src="'. wp_get_attachment_url($avatar) .'" alt="'. esc_attr($name) .'"></div>';
			$output .= '
			<div class="testimonial-name font-heading">'. esc_attr($name) .'</div>';

		$output .= '
		</div>';

	$output .= '
	</div>';

	return $output;
}
add_shortcode('wpc_testimonial', 'wpc_shortcode_testimonial');


/*------------------------------------------------------*/
/* Featured Box
/*------------------------------------------------------*/
vc_map( array(
	"name"                      => __("Featured Box", "js_composer"),
	"base"                      => 'wpc_featured_box',
	"category"                  => __('WPC Elements', 'js_composer'),
	"description"               => '',
	"params"                    => array(
		array(
			"type"        => "attach_image",
			"class"       => "",
			"heading"     => __("Featured Box Image","js_composer"),
			"param_name"  => "image",
			"value"       => "",
			"description" => "It will display at the top of featured box."
		),
		array(
			"type"        => "textfield",
			"class"       => "",
			"heading"     => __("Video URL","js_composer"),
			"param_name"  => "video_url",
			"value"       => "",
			"description" => "Open a video lightbox when user click to featured image."
		),
		array(
			"type"			=> "textarea",
			"class"			=> "",
			"heading"		=> __("Featured Box Title","js_composer"),
			"param_name"	=> "title",
			"value"			=> ""
		),
		array(
			"type"			=> "textarea",
			"class"			=> "",
			"heading"		=> __("Featured Box Description","js_composer"),
			"param_name"	=> "desc",
			"value"			=> ""
		),
		array(
			'type'        => 'vc_link',
			'heading'     => __( 'URL (Link)', 'js_composer' ),
			'param_name'  => 'link',
			'description' => __( 'Featured Box permalink.', 'js_composer' ),
			//"dependency"  => Array('element' => "link", 'value' => array('custom'))
		),
		array(
			"type"			=> "textfield",
			"class"			=> "",
			"heading"		=> __("Read More Text","js_composer"),
			"param_name"	=> "more_text",
			"value"			=> ""
		),
		array(
			"type"       => "colorpicker",
			"class"      => "",
			"heading"    => __("Custom BG Color","js_composer"),
			"param_name" => "bg_color",
			"value"      => "",
		),
		array(
			'type'        => 'textfield',
			'heading'     => __( 'Extra class name', 'js_composer' ),
			'param_name'  => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
		)
	),
) );

function wpc_shortcode_featured_box($atts, $content = null) {
	extract(shortcode_atts(array(
		'image'     => '',
		'video_url' => '',
		'title'     => '',
		'desc'      => '',
		'link'      => '',
		'more_text' => '',
		'bg_color'  => '',
		'el_class'  => ''
	), $atts));

	$href = null;
	if ( $link !== '' ) { $href = vc_build_link($link); }

	$custom_bg = null;
	if ( $bg_color ) $custom_bg = ' style="background:'. $bg_color .'"';

	$output = null;
	
	$output .= '
	<div class="wpb_content_element featured-box ' . esc_attr($el_class) .'" '. $custom_bg .'>';

		if ( $image ) {
			$imgurl = wp_get_attachment_image_src( $image, 'medium-thumb');
			$output .= '
			<div class="featured-box-thumb">';

				if ( $video_url ) {
					$output .= '
					<a class="popup-video" href="'. esc_url($video_url) .'">
						<img src="'. $imgurl[0] .'">
						<span class="video_icon"><i class="fa fa-play"></i></span>
					</a>';
				} else {
					if( $link ) {
						$output .= '<a href="'. $href['url'] .'"><img src="'. $imgurl[0] .'"></a>';
					} else {
						$output .= '<img src="'. $imgurl[0] .'">';
					}
				}

			$output .= '
			</div>';
		}

		if ( $title || $desc || $more_text ) {
			$output .= '
			<div class="featured-box-content">';

				if ( $title ) {
					$output .= '<h4>'. wp_kses_post($title) .'</h4>';
				}

				if ( $desc ) {
					$output .= '
					<div class="featured-box-desc">';

						$output .= '<p>'. wp_kses_post($desc) .'</p>';

					$output .= '
					</div>';
				}

				if ( $more_text && $link ) {
					$output .= '
					<div class="featured-box-button">
						<a href="'. $href['url'] .'" class="">'. esc_attr($more_text) .'</a>
					</div>';
				}
			$output .= '
			</div>';
		}

	$output .= '
	</div>';


	return $output;
}
add_shortcode('wpc_featured_box', 'wpc_shortcode_featured_box');

/*------------------------------------------------------*/
/* CUSTOM HEADING
/*------------------------------------------------------*/
vc_map( array(
	"name"                      => __("Custom Heading", "js_composer"),
	"base"                      => 'wpc_custom_heading',
	"icon"                      => "",
	"show_settings_on_create"   => true,
	"category"                  => __('WPC Elements', 'js_composer'),
	//"description"               => __('Restaurant menu heading', 'js_composer'),
	"params"                    => array(
		array(
			'type'        => 'textarea',
			'holder'      => 'h2',
			'heading'     => __( 'Heading', 'js_composer' ),
			'param_name'  => 'heading',
			'admin_label' => true,
			'value'       => '',
			'description' => __('Custom heading, allow simple HTML code.', 'js_composer')
		),
		array(
			"type"       => "colorpicker",
			"class"      => "",
			"heading"    => __("Heading Color","js_composer"),
			"param_name" => "heading_color",
			"value"      => ""
		),
		array(
			"type"        => "checkbox",
			"class"       => "",
			"heading"     => __("Display a colored line below heading?","js_composer"),
			"value"       => array( __("Yes.","js_composer") => "yes" ),
			"param_name"  => "colored_line",
			"description" => ""
		),

		array(
			'type'               => 'dropdown',
			'heading'            => __( 'Custom Line Color', 'js_composer' ),
			'param_name'         => 'line_color',
			'description'        => __( 'Heading custom line color.', 'js_composer' ),
			'value'              => array(
				__("Primary Color", "js_composer")   => "primary",
				__("Secondary Color", "js_composer") => "secondary",
				__("Custom Color", "js_composer") => "custom",
			)
		),
		array(
			"type"       => "colorpicker",
			"class"      => "",
			"heading"    => __("Custom Line Color","js_composer"),
			"param_name" => "line_custom_color",
			"value"      => "",
			"dependency" => Array('element' => "line_color", 'value' => array('custom'))
		),

		array(
			'type'        => 'dropdown',
			'heading'     => __( 'Heading Position', 'js_composer' ),
			'param_name'  => 'position',
			'value'       => array(
				__("Left", "js_composer")   => "left",
				__("Center", "js_composer") => "center",
				__("Right", "js_composer")  => "right"
			)
		),
		array(
			'type'        => 'dropdown',
			'heading'     => __( 'Heading Size', 'js_composer' ),
			'param_name'  => 'size',
			'value'       => array(
				__("Large", "js_composer")   => "large",
				__("Medium", "js_composer") => "medium",
				__("Small", "js_composer")  => "small"
			)
		),
		array(
			"type"			=> "textfield",
			"class"			=> "",
			"heading"		=> __("Custom Margin Top","js_composer"),
			"param_name"	=> "margin_top",
			"value"			=> "",
			"description" 	=> "Don't include \"px\" in your string. e.g \"50\"",
		),
		array(
			"type"			=> "textfield",
			"class"			=> "",
			"heading"		=> __("Custom Margin Bottom","js_composer"),
			"param_name"	=> "margin_bottom",
			"value"			=> "",
			"description" 	=> "Don't include \"px\" in your string. e.g \"50\"",
		),
		array(
			'type'        => 'textfield',
			'heading'     => __( 'Extra class name', 'js_composer' ),
			'param_name'  => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
		)
	),
) );
function wpc_shortcode_custom_heading($atts, $content = null) {
	extract(shortcode_atts(array(
		'heading'           => '',
		'heading_color'     => '',
		'colored_line'      => '',
		'line_color'        => '',
		'line_custom_color' => '',
		'position'          => '',
		'size'				=> '',
		'margin_top'        => '',
		'margin_bottom'     => '',
		'el_class'          => ''
	), $atts));

	$heading_style_color = '';
	if ( $heading_color ) {
		$heading_style_color = ' style="color: '. $heading_color .';"';
	}

	$extract_class = '';
	if ( $el_class ) $extract_class = $el_class;

	$position_class = '';
	if ( $position == 'right' ) $position_class = ' text-right';
	if ( $position == 'center' ) $position_class = ' text-center';

	$heading_size = '';
	if ( $size     == 'medium' ) $heading_size = ' heading-medium';
	if ( $size == 'small' ) $heading_size = ' heading-small';

	// Custom Style
	$custom_styles = array();
		if ( $margin_top ) {
			$custom_styles[] = 'margin-top: ' . intval($margin_top) . 'px;';
		}
		if ( $margin_bottom ) {
			$custom_styles[] = 'margin-bottom: ' . intval($margin_bottom) . 'px;';
		}
	$custom_styles = implode('', $custom_styles);
	if ( $custom_styles ) {
		$custom_styles = wp_kses( $custom_styles, array() );
		$custom_styles = ' style="' . esc_attr($custom_styles) . '"';
	}

	$line_class = '';
	$line_color_custom = '';
	if ( $line_color == 'primary' ) {
		$line_class = 'primary';
	} 
	if ( $line_color == 'secondary' ) {
		$line_class = 'secondary';
	} 
	if ( $line_color == 'custom' ) {
		$line_class = '';
	} 

	if ( $line_custom_color && $line_color == 'custom' ) $line_color_custom = 'style="background-color: '. $line_custom_color .'"';

	$output = null;

	$output .= '
	<div class="custom-heading wpb_content_element '. $extract_class . $heading_size . $position_class .'"'. $custom_styles .'>';

		if ( $heading ) $output .= '
		<h2 class="heading-title" '. $heading_style_color .'>'. wp_kses_post($heading) .'</h2>';

		if ( $colored_line ) $output .= '
		<span class="heading-line '. $line_class .'"'. $line_color_custom .'></span>';

	$output .= '
	</div>';

	return $output;
}
add_shortcode('wpc_custom_heading', 'wpc_shortcode_custom_heading');
