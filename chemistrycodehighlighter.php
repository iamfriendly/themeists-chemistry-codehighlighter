<?php

	/*
	Plugin Name: Themeists Chemistry Code Highlighter Potion
	Plugin URI: http://themeists.com/plugins/chemistry-code-highlighter/
	Description:This plugin adds a code highligter to your Chemistry editor. It allows you to show off some great code snippets in your Chemistry templates
	Version: 1.0
	Author: Richard Tape
	Author URI: http://themeists.com/
	License: GPL2
	*/

	if( !class_exists( 'ChemistryCodeHighlighter' ) ):

		/**
		 * Adds an extra potion to the Chemistry editor for highlighting code.
		 *
		 * @author Richard Tape
		 * @package ChemistryCodeHighlighter
		 * @since 1.0
		 */
		
		class ChemistryCodeHighlighter
		{

			/**
			 * We might not be using a themeists theme (which means we can't add anything to the options panel).
			 * By default, we'll say we are not. We check if the theme's author is Themeists to set this to
			 * true during instantiation.
			 *
			 * @author Richard Tape
			 * @package ChemistryCodeHighlighter
			 * @since 1.0
			 */
			
			var $using_themeists_theme = false;
			

			/**
			 * Initialise ourselves and do a bit of setup. We need to hook into chemistry_external_potion
			 * to be able to add this new potion to our potions array
			 *
			 * @author Richard Tape
			 * @package ChemistryCodeHighlighter
			 * @since 1.0
			 * @param None
			 * @return None
			 */

			function ChemistryCodeHighlighter()
			{

				//We only load potions if we're using a Themeists theme
				$theme_data = wp_get_theme();
				$theme_author = $theme_data->display( 'Author', false );

				//Check the author name
				if( strtolower( trim( $theme_author ) ) == "themeists" )
					$this->using_themeists_theme = true;

				//If we're on a themeists theme, load the potion
				if( $this->using_themeists_theme )
					add_action( 'chemistry_external_potions', 	array( &$this, 'load_new_potion' ), 10, 1 );


			}/* ChemistryCodeHighlighter() */

			
			/**
			 * Load potion class from this plugin. First we load the potion class which acts similarly
			 * to a widget. Then pass that potion class to chemistry_molecule::use_potion()
			 *
			 * @author Richard Tape
			 * @package ChemistryCodeHighlighter
			 * @since 1.0
			 * @param None
			 * @return Uses use_potion()
			 */
			
			function load_new_potion()
			{

				//Set the potion class name and form the path to the class file
				$potion = 'ChemistryPotionCodeHighlighter';
				$potion_path = plugin_dir_path( __FILE__ ) . 'class.' . $potion . '.php';

				//If that file name exists, load it
				if( file_exists( $potion_path ) )
					require_once( $potion_path );

				//we're loaded, so instantiate
				if( class_exists( 'chemistry_molecule' ) && class_exists( $potion ) )
					chemistry_molecule::use_potion( $potion );

			}/* load_new_potion() */

			
		}/* class ChemistryCodeHighlighter */

	endif;


	//And so it begins
	$chemistry_code_highlighter = new ChemistryCodeHighlighter;

	/*

	@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
	@@                                                   @@
	@@                                                   @@
	@@                                                   @@
	@@                                                   @@
	@@                                                   @@
	@@                                                   @@
	@@                                                   @@
	@@                                                   @@
	@@    @@@@@@@@@@@@                                   @@
	@@    @@@@@@@@@@@@                                   @@
	@@    ++++#@@@++++                                   @@
	@@        ;@@+         ,     .                       @@
	@@        ;@@+   +@@ @@@@@ @@@@@                     @@
	@@        ;@@+   +@@@@@@@@@@@@@@@                    @@
	@@        ;@@+   +@@@  `@@@   @@@                    @@
	@@        ;@@+   +@@    @@@   @@@                    @@
	@@        ;@@+   +@@    @@@   @@@                    @@
	@@        ;@@+   +@@    @@@   @@@                    @@
	@@        ;@@+   +@@    @@@   @@@                    @@
	@@        ;@@+   +@@    @@@   @@@                    @@
	@@        ;@@+   +@@    @@@   @@@                    @@
	@@        ;@@+   +@@    @@@   @@@                    @@
	@@                                                   @@
	@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

	*/