<?php

global $wpsf_settings;

// General Settings section
$wpsf_settings[] = array(
    'section_id' => 'bbpl_general',
    'section_title' => __('General Settings','bbpl'),
    'section_description' => __('Here you can adjust the plugin settings.','bbpl'),
    'section_order' => 5,
    'fields' => array(
        array(
            'id' => 'autoembed',
            'title' => __('Automatically embed button','bbpl'),
            'desc' => __('The plugin will try to automatically embed the Like Button. You can manually embed the button calling <strong>bbp_like_button()</strong> function inside the reply loop.','bbpl'),
            'type' => 'checkbox',
            'std' => 1
        ),
        array(
            'id' => 'show_number',
            'title' => __('Show number of likes','bbpl'),
            'desc' => __('Show the number of likes next to the button','bbpl'),
            'type' => 'checkbox',
            'std' => 0
        ),
        array(
            'id' => 'show_tooltip',
            'title' => __('Show tooltip','bbpl'),
            'desc' => __('Show tooltip, with people who liked, on shortcode lists output.','bbpl'),
            'type' => 'checkbox',
            'std' => 1
        ),
    )
);
?>