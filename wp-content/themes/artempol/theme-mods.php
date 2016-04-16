<?php

function artempol_customize_register( $wp_customize ) {
	
	$wp_customize->add_section( 'artempol-options', array(
        'title'    => __( 'Template options', 'artempol' ),
        'priority' => 120,
    ));
	// Color scheme
    $wp_customize->add_setting( 'color-scheme', array(
        'default' => 'standart', 
    )); 
    $wp_customize->add_control ( 'color-scheme', array(
        'label'      => __( 'Color scheme', 'artempol' ),
        'section'    => 'artempol-options',
        'setting'    => 'color-scheme',
		'type'     	 => 'select',
		'choices'    => array(
			'original'  => __( 'Standart', 'artempol' ),
			'blue' 		=> __( 'Blue', 'artempol' ),
			'green' 	=> __( 'Green', 'artempol' ),
			'colored' 	=> __( 'Colored', 'artempol' ),
		),
    ));
	// Phone in header
    $wp_customize->add_setting( 'site-name', array(
        'default' => '', 
    ));    
    $wp_customize->add_control ( 'site-name', array(
        'label'      => __( 'Site name', 'artempol' ),
        'section'    => 'artempol-options',
        'settings'   => 'site-name',
    ));
    // Phone in header
    $wp_customize->add_setting( 'header-phone', array(
        'default' => '', 
    ));    
    $wp_customize->add_control ( 'header-phone', array(
        'label'      => __( 'Header phone', 'artempol' ),
        'section'    => 'artempol-options',
        'settings'   => 'header-phone',
    ));
    // Address in header
    $wp_customize->add_setting( 'header-address', array(
        'default' => '', 
    ));    
    $wp_customize->add_control ( 'header-address', array(
        'label'      => __( 'Header address', 'artempol' ),
        'section'    => 'artempol-options',
        'settings'   => 'header-address',
    ));
    // Time in header
    $wp_customize->add_setting( 'header-time', array(
        'default' => '', 
    ));    
    $wp_customize->add_control ( 'header-time', array(
        'label'      => __( 'Header time', 'artempol' ),
        'section'    => 'artempol-options',
        'settings'   => 'header-time',
    ));
    // Address in footer
    $wp_customize->add_setting( 'footer-address', array(
        'default' => '', 
    ));    
    $wp_customize->add_control ( 'footer-address', array(
        'label'      => __( 'Footer address', 'artempol' ),
        'section'    => 'artempol-options',
        'settings'   => 'footer-address',
    ));
    // Email in footer
    $wp_customize->add_setting( 'footer-email', array(
        'default' => '', 
    ));    
    $wp_customize->add_control ( 'footer-email', array(
        'label'      => __( 'Email', 'artempol' ),
        'section'    => 'artempol-options',
        'settings'   => 'footer-email',
    ));
    // Copyright
    $wp_customize->add_setting( 'copyright', array(
        'default' => '', 
    ));    
    $wp_customize->add_control ( 'copyright', array(
        'label'      => __( 'Copyright', 'artempol' ),
        'section'    => 'artempol-options',
        'settings'   => 'copyright',
    ));
	// Map
    $wp_customize->add_setting( 'map', array(
        'default' => '', 
    ));    
    $wp_customize->add_control ( 'map', array(
        'label'      => __( 'Map', 'artempol' ),
		'type'     	 => 'textarea',
        'section'    => 'artempol-options',
        'settings'   => 'map',
    ));
	// Achievements_page
    $wp_customize->add_setting( 'achievements-page', array(
        'default' => '', 
    ));     
    $wp_customize->add_control ( 'achievements-page', array(
        'label'   => __( 'Achievements page', 'artempol' ),
        'section' => 'artempol-options',
        'setting' => 'achievements-page',
		'type'    => 'dropdown-pages',
    ));  
    // Services page
    $wp_customize->add_setting( 'services-page', array(
        'default' => '', 
    ));
    $wp_customize->add_control ( 'services-page', array(
        'label'   => __( 'Services page', 'artempol' ),
        'section' => 'artempol-options',
        'setting' => 'services-page',
		'type'    => 'dropdown-pages',
    ));  
    // Number of news on Main page
    $wp_customize->add_setting( 'news-main-number', array(
        'default' => '2', 
    )); 
    $wp_customize->add_control ( 'news-main-number', array(
        'label'   => __( 'Number of news on Main page', 'artempol' ),
        'section' => 'artempol-options',
        'setting' => 'news-main-number',
		'type'    => 'select',
		'choices' => array(
			'1' => 1,
			'2'	=> 2,
			'3' => 3,
			'4' => 4,
			'5' => 5,
			'6' => 6,
			'7' => 7,
			'8' => 8,
			'9' => 9,
			'10'=> 10,
		),
    ));
   
}
add_action( 'customize_register', 'artempol_customize_register' ); 

?>
