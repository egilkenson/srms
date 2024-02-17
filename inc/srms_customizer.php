<?php
/**
 * Customizer Options
 */

function srms_customizer($wp_customize)
{
    // Contact Info Options
    $wp_customize->add_section(
        'srms_contact_info',
        array(
            'title' => 'Contact Info',
            'description' => 'Display address and phone number in footer.',
            'priority' => 35,
        )
    );

    $wp_customize->add_setting(
        'srms_address',
        array(
            'default' => "",
        )
    );

    $wp_customize->add_control(
        'srms_address',
        array(
            'type' => 'textarea',
            'label' => 'Address:',
            'section' => 'srms_contact_info',
        )
    );

    $wp_customize->add_setting(
        'srms_phone',
        array(
            'default' => "",
        )
    );

    $wp_customize->add_control(
        'srms_phone',
        array(
            'type' => 'tel',
            'label' => 'Phone Number:',
            'section' => 'srms_contact_info',
        )
    );

    $wp_customize->add_setting(
        'srms_facebook',
        array(
            'default' => "",
        )
    );

    $wp_customize->add_control(
        'srms_facebook',
        array(
            'type' => 'url',
            'label' => 'Facebook Page:',
            'section' => 'srms_contact_info',
        )
    );

    // Footer Logo
    $wp_customize->add_section(
        'srms_footer_logo',
        array(
            'title' => 'Footer Logo',
            'description' => 'Display an image in footer.',
            'priority' => 35,
        )
    );

    $wp_customize->add_setting(
        'srms_logo',
        array(
            'default' => "",
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'logo',
            array(
                'label'      => __( 'Upload a logo', 'srms' ),
                'section'    => 'srms_footer_logo',
                'settings'   => 'srms_logo',
                'context'    => 'srms-logo'
            )
        )
    );

    $wp_customize->remove_section('widgets');
	$wp_customize->remove_section('static_front_page');
	$wp_customize->remove_section('additional_css');

}

add_action('customize_register', 'srms_customizer');