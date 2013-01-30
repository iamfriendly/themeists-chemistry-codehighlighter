<?php

	if( !class_exists( 'ChemistryPotionCodeHighlighter' ) )
	{

		/**
		 * Just like the WordPress widget structure, we extend a class to make our potions
		 * We extend the chemistry_molecule_widget class.
		 *
		 * @author Richard Tape
		 * @package ChemistryPotionCodeHighlighter
		 * @since 1.0
		 */
		
		class ChemistryPotionCodeHighlighter extends chemistry_molecule_widget
		{

			/**
			 * Register this potion. It will add it to the overlay. If the 1st parameter that
			 * you pass to it's parent's __constructor() method is "example" then it will create
			 * a div with a class of "potion-type-example" as a wrapper and then another div
			 * with a class of potion-example. You should style the .chemistry-potion-inner with your
			 * appropriate icon, i.e.
			 *
			 * #potions-overlay .potion-type-example .chemistry-potion-inner{ styles_here }
			 *
			 * @author Richard Tape
			 * @package ChemistryPotionCodeHighlighter
			 * @since 1.0
			 * @param None
			 * @return None
			 */
			
			public function __construct()
			{

				parent::__construct( 'code', __( 'Code Highlighter' , 'chemistry' ) );
				$this->label = __( 'An easy-to-use syntax highgter for sharing code.' , 'chemistry' );

				//we need to add a filter to plugins_url as we use symlinks in our dev setup
				if( defined( 'LOCAL_DEV' ) && LOCAL_DEV )
					add_filter( 'plugins_url', array( &$this, 'local_dev_symlink_plugins_url_fix' ), 10, 3 );

			}/* __construct() */


			/* =========================================================================== */
			

			/**
			 * Output the markup for our code highlighter - ensure we load our styles and scripts first
			 *
			 * @author Richard Tape
			 * @package ChemistryPotionCodeHighlighter
			 * @since 1.0
			 * @param (array) $widget - widget config
			 * @return Markup
			 */
			
			public function widget( $widget )
			{

				//Load our necessary scripts and styles. Check for Chemistry so we can get the version
				if( class_exists( 'Chemistry' ) )
				{

					wp_enqueue_style( 'shCoreDefault', plugins_url( 'assets/css/sh/shCoreDefault.css', __FILE__ ), '', Chemistry::chemistry_option( 'chemistry_version' ) );

					wp_enqueue_script( 'shCore', plugins_url( 'assets/js/sh/shCore.js', __FILE__ ), '', Chemistry::chemistry_option( 'chemistry_version' ) );

					wp_enqueue_script( 'shAutoloader', plugins_url( 'assets/js/sh/shAutoloader.js', __FILE__ ), array( 'shCore' ), Chemistry::chemistry_option( 'chemistry_version' ) );

				}

				//Sanity check to ensure there is some output
				$code = isset( $widget['code'] ) ? $widget['code'] : '';

				//Where's your head at? As this is such a simple example, this is simply some basic markup
				$return = '<pre class="brush: ' . $widget['type'] . ';">' . htmlspecialchars( $code ) . '</pre>';
				
				//Filters as always
				return apply_filters( 'ChemistryPotionCodeHighlighter_markup', $return );

			}/* widget() */


			/* =========================================================================== */
			
			/**
			 * The admin form for this widget
			 *
			 * @author Richard Tape
			 * @package ChemistryPotionCodeHighlighter
			 * @since 1.0
			 * @param (array) $widget - The specific details for this widget
			 * @return The markup
			 */
			
			public function form( $widget )
			{

				//The code types we support
				$types = array( 

					'as3' 			=> __( 'AS3' , 'chemistry' ),
					'applescript'	=> __( 'Apple Script' , 'chemistry' ),
					'bash' 			=> __( 'Bash' , 'chemistry' ),
					'csharp' 		=> __( 'C#' , 'chemistry' ),
					'coldfusion' 	=> __( 'Cold Fusion' , 'chemistry' ),
					'cpp' 			=> __( 'C++' , 'chemistry' ),
					'css' 			=> __( 'CSS' , 'chemistry' ),
					'diff' 			=> __( 'Diff' , 'chemistry' ),
					'javascript' 	=> __( 'Java Script' , 'chemistry' ),
					'java' 			=> __( 'Java' , 'chemistry' ),
					'perl' 			=> __( 'Perl' , 'chemistry' ),
					'php' 			=> __( 'PHP' , 'chemistry' ),
					'plain' 		=> __( 'Plain' , 'chemistry' ),
					'python' 		=> __( 'Python' , 'chemistry' ),
					'ruby' 			=> __( 'Ruby' , 'chemistry' ),
					'sass' 			=> __( 'SASS' , 'chemistry' ),
					'xml' 			=> __( 'XML' , 'chemistry' )

				 );

				//Run these through a filter so we can register other types externally. Can see other options
				//http://alexgorbatchev.com/SyntaxHighlighter
				$types = apply_filters( 'chemistry_code_highlighter_types', $types );

				//Form markup for the overlay of our potion. Check out the chemistry docs to see how to form this
				$return = '<fieldset class="chemistry-form">
					<h2 class="chemistry-tab-title">' . __( 'General' , 'chemistry' ) . '</h2>
					<div class="chemistry-tab-content">
						<label><span class="label-title">' . __( 'Code type' , 'chemistry' ) . '</span> ' . $this->field( 'select', 'type', $widget, array( 'options' => $types ) ) . '</label>
						<label><span class="label-title">' . __( 'Code' , 'chemistry' ) . '</span> ' . $this->field( 'textarea', 'code', $widget ) . '</label>
					</div>
				</fieldset>';

				return $return;

			}/* form() */

			/* =========================================================================== */

			/**
			 * We use symlinks for our local dev (and on our staging site) so we need to filter
			 * plugins_url()
			 *
			 * @author Richard Tape
			 * @package ChemistryPotionCodeHighlighter
			 * @since 1.0
			 * @param 
			 * @return 
			 */
			
			function local_dev_symlink_plugins_url_fix( $url, $path, $plugin )
			{

				// Do it only for this plugin
				if ( strstr( $plugin, basename( __FILE__ ) ) )
					return str_replace( dirname( __FILE__ ), '/' . basename( dirname( $plugin ) ), $url );

				return $url;

			}/* local_dev_symlink_plugins_url_fix() */

		}/* class ChemistryPotionCodeHighlighter */

	}/* !class_exists( 'ChemistryPotionCodeHighlighter' ) */

?>