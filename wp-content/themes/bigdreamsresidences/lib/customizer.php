<?php

namespace Roots\Sage\Customizer;

use Roots\Sage\Assets;

/**
 * Add postMessage support
 */
function customize_register($wp_customize) {
  $wp_customize->get_setting('blogname')->transport = 'postMessage';
}
add_action('customize_register', __NAMESPACE__ . '\\customize_register');

/**
 * Customizer JS
 */
function customize_preview_js() {
  wp_enqueue_script('sage/customizer', Assets\asset_path('scripts/customizer.js'), ['customize-preview'], null, true);
}
add_action('customize_preview_init', __NAMESPACE__ . '\\customize_preview_js');

function bdr_customize_register($wp_customize) {
	//adding section in wordpress customizer 

	$settings = array(
		array(
			'panel' => 'bdr_header_options',
			'panel_title' => __('Header', BDR_TEXT_DOMAIN),
			'description' => __('Change the Header Settings from here as you want', BDR_TEXT_DOMAIN),
			'sections' => 
				array(
					array(
						'section' => 'bdr_header_section',
						'title' => 'Logo',
						'options' => array(
							array(
								'slug' => 'bdr_logo',
								'default' => '',
								'label' => __('Upload logo for your header', BDR_TEXT_DOMAIN),
								'sanitize_callback' => 'esc_url_raw',
								'type' => 'image'
							),
							array(
								'slug' => 'bdr_mobile_logo',
								'default' => '',
								'label' => __('Upload mobile logo for your header', BDR_TEXT_DOMAIN),
								'sanitize_callback' => 'esc_url_raw',
								'type' => 'image'
							)
						)
					),
					array(
						'section' => 'bdr_header_backgroun_section',
						'title' => 'Banner',
						'options' => array(
							array(
								'slug' => 'bdr_banner_background',
								'default' => '',
								'label' => __('Upload banner for your header', BDR_TEXT_DOMAIN),
								'sanitize_callback' => 'esc_url_raw',
								'type' => 'image'
							)
						)
					)
				
			)
		),
		array(
			'panel' => 'bdr_footer_options',
			'panel_title' => __('Footer', BDR_TEXT_DOMAIN),
			'description' => __('Change the Footer Settings from here as you want', BDR_TEXT_DOMAIN),
			'sections' => array(
				array(
					'section' => 'bdr_footer_section',
					'title' => __('Copyright & History Section' , BDR_TEXT_DOMAIN),
					'options' => array(
						array(
							'slug' => 'bdr_copyright',
							'default' => '© 2015 All Rights Reserved. Bigdreamsresidences',
							'type' => 'text',
							'label' => __('Copyright Text', BDR_TEXT_DOMAIN),
						),
						array(
							'slug' => 'bdr_history',
							'default' => '',
							'type' => 'textarea',
							'label' => __('History', BDR_TEXT_DOMAIN),
						),
					)
				),
				array(
					'section' => 'bdr_social_media_section',
					'title' => 'Social Media',
					'options' => array(
						array(
							'slug' => 'bdr_social_media_facebook',
							'default' => '',
							'type' => 'text',
							'label' => __('Facebook', BDR_TEXT_DOMAIN),
						),
						array(
							'slug' => 'bdr_social_media_twitter',
							'default' => '',
							'type' => 'text',
							'label' => __('Twitter', BDR_TEXT_DOMAIN),
						),
						array(
							'slug' => 'bdr_social_media_google_plus',
							'default' => '',
							'type' => 'text',
							'label' => __('Google +', BDR_TEXT_DOMAIN),
						),
						array(
							'slug' => 'bdr_social_media_pinterest',
							'default' => '',
							'type' => 'text',
							'label' => __('Pinterest', BDR_TEXT_DOMAIN),
						)
					) 
				),
				array(
					'section' => 'bdr_contact_us_section',
					'title' => 'Contact Us',
					'options' => array(
						array(
							'slug' => 'bdr_contact_us_text',
							'default' => '',
							'type' => 'textarea',
							'label' => __('Contact Us Text', BDR_TEXT_DOMAIN),
						),
						array(
							'slug' => 'bdr_contact_us_address',
							'default' => '',
							'type' => 'text',
							'label' => __('Address', BDR_TEXT_DOMAIN),
						),
						array(
							'slug' => 'bdr_contact_us_phone',
							'default' => '',
							'type' => 'text',
							'label' => __('Phone', BDR_TEXT_DOMAIN),
						),
						array(
							'slug' => 'bdr_contact_us_toll_free',
							'default' => '',
							'type' => 'text',
							'label' => __('Toll Free', BDR_TEXT_DOMAIN),
						),
						array(
							'slug' => 'bdr_contact_us_fax',
							'default' => '',
							'type' => 'text',
							'label' => __('Fax', BDR_TEXT_DOMAIN),
						),
						array(
							'slug' => 'bdr_contact_us_email',
							'default' => '',
							'type' => 'text',
							'label' => __('Email', BDR_TEXT_DOMAIN),
						),
					) 
				),
			)
		)
	);

	foreach ($settings as $panel)  {

		$wp_customize->add_panel($panel['panel'], array(
	      	'capabitity' => 'edit_theme_options',
	      	'description' => $panel['description'],
	      	'title' => $panel['panel_title']
	   	));


	   	foreach ($panel['sections'] as $section) {

			$wp_customize->add_section($section['section'], array( 
				'title' => $section['title'], 
				'panel' => $panel['panel']
				) 
			);

			foreach ($section['options'] as $option) {
				$wp_customize->add_setting($option['slug'], array(
					'default' => $option['default'],
					'capability' => 'edit_theme_options',
				));

				if ($option['type'] == 'image') {
					$wp_customize->add_control(new \WP_Customize_Image_Control($wp_customize, $option['slug'], array(
						'label' => $option['label'],
						'section' => $section['section'],
						'setting' => $option['slug']
					)));
				} else {
					$wp_customize->add_control($option['slug'], array(
						'type' => $option['type'],
						'label' => $option['label'],
						'section' => $section['section'],
						'settings' => $option['slug']
						)
					);
				}
			}
		}
	}
}

add_action('customize_register', __NAMESPACE__ . '\\bdr_customize_register');
