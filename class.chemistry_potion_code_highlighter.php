<?php

	if( !class_exists( 'chemistry_potion_code_highlighter' ) )
	{

		class chemistry_potion_code_highlighter extends chemistry_molecule_widget
		{

			/**
			 * Register this potion. It will add it to the overlay. If the 1st parameter that
			 * you pass to it's parent's __constructor() method is "example" then it will create
			 * a div with a class of "molecule-widget-type-example" as a wrapper and then another div
			 * with a class of potion-code. You should style the .molecule-widget-bar with your
			 * appropriate icon, i.e.
			 *
			 * #molecule-widgets .molecule-widget-type-example .molecule-widget-bar{ styles_here }
			 *
			 * @author Richard Tape
			 * @package Chemistry
			 * @since 0.7
			 * @param None
			 * @return None
			 */
			
			public function __construct()
			{

				parent::__construct( 'code', __( 'Code Highlighter' , 'chemistry' ) );
				$this->label = __( 'An easy-to-use syntax highgter for sharing code.' , 'chemistry' );

				//we need to add a filter to plugins_url as we use symlinks in our dev setup
				add_filter( 'plugins_url', array( &$this, 'local_dev_symlink_plugins_url_fix' ), 10, 3 );

			}/* __construct() */


			/* =========================================================================== */
			
			/**
			 * Out the markup for our code highlighter - ensure we load our styles and scripts first
			 *
			 * @author Richard Tape
			 * @package Chemistry
			 * @since 0.7
			 * @param (array) $widget - widget config
			 * @return Markup
			 */
			
			public function widget( $widget )
			{

				//Load our necessary scripts and styles
				wp_enqueue_style( 'shCoreDefault', plugins_url( '_a/css/sh/shCoreDefault.css', __FILE__ ), '', Chemistry::chemistry_option( 'chemistry_version' ) );

				wp_enqueue_script( 'shCore', plugins_url( '_a/js/sh/shCore.js', __FILE__ ), '', Chemistry::chemistry_option( 'chemistry_version' ) );

				wp_enqueue_script( 'shAutoloader', plugins_url( '_a/js/sh/shAutoloader.js', __FILE__ ), array( 'shCore' ), Chemistry::chemistry_option( 'chemistry_version' ) );



				//Sanity check
				$code = isset( $widget['code'] ) ? $widget['code'] : '';

				//Where's your head at?
				$return = '<pre class="brush: ' . $widget['type'] . ';">' . htmlspecialchars( $code ) . '</pre>';
				return apply_filters( 'chemistry_potion_code_highlighter_markup', $return );

			}/* widget() */


			/* =========================================================================== */
			
			/**
			 * The admin form for this widget
			 *
			 * @author Richard Tape
			 * @package Chemistry
			 * @since 0.7
			 * @param (array) $widget - The specific details for this widget
			 * @return The markup
			 */
			
			public function form( $widget )
			{

				//The code types we support
				$types = array( 

					'as3' => __( 'AS3' , 'chemistry' ),
					'applescript' => __( 'Apple Script' , 'chemistry' ),
					'bash' => __( 'Bash' , 'chemistry' ),
					'csharp' => __( 'C#' , 'chemistry' ),
					'coldfusion' => __( 'Cold Fusion' , 'chemistry' ),
					'cpp' => __( 'C++' , 'chemistry' ),
					'css' => __( 'CSS' , 'chemistry' ),
					'diff' => __( 'Diff' , 'chemistry' ),
					'javascript' => __( 'Java Script' , 'chemistry' ),
					'java' => __( 'Java' , 'chemistry' ),
					'perl' => __( 'Perl' , 'chemistry' ),
					'php' => __( 'PHP' , 'chemistry' ),
					'plain' => __( 'Plain' , 'chemistry' ),
					'python' => __( 'Python' , 'chemistry' ),
					'ruby' => __( 'Ruby' , 'chemistry' ),
					'sass' => __( 'SASS' , 'chemistry' ),
					'xml' => __( 'XML' , 'chemistry' )

				 );

				$types = apply_filters( 'chemistry_code_highlighter_types', $types );

				//Form markup
				$return = '<fieldset class="chemistry-form">
					<h2 class="chemistry-tab-title">' . __( 'General' , 'chemistry' ) . '</h2>
					<div class="chemistry-tab-content">
						<label><span class="label-title">' . __( 'Code type' , 'chemistry' ) . '</span> ' . $this->field( 'select', 'type', $widget, array( 'options' => $types ) ) . '</label>
						<label><span class="label-title">' . __( 'Code' , 'chemistry' ) . '</span> ' . $this->field( 'textarea', 'code', $widget ) . '</label>
					</div>
				</fieldset>';

				return apply_filters( 'chemistry_code_highlighter_markup', $return );

			}/* form() */

			/* =========================================================================== */

			function local_dev_symlink_plugins_url_fix( $url, $path, $plugin )
			{

				// Do it only for this plugin
				if ( strstr( $plugin, basename( __FILE__ ) ) )
					return str_replace( dirname( __FILE__ ), '/' . basename( dirname( $plugin ) ), $url );

				return $url;

			}/* local_dev_symlink_plugins_url_fix() */

		}/* class chemistry_potion_code_highlighter */

	}/* !class_exists( 'chemistry_potion_code_highlighter' ) */

?>