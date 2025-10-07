<?php
/**
 * Blossom Studio Dynamic Styles
 * 
 * @package Blossom_Studio
*/

function blossom_studio_dynamic_css(){
    
    $primary_font    = get_theme_mod( 'primary_font', 'Esteban' );
    $primary_fonts   = blossom_studio_get_fonts( $primary_font, 'regular' );
    $secondary_font  = get_theme_mod( 'secondary_font', 'DM Serif Text' );
    $secondary_fonts = blossom_studio_get_fonts( $secondary_font, 'regular' );
    $font_size       = get_theme_mod( 'font_size', 20 );
    
    $site_title_font      = get_theme_mod( 'site_title_font', array( 'font-family'=>'DM Serif Text', 'variant'=>'regular' ) );
    $site_title_fonts     = blossom_studio_get_fonts( $site_title_font['font-family'], $site_title_font['variant'] );
    $site_title_font_size = get_theme_mod( 'site_title_font_size', 30 );

    $site_title_color = get_theme_mod( 'site_title_color', '#111111' );
    $logo_width       = get_theme_mod( 'logo_width', 150 );
    
    $rgb_title = blossom_studio_hex2rgb( blossom_studio_sanitize_hex_color( $site_title_color ) );
    
    $featured_area_bg   = get_theme_mod( 'promo_bg' );

    $blog_section_bg      = get_theme_mod( 'blog_section_bg' );
     
    echo "<style type='text/css' media='all'>"; ?>
    
    /*Typography*/

	:root {
		--primary-font: <?php echo esc_html( $primary_fonts['font'] ); ?>;
		--secondary-font: <?php echo esc_html( $secondary_fonts['font'] ); ?>;
	}


    body,
    button,
    input,
    select,
    optgroup,
    textarea{
        font-family : <?php echo esc_html( $primary_fonts['font'] ); ?>;
        font-size   : <?php echo absint( $font_size ); ?>px;        
    }
    
    .site-title{
        font-size   : <?php echo absint( $site_title_font_size ); ?>px;
        font-family : <?php echo esc_html( $site_title_fonts['font'] ); ?>;
        font-weight : <?php echo esc_html( $site_title_fonts['weight'] ); ?>;
        font-style  : <?php echo esc_html( $site_title_fonts['style'] ); ?>;
    }
    
    .site-title a{
		color: <?php echo blossom_studio_sanitize_hex_color( $site_title_color ); ?>;
	}

    .site-description {
        <?php echo 'color: rgba(' . $rgb_title[0] . ', ' . $rgb_title[1] . ', ' . $rgb_title[2] . ', 0.75);'; ?>
    }

	.custom-logo-link img{
        width    : <?php echo absint( $logo_width ); ?>px;
        max-width: 100%;
    }

    .promo-section::after{
        background-image: url(<?php echo esc_url( $featured_area_bg ); ?>);
    }

    .blog-section::after {
        background-image: url('<?php echo esc_url( $blog_section_bg ); ?>');
    } 
         
    <?php echo "</style>";
}
add_action( 'wp_head', 'blossom_studio_dynamic_css', 99 );

/**
 * Function for sanitizing Hex color 
 */
function blossom_studio_sanitize_hex_color( $color ){
	if ( '' === $color )
		return '';

    // 3 or 6 hex digits, or the empty string.
	if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) )
		return $color;
}

/**
 * convert hex to rgb
 * @link http://bavotasan.com/2011/convert-hex-color-to-rgb-using-php/
*/
function blossom_studio_hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}

/**
 * Convert '#' to '%23'
*/
function blossom_studio_hash_to_percent23( $color_code ){
    $color_code = str_replace( "#", "%23", $color_code );
    return $color_code;
}

if ( ! function_exists( 'blossom_studio_gutenberg_inline_style' ) ) : 
/**
 * Gutenberg Dynamic Style
 */
function blossom_studio_gutenberg_inline_style(){
 
    /* Get Link Color */
    $primary_font    = get_theme_mod( 'primary_font', 'Esteban' );
    $primary_fonts   = blossom_studio_get_fonts( $primary_font, 'regular' );
    $secondary_font  = get_theme_mod( 'secondary_font', 'DM Serif Text' );
    $secondary_fonts = blossom_studio_get_fonts( $secondary_font, 'regular' );
 
    $custom_css = ':root .block-editor-page {
        --primary-font: ' . esc_html( $primary_fonts['font'] ) . ';
        --secondary-font: ' . esc_html( $secondary_fonts['font'] ) . ';
    }';

    return $custom_css;
}
endif;