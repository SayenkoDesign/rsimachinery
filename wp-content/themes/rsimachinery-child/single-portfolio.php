<?php
/**
 * The template for displaying single portfolio.
 *
 * @package WPCharming
 */
global $wpc_option;
$page_layout     = get_post_meta( $post->ID, '_wpc_page_layout', true );
$page_breadcrumb = get_post_meta( $post->ID, '_wpc_hide_breadcrumb', true );
$hide_page_title = get_post_meta( $post->ID, '_wpc_hide_page_title', true );

$details = '';
foreach(get_field('detailed_equipment_info') as $detail) {
	$details .= '<strong>'.$detail['title'].'</strong>: '.$detail['value'].PHP_EOL;
}
$seller_details = get_field('details');
$gallery_items = [];
foreach(get_field('gallery') as $gallery) {
	$gallery_items[] = $gallery['id'];
}
$gallery_items_string = implode(',', $gallery_items);
$button_url = get_site_url().'/contact-us/?inventory_product='.get_the_ID();
$video_link = get_field('video');
$video_thumb = get_field('video_thumb');
if($video_link && $video_thumb) {
	$video = <<<HTML
		<div class="wpb_content_element featured-box ">
			<div class="featured-box-thumb">
				<a class="popup-video" href="$video_link"><img src="$video_thumb" alt="" /><span class="video_icon"><i class="fa fa-play"></i></span></a>
			</div>
		</div>
HTML;
} else {
	$video = '';
}
if($featured_id = get_post_thumbnail_id()) {
	$featured_image = '[vc_single_image image="' . $featured_id . '" border_color="grey" img_link_target="_blank" img_size="blog-large"]';
} else {
	$featured_image = '';
}
$content = <<<HTML
[vc_row row_type="row_center_content" bg_position="left top" bg_repeat="no-repeat" row_text_color="row_text_select" border_style="solid" padding_top="10" padding_bottom="10"][vc_column width="1/2"]
		$featured_image $video
		[vc_column_text][gallery link="file" ids="$gallery_items_string"][/vc_column_text]
	[/vc_column][vc_column width="1/2"]
		[wpc_custom_heading heading="Detailed Equipment Info" colored_line="yes" line_color="primary" position="left" size="medium"]
		[vc_column_text]
			$details
			<a class="btn btn-primary" style="margin-top: -20px;" href="$button_url">LET'S TALK »</a>
		[/vc_column_text]
		[wpc_custom_heading heading="Seller Comments" colored_line="yes" line_color="primary" position="left" size="medium"]
		[vc_column_text]<div class="wpb_text_column wpb_content_element ">$seller_details</div><div class="wpb_text_column wpb_content_element "></div>[/vc_column_text]
	[/vc_column]
[/vc_row]
HTML;

wpcharming_get_header() ?>

		<?php 
		global $post;
		wpcharming_get_page_header($post->ID);
		//wpcharming_get_page_title($post->ID);
		?>
		
		<?php if ( $hide_page_title != 'on' ) { ?>
		<div class="page-title-wrap">
			<div class="container">
				<h1 class="page-entry-title left">
					<?php the_title(); ?>
				</h1>
				<div class="portfolio-nav right">
					<?php
					$prev = get_adjacent_post(false, '', true);
    				$next = get_adjacent_post(false, '', false);
    				if($prev){
				        $url = get_permalink($prev->ID);
				        echo '<a href="' . $url . '" class="portfolio-prev" title="' . $prev->post_title . '"><i class="fa fa-angle-left"></i></a>';
				    }
				    if($next){
				        $url = get_permalink($next->ID);
				        echo '<a href="' . $url . '" class="portfolio-next" title="' . $next->post_title . '"><i class="fa fa-angle-right"></i></a>';
				    }
					?>
				</div>
			</div>
		</div>
		<?php } ?>
		
		<?php if ( $page_breadcrumb !== 'on' ) wpcharming_breadcrumb(); ?>

		<div id="content-wrap" class="<?php echo ( $page_layout == 'full-screen' ) ? '' : 'container'; ?> <?php echo wpcharming_get_layout_class(); ?>">
			<div id="primary" class="<?php echo ( $page_layout == 'full-screen' ) ? 'content-area-full' : 'content-area'; ?>">
				<main id="main" class="site-main" role="main">

					<?php while ( have_posts() ) : the_post(); ?>

						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<div class="entry-content">

								<?php echo apply_filters( 'the_content', $content ); ?>

								<?php
								wp_link_pages( array(
									'before' => '<div class="page-links">' . __( 'Pages:', 'wpcharming' ),
									'after'  => '</div>',
								) );
								?>
							</div><!-- .entry-content -->

						</article><!-- #post-## -->

					<?php endwhile; // end of the loop. ?>

				</main><!-- #main -->
			</div><!-- #primary -->
			
			<?php echo wpcharming_get_sidebar(); ?>

		</div> <!-- /#content-wrap -->

<?php get_footer(); ?>
