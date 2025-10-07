<?php
/**
 * Blossom Studio Customizer Typography Control
 *
 * @package Blossom_Studio
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Blossom_Studio_Typography_Control' ) ) {
    
    class Blossom_Studio_Typography_Control extends WP_Customize_Control {
    
    	public $tooltip = '';
    	public $js_vars = array();
    	public $output = array();
    	public $option_type = 'theme_mod';
    	public $type = 'blossom-studio-typography';
    
    	/**
    	 * Refresh the parameters passed to the JavaScript via JSON.
    	 *
    	 * @access public
    	 * @return void
    	 */
    	public function to_json() {
    		parent::to_json();
    
    		if ( isset( $this->default ) ) {
    			$this->json['default'] = $this->default;
    		} else {
    			$this->json['default'] = $this->setting->default;
    		}
    		$this->json['js_vars'] = $this->js_vars;
    		$this->json['output']  = $this->output;
    		$this->json['value']   = $this->value();
    		$this->json['choices'] = $this->choices;
    		$this->json['link']    = $this->get_link();
    		$this->json['tooltip'] = $this->tooltip;
    		$this->json['id']      = $this->id;
    		$this->json['l10n']    = apply_filters( 'blossom_studio_il8n_strings', array(
    			'on'                 => esc_attr__( 'ON', 'blossom-studio' ),
    			'off'                => esc_attr__( 'OFF', 'blossom-studio' ),
    			'all'                => esc_attr__( 'All', 'blossom-studio' ),
    			'cyrillic'           => esc_attr__( 'Cyrillic', 'blossom-studio' ),
    			'cyrillic-ext'       => esc_attr__( 'Cyrillic Extended', 'blossom-studio' ),
    			'devanagari'         => esc_attr__( 'Devanagari', 'blossom-studio' ),
    			'greek'              => esc_attr__( 'Greek', 'blossom-studio' ),
    			'greek-ext'          => esc_attr__( 'Greek Extended', 'blossom-studio' ),
    			'khmer'              => esc_attr__( 'Khmer', 'blossom-studio' ),
    			'latin'              => esc_attr__( 'Latin', 'blossom-studio' ),
    			'latin-ext'          => esc_attr__( 'Latin Extended', 'blossom-studio' ),
    			'vietnamese'         => esc_attr__( 'Vietnamese', 'blossom-studio' ),
    			'hebrew'             => esc_attr__( 'Hebrew', 'blossom-studio' ),
    			'arabic'             => esc_attr__( 'Arabic', 'blossom-studio' ),
    			'bengali'            => esc_attr__( 'Bengali', 'blossom-studio' ),
    			'gujarati'           => esc_attr__( 'Gujarati', 'blossom-studio' ),
    			'tamil'              => esc_attr__( 'Tamil', 'blossom-studio' ),
    			'telugu'             => esc_attr__( 'Telugu', 'blossom-studio' ),
    			'thai'               => esc_attr__( 'Thai', 'blossom-studio' ),
    			'serif'              => _x( 'Serif', 'font style', 'blossom-studio' ),
    			'sans-serif'         => _x( 'Sans Serif', 'font style', 'blossom-studio' ),
    			'monospace'          => _x( 'Monospace', 'font style', 'blossom-studio' ),
    			'font-family'        => esc_attr__( 'Font Family', 'blossom-studio' ),
    			'font-size'          => esc_attr__( 'Font Size', 'blossom-studio' ),
    			'font-weight'        => esc_attr__( 'Font Weight', 'blossom-studio' ),
    			'line-height'        => esc_attr__( 'Line Height', 'blossom-studio' ),
    			'font-style'         => esc_attr__( 'Font Style', 'blossom-studio' ),
    			'letter-spacing'     => esc_attr__( 'Letter Spacing', 'blossom-studio' ),
    			'text-align'         => esc_attr__( 'Text Align', 'blossom-studio' ),
    			'text-transform'     => esc_attr__( 'Text Transform', 'blossom-studio' ),
    			'none'               => esc_attr__( 'None', 'blossom-studio' ),
    			'uppercase'          => esc_attr__( 'Uppercase', 'blossom-studio' ),
    			'lowercase'          => esc_attr__( 'Lowercase', 'blossom-studio' ),
    			'top'                => esc_attr__( 'Top', 'blossom-studio' ),
    			'bottom'             => esc_attr__( 'Bottom', 'blossom-studio' ),
    			'left'               => esc_attr__( 'Left', 'blossom-studio' ),
    			'right'              => esc_attr__( 'Right', 'blossom-studio' ),
    			'center'             => esc_attr__( 'Center', 'blossom-studio' ),
    			'justify'            => esc_attr__( 'Justify', 'blossom-studio' ),
    			'color'              => esc_attr__( 'Color', 'blossom-studio' ),
    			'select-font-family' => esc_attr__( 'Select a font-family', 'blossom-studio' ),
    			'variant'            => esc_attr__( 'Variant', 'blossom-studio' ),
    			'style'              => esc_attr__( 'Style', 'blossom-studio' ),
    			'size'               => esc_attr__( 'Size', 'blossom-studio' ),
    			'height'             => esc_attr__( 'Height', 'blossom-studio' ),
    			'spacing'            => esc_attr__( 'Spacing', 'blossom-studio' ),
    			'ultra-light'        => esc_attr__( 'Ultra-Light 100', 'blossom-studio' ),
    			'ultra-light-italic' => esc_attr__( 'Ultra-Light 100 Italic', 'blossom-studio' ),
    			'light'              => esc_attr__( 'Light 200', 'blossom-studio' ),
    			'light-italic'       => esc_attr__( 'Light 200 Italic', 'blossom-studio' ),
    			'book'               => esc_attr__( 'Book 300', 'blossom-studio' ),
    			'book-italic'        => esc_attr__( 'Book 300 Italic', 'blossom-studio' ),
    			'regular'            => esc_attr__( 'Normal 400', 'blossom-studio' ),
    			'italic'             => esc_attr__( 'Normal 400 Italic', 'blossom-studio' ),
    			'medium'             => esc_attr__( 'Medium 500', 'blossom-studio' ),
    			'medium-italic'      => esc_attr__( 'Medium 500 Italic', 'blossom-studio' ),
    			'semi-bold'          => esc_attr__( 'Semi-Bold 600', 'blossom-studio' ),
    			'semi-bold-italic'   => esc_attr__( 'Semi-Bold 600 Italic', 'blossom-studio' ),
    			'bold'               => esc_attr__( 'Bold 700', 'blossom-studio' ),
    			'bold-italic'        => esc_attr__( 'Bold 700 Italic', 'blossom-studio' ),
    			'extra-bold'         => esc_attr__( 'Extra-Bold 800', 'blossom-studio' ),
    			'extra-bold-italic'  => esc_attr__( 'Extra-Bold 800 Italic', 'blossom-studio' ),
    			'ultra-bold'         => esc_attr__( 'Ultra-Bold 900', 'blossom-studio' ),
    			'ultra-bold-italic'  => esc_attr__( 'Ultra-Bold 900 Italic', 'blossom-studio' ),
    			'invalid-value'      => esc_attr__( 'Invalid Value', 'blossom-studio' ),
    		) );
    
    		$defaults = array( 'font-family'=> false );
    
    		$this->json['default'] = wp_parse_args( $this->json['default'], $defaults );
    	}
    
    	/**
    	 * Enqueue scripts and styles.
    	 *
    	 * @access public
    	 * @return void
    	 */
    	public function enqueue() {
    		wp_enqueue_style( 'blossom-studio-typography', get_template_directory_uri() . '/inc/custom-controls/typography/typography.css', null );
            
            wp_enqueue_script( 'jquery-ui-core' );
    		wp_enqueue_script( 'jquery-ui-tooltip' );
    		wp_enqueue_script( 'jquery-stepper-min-js' );
    		wp_enqueue_script( 'blossom-studio-selectize', get_template_directory_uri() . '/inc/js/selectize.js', array( 'jquery' ), false, true );
    		wp_enqueue_script( 'blossom-studio-typography', get_template_directory_uri() . '/inc/custom-controls/typography/typography.js', array( 'jquery', 'blossom-studio-selectize' ), false, true );
    
    		$google_fonts   = Blossom_Studio_Fonts::get_google_fonts();
    		$standard_fonts = Blossom_Studio_Fonts::get_standard_fonts();
    		$all_variants   = Blossom_Studio_Fonts::get_all_variants();
    
    		$standard_fonts_final = array();
    		foreach ( $standard_fonts as $key => $value ) {
    			$standard_fonts_final[] = array(
    				'family'      => $value['stack'],
    				'label'       => $value['label'],
    				'is_standard' => true,
    				'variants'    => array(
    					array(
    						'id'    => 'regular',
    						'label' => $all_variants['regular'],
    					),
    					array(
    						'id'    => 'italic',
    						'label' => $all_variants['italic'],
    					),
    					array(
    						'id'    => '700',
    						'label' => $all_variants['700'],
    					),
    					array(
    						'id'    => '700italic',
    						'label' => $all_variants['700italic'],
    					),
    				),
    			);
    		}
    
    		$google_fonts_final = array();
    
    		if ( is_array( $google_fonts ) ) {
    			foreach ( $google_fonts as $family => $args ) {
    				$label    = ( isset( $args['label'] ) ) ? $args['label'] : $family;
    				$variants = ( isset( $args['variants'] ) ) ? $args['variants'] : array( 'regular', '700' );
    
    				$available_variants = array();
    				foreach ( $variants as $variant ) {
    					if ( array_key_exists( $variant, $all_variants ) ) {
    						$available_variants[] = array( 'id' => $variant, 'label' => $all_variants[ $variant ] );
    					}
    				}
    
    				$google_fonts_final[] = array(
    					'family'   => $family,
    					'label'    => $label,
    					'variants' => $available_variants
    				);
    			}
    		}
    
    		$final = array_merge( $standard_fonts_final, $google_fonts_final );
    		wp_localize_script( 'blossom-studio-typography', 'all_fonts', $final );
    	}
    
    	/**
    	 * An Underscore (JS) template for this control's content (but not its container).
    	 *
    	 * Class variables for this control class are available in the `data` JS object;
    	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
    	 *
    	 * I put this in a separate file because PhpStorm didn't like it and it fucked with my formatting.
    	 *
    	 * @see    WP_Customize_Control::print_template()
    	 *
    	 * @access protected
    	 * @return void
    	 */
    	protected function content_template(){ ?>
    		<# if ( data.tooltip ) { #>
                <a href="#" class="tooltip hint--left" data-hint="{{ data.tooltip }}"><span class='dashicons dashicons-info'></span></a>
            <# } #>
            
            <label class="customizer-text">
                <# if ( data.label ) { #>
                    <span class="customize-control-title">{{{ data.label }}}</span>
                <# } #>
                <# if ( data.description ) { #>
                    <span class="description customize-control-description">{{{ data.description }}}</span>
                <# } #>
            </label>
            
            <div class="wrapper">
                <# if ( data.default['font-family'] ) { #>
                    <# if ( '' == data.value['font-family'] ) { data.value['font-family'] = data.default['font-family']; } #>
                    <# if ( data.choices['fonts'] ) { data.fonts = data.choices['fonts']; } #>
                    <div class="font-family">
                        <h5>{{ data.l10n['font-family'] }}</h5>
                        <select id="blossom-studio-typography-font-family-{{{ data.id }}}" placeholder="{{ data.l10n['select-font-family'] }}"></select>
                    </div>
                    <div class="variant blossom-studio-variant-wrapper">
                        <h5>{{ data.l10n['style'] }}</h5>
                        <select class="variant" id="blossom-studio-typography-variant-{{{ data.id }}}"></select>
                    </div>
                <# } #>   
                
            </div>
            <?php
    	} 

        protected function render_content(){
        }   
    }
}