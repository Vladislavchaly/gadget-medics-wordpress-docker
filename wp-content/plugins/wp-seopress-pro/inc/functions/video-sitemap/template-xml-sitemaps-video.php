<?php
defined( 'ABSPATH' ) or die( 'Please don&rsquo;t call the plugin directly. Thanks :)' );

//XML

//Headers
if (function_exists('seopress_sitemaps_headers')) {
	seopress_sitemaps_headers();
}

//Remove primary category
remove_filter( 'post_link_category', 'seopress_titles_primary_cat_hook', 10, 3 ); 

//WPML
add_filter( 'wpml_get_home_url', 'seopress_remove_wpml_home_url_filter', 20, 5 );

add_filter( 'seopress_sitemaps_video_query', function( $args ) {
    global $sitepress, $sitepress_settings;

    $sitepress_settings['auto_adjust_ids'] = 0;
    remove_filter( 'terms_clauses', [ $sitepress, 'terms_clauses' ] );
    remove_filter( 'category_link', [ $sitepress, 'category_link_adjust_id' ], 1 );

    return $args;
});

function seopress_xml_sitemap_video() {
	$home_url = home_url().'/';
	
	if (function_exists('pll_home_url')) {
        $home_url = site_url().'/';
    }

	$seopress_sitemaps ='<?xml version="1.0" encoding="UTF-8"?>';
	$seopress_sitemaps .='<?xml-stylesheet type="text/xsl" href="'.$home_url.'sitemaps_xsl.xsl"?>';
	$seopress_sitemaps .= "\n";
	$seopress_sitemaps .='<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">';

	//CPT
	if (seopress_xml_sitemap_post_types_list_option() !='') {
		foreach (seopress_xml_sitemap_post_types_list_option() as $cpt_key => $cpt_value) {
			foreach ($cpt_value as $_cpt_key => $_cpt_value) {
				if($_cpt_value =='1') {
					$args = [
						'post_type' => $cpt_key, 
						'post_status' => 'publish', 
						'ignore_sticky_posts' => true, 
						'posts_per_page' => 1000, 
						'meta_query' => [
							'relation' => 'OR',
							[
								'key' => '_seopress_robots_index', 
								'value' => '', 
								'compare' => 'NOT EXISTS' 
							],
							[
								'key' => '_seopress_robots_index', 
								'value' => 'yes', 
								'compare' => '!=' 
							] 
						],
						'order' => 'DESC', 
						'orderby' => 'modified', 
						'lang' => '', 
						'has_password' => false
					];
					
					$args = apply_filters('seopress_sitemaps_video_query', $args, $cpt_key);

				    $postslist = get_posts( $args );
				    
					foreach ( $postslist as $post ) {
					  	setup_postdata( $post );
					  	
					  	$seopress_video_disabled     	= get_post_meta($post->ID,'_seopress_video_disabled', true);
					  	$seopress_video     			= get_post_meta($post->ID,'_seopress_video');

					  	if (!empty($seopress_video[0][0]["url"]) && $seopress_video_disabled !='yes') {
					  		$seopress_sitemaps .= "\n";
						  	$seopress_sitemaps .= '<url>';
						  	$seopress_sitemaps .= "\n";
							$seopress_sitemaps .= '<loc>';
							$seopress_sitemaps .= htmlspecialchars(urldecode(get_permalink($post->ID)));
							$seopress_sitemaps .= '</loc>';
							$seopress_sitemaps .= "\n";

							foreach ($seopress_video[0] as $key => $value) {
								$seopress_sitemaps .= '<video:video>';
								$seopress_sitemaps .= "\n";
								
								//Thumbnail
								$thumbnail = isset($seopress_video[0][$key]["thumbnail"]) ? $seopress_video[0][$key]["thumbnail"] : NULL;
								if ($thumbnail !='') {//Video Thumbnail
									$seopress_sitemaps .= '<video:thumbnail_loc>'.htmlspecialchars(urldecode(esc_attr(wp_filter_nohtml_kses($thumbnail)))).'</video:thumbnail_loc>';
									$seopress_sitemaps .= "\n";
								} elseif(get_the_post_thumbnail_url($post->ID) !='') {//Post Thumbnail
									$seopress_sitemaps .= '<video:thumbnail_loc>'.htmlspecialchars(urldecode(esc_attr(wp_filter_nohtml_kses(get_the_post_thumbnail_url($post->ID))))).'</video:thumbnail_loc>';
									$seopress_sitemaps .= "\n";
								}

								//Post Title
								$title = isset($seopress_video[0][$key]["title"]) ? $seopress_video[0][$key]["title"] : NULL;
								if ($title !='') {//Video Title
									$seopress_sitemaps .= '<video:title><![CDATA['.$title.']]></video:title>';
									$seopress_sitemaps .= "\n";
								} elseif(get_post_meta($post->ID,'_seopress_titles_title',true) !='') {//SEO Custom Title
									$seopress_sitemaps .= '<video:title><![CDATA['.get_post_meta($post->ID,'_seopress_titles_title',true).']]></video:title>';
									$seopress_sitemaps .= "\n";
								} elseif(get_the_title($post->ID) !='') {//Post title
									$seopress_sitemaps .= '<video:title><![CDATA['.get_the_title($post->ID).']]></video:title>';
									$seopress_sitemaps .= "\n";
								}

								//Description
								$desc = isset($seopress_video[0][$key]["desc"]) ? $seopress_video[0][$key]["desc"] : NULL;
								if ($desc !='') {//Video Description
									$seopress_sitemaps .= '<video:description><![CDATA['.$desc.']]></video:description>';
									$seopress_sitemaps .= "\n";
								} elseif(get_post_meta($post->ID,'_seopress_titles_desc',true) !='') {//SEO Custom Meta desc
									$seopress_sitemaps .= '<video:description><![CDATA['.get_post_meta($post->ID,'_seopress_titles_desc',true).']]></video:description>';
									$seopress_sitemaps .= "\n";
								} elseif (get_the_excerpt($post->ID) !='') {//Excerpt
									$seopress_sitemaps .= '<video:description><![CDATA['.wp_trim_words(esc_attr(wp_filter_nohtml_kses(htmlentities(get_the_excerpt($post->ID)))),60).']]></video:description>';
									$seopress_sitemaps .= "\n";
								}

								//URL
								$internal_video = isset($seopress_video[0][$key]['internal_video']) ? $seopress_video[0][$key]['internal_video'] : NULL;
								$url = isset($seopress_video[0][$key]["url"]) ? $seopress_video[0][$key]["url"] : NULL;

								if ($url !='' && $internal_video !='') {
									$seopress_sitemaps .= '<video:content_loc><![CDATA['.$url.']]></video:content_loc>';
									$seopress_sitemaps .= "\n";
								} elseif ($url !='') {
									$seopress_sitemaps .= '<video:player_loc><![CDATA['.$url.']]></video:player_loc>';
									$seopress_sitemaps .= "\n";
								}

								//Duration
								$duration = isset($seopress_video[0][$key]["duration"]) ? $seopress_video[0][$key]["duration"] : NULL;
								if ($duration !='') {
									$seopress_sitemaps .= '<video:duration>'.$duration.'</video:duration>';
									$seopress_sitemaps .= "\n";
								}

								//Rating
								$rating = isset($seopress_video[0][$key]["rating"]) ? $seopress_video[0][$key]["rating"] : NULL;
								if ($rating !='') {
									$seopress_sitemaps .= '<video:rating>'.$rating.'</video:rating>';
									$seopress_sitemaps .= "\n";
								}

								//View count
								$view_count = isset($seopress_video[0][$key]["view_count"]) ? $seopress_video[0][$key]["view_count"] : NULL;
								if ($view_count !='') {
									$seopress_sitemaps .= '<video:view_count>'.$view_count.'</video:view_count>';
									$seopress_sitemaps .= "\n";
								}
								
								//Publication date
								$seopress_sitemaps .= '<video:publication_date>'.get_the_modified_date('c', $post).'</video:publication_date>';
								$seopress_sitemaps .= "\n";

								//Family Friendly
								$family_friendly = isset($seopress_video[0][$key]["family_friendly"]) ? $seopress_video[0][$key]["family_friendly"] : NULL;
								if ($family_friendly !='') {
									$seopress_sitemaps .= '<video:family_friendly>no</video:family_friendly>';
									$seopress_sitemaps .= "\n";
								} else {
									$seopress_sitemaps .= '<video:family_friendly>yes</video:family_friendly>';
									$seopress_sitemaps .= "\n";
								}
								//Tags
								$tag = isset($seopress_video[0][$key]["tag"]) ? $seopress_video[0][$key]["tag"] : NULL;
								$seopress_target_kw ='';
								if (get_post_meta($post->ID,'_seopress_analysis_target_kw',true) !='') {
									$seopress_target_kw = get_post_meta($post->ID,'_seopress_analysis_target_kw',true).',';
								}
								
								if ($tag !='') {//Video tags
									$seopress_sitemaps .= '<video:tag>'.esc_attr(wp_filter_nohtml_kses($tag)).'</video:tag>';
									$seopress_sitemaps .= "\n";
								} else {//Post tags
									$tags = get_the_tags($post->ID);
									if ( ! empty( $tags ) ) {
										$tags_list;
										$count = count($tags);
										$i = 1;
										foreach ($tags as $tag) {
											$tags_list .= $tag->name;
											if ($i < $count) {
												$tags_list .=',';
											}
											$i++;
										}
									    $seopress_sitemaps .= '<video:tag>'.$seopress_target_kw.$tags_list.'</video:tag>';
										$seopress_sitemaps .= "\n";  
									}
								}
								//Cats
								$cat = isset($seopress_video[0][$key]["cat"]) ? $seopress_video[0][$key]["cat"] : NULL;
								if ($cat !='') {//Video categories
									$seopress_sitemaps .= '<video:category>'.esc_attr(wp_filter_nohtml_kses($cat)).'</video:category>';
									$seopress_sitemaps .= "\n";
								} else {//Post category
									$categories = get_the_category($post->ID);
									if ( ! empty( $categories ) ) {
									    $first_cat = esc_html( $categories[0]->name );
									    $seopress_sitemaps .= '<video:category>'.$first_cat.'</video:category>';
										$seopress_sitemaps .= "\n";  
									}
								}
								
								$seopress_sitemaps .= '</video:video>';
								$seopress_sitemaps .= "\n";
							}
							$seopress_sitemaps .= '</url>';
						}
					}
				}
			}
		}
	}
	$seopress_sitemaps .= "\n";
	$seopress_sitemaps .='</urlset>';

	$seopress_sitemaps = apply_filters( 'seopress_sitemaps_xml_video', $seopress_sitemaps );
	
	return $seopress_sitemaps;
} 
echo seopress_xml_sitemap_video();