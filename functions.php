<?php
/**
 * 3 to 5 Theme Functions
 *
 * @package 3to5
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Define theme constants
 */
define( 'THREE_TO_FIVE_VERSION', '1.0.0' );
define( 'THREE_TO_FIVE_DIR', get_template_directory() );
define( 'THREE_TO_FIVE_URI', get_template_directory_uri() );

/**
 * Custom Customizer Control: TinyMCE WYSIWYG Editor
 */
if ( class_exists( 'WP_Customize_Control' ) ) {

    /**
     * Custom Control: FAQ Repeater
     */
    class Three_To_Five_FAQ_Repeater_Control extends WP_Customize_Control {
        /**
         * Control type
         *
         * @var string
         */
        public $type = 'faq_repeater';

        /**
         * Enqueue scripts and styles
         */
        public function enqueue() {
            wp_enqueue_script(
                '3to5-customizer-faq',
                THREE_TO_FIVE_URI . '/assets/js/customizer-faq.js',
                array( 'jquery', 'customize-controls', 'jquery-ui-sortable' ),
                THREE_TO_FIVE_VERSION,
                true
            );
            wp_enqueue_style(
                '3to5-customizer-faq',
                THREE_TO_FIVE_URI . '/assets/css/customizer-faq.css',
                array(),
                THREE_TO_FIVE_VERSION
            );
        }

        /**
         * Render the control content
         */
        public function render_content() {
            $faqs = $this->value();
            if ( ! is_array( $faqs ) ) {
                $faqs = json_decode( $faqs, true );
            }
            if ( ! is_array( $faqs ) ) {
                $faqs = array();
            }
            ?>
            <div class="faq-repeater-control">
                <?php if ( ! empty( $this->label ) ) : ?>
                    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <?php endif; ?>
                <?php if ( ! empty( $this->description ) ) : ?>
                    <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
                <?php endif; ?>

                <input type="hidden" class="faq-repeater-value" <?php $this->link(); ?> value="<?php echo esc_attr( wp_json_encode( $faqs ) ); ?>">

                <div class="faq-repeater-items" data-setting-id="<?php echo esc_attr( $this->id ); ?>">
                    <?php foreach ( $faqs as $index => $faq ) : ?>
                        <div class="faq-repeater-item" data-index="<?php echo esc_attr( $index ); ?>">
                            <div class="faq-repeater-item-header">
                                <span class="faq-repeater-item-title"><?php echo esc_html( ! empty( $faq['question'] ) ? $faq['question'] : __( 'New FAQ', '3to5' ) ); ?></span>
                                <button type="button" class="faq-repeater-toggle" aria-expanded="false">
                                    <span class="screen-reader-text"><?php esc_html_e( 'Toggle', '3to5' ); ?></span>
                                    <span class="dashicons dashicons-arrow-down-alt2"></span>
                                </button>
                            </div>
                            <div class="faq-repeater-item-content" style="display: none;">
                                <p>
                                    <label><?php esc_html_e( 'Question', '3to5' ); ?></label>
                                    <input type="text" class="faq-question widefat" value="<?php echo esc_attr( $faq['question'] ?? '' ); ?>">
                                </p>
                                <p>
                                    <label><?php esc_html_e( 'Answer', '3to5' ); ?></label>
                                    <textarea class="faq-answer widefat" rows="4"><?php echo esc_textarea( $faq['answer'] ?? '' ); ?></textarea>
                                </p>
                                <p class="faq-repeater-item-actions">
                                    <button type="button" class="button faq-repeater-remove"><?php esc_html_e( 'Remove', '3to5' ); ?></button>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <button type="button" class="button faq-repeater-add"><?php esc_html_e( 'Add FAQ', '3to5' ); ?></button>
            </div>
            <?php
        }
    }

    class Three_To_Five_WYSIWYG_Control extends WP_Customize_Control {
        /**
         * Control type
         *
         * @var string
         */
        public $type = 'wysiwyg';

        /**
         * Enqueue scripts and styles
         */
        public function enqueue() {
            wp_enqueue_editor();
            wp_enqueue_script(
                '3to5-customizer-wysiwyg',
                THREE_TO_FIVE_URI . '/assets/js/customizer-wysiwyg.js',
                array( 'jquery', 'customize-controls' ),
                THREE_TO_FIVE_VERSION,
                true
            );
            wp_enqueue_style(
                '3to5-customizer-wysiwyg',
                THREE_TO_FIVE_URI . '/assets/css/customizer-wysiwyg.css',
                array(),
                THREE_TO_FIVE_VERSION
            );
        }

        /**
         * Render the control content
         */
        public function render_content() {
            ?>
            <label>
                <?php if ( ! empty( $this->label ) ) : ?>
                    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <?php endif; ?>
                <?php if ( ! empty( $this->description ) ) : ?>
                    <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
                <?php endif; ?>
                <div class="wysiwyg-editor-control">
                    <textarea
                        id="<?php echo esc_attr( $this->id ); ?>"
                        class="wysiwyg-editor"
                        <?php $this->link(); ?>
                    ><?php echo esc_textarea( $this->value() ); ?></textarea>
                </div>
            </label>
            <?php
        }
    }
}

/**
 * Theme setup
 */
function three_to_five_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails
    add_theme_support( 'post-thumbnails' );

    // Custom logo support
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    // Custom background support
    add_theme_support( 'custom-background', array(
        'default-color' => 'ffffff',
    ) );

    // HTML5 support
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Register navigation menus
    register_nav_menus( array(
        'primary' => esc_html__( 'Primary Menu', '3to5' ),
        'footer'  => esc_html__( 'Footer Menu', '3to5' ),
    ) );
}
add_action( 'after_setup_theme', 'three_to_five_setup' );

/**
 * Enqueue scripts and styles
 */
function three_to_five_scripts() {
    // Main stylesheet
    wp_enqueue_style(
        '3to5-style',
        get_stylesheet_uri(),
        array(),
        THREE_TO_FIVE_VERSION
    );

    // Theme JavaScript
    wp_enqueue_script(
        '3to5-script',
        THREE_TO_FIVE_URI . '/assets/js/main.js',
        array(),
        THREE_TO_FIVE_VERSION,
        true
    );

    // Pass customizer settings to JavaScript
    wp_localize_script( '3to5-script', 'threeToFive', array(
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( '3to5-nonce' ),
    ) );
}
add_action( 'wp_enqueue_scripts', 'three_to_five_scripts' );

/**
 * Customizer Settings
 */
function three_to_five_customize_register( $wp_customize ) {

    // =========================================================================
    // Panel: Campaign Settings
    // =========================================================================
    $wp_customize->add_panel( '3to5_campaign', array(
        'title'       => __( 'Campaign Settings', '3to5' ),
        'description' => __( 'Customize your campaign page content.', '3to5' ),
        'priority'    => 30,
    ) );

    // =========================================================================
    // Section: Hero
    // =========================================================================
    $wp_customize->add_section( '3to5_hero', array(
        'title'    => __( 'Hero Section', '3to5' ),
        'panel'    => '3to5_campaign',
        'priority' => 10,
    ) );

    // Hero Background Image
    $wp_customize->add_setting( '3to5_hero_bg', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, '3to5_hero_bg', array(
        'label'   => __( 'Background Image', '3to5' ),
        'section' => '3to5_hero',
    ) ) );

    // Hero Tagline
    $wp_customize->add_setting( '3to5_hero_tagline', array(
        'default'           => __( 'Lewis County Ballot Initiative', '3to5' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( '3to5_hero_tagline', array(
        'label'   => __( 'Tagline', '3to5' ),
        'section' => '3to5_hero',
        'type'    => 'text',
    ) );

    // Hero Title
    $wp_customize->add_setting( '3to5_hero_title', array(
        'default'           => __( 'Expand Our County Commission from 3 to 5', '3to5' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( '3to5_hero_title', array(
        'label'   => __( 'Title', '3to5' ),
        'section' => '3to5_hero',
        'type'    => 'text',
    ) );

    // Hero Subtitle
    $wp_customize->add_setting( '3to5_hero_subtitle', array(
        'default'           => __( 'More voices. Better representation. Stronger community.', '3to5' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( '3to5_hero_subtitle', array(
        'label'   => __( 'Subtitle', '3to5' ),
        'section' => '3to5_hero',
        'type'    => 'text',
    ) );

    // Hero CTA Text
    $wp_customize->add_setting( '3to5_hero_cta_text', array(
        'default'           => __( 'Sign the Petition', '3to5' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( '3to5_hero_cta_text', array(
        'label'   => __( 'Button Text', '3to5' ),
        'section' => '3to5_hero',
        'type'    => 'text',
    ) );

    // Hero CTA Link
    $wp_customize->add_setting( '3to5_hero_cta_link', array(
        'default'           => '#action',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( '3to5_hero_cta_link', array(
        'label'   => __( 'Button Link', '3to5' ),
        'section' => '3to5_hero',
        'type'    => 'url',
    ) );

    // Hero Secondary CTA Text
    $wp_customize->add_setting( '3to5_hero_cta2_text', array(
        'default'           => __( 'Learn More', '3to5' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( '3to5_hero_cta2_text', array(
        'label'   => __( 'Secondary Button Text', '3to5' ),
        'section' => '3to5_hero',
        'type'    => 'text',
    ) );

    // Hero Secondary CTA Link
    $wp_customize->add_setting( '3to5_hero_cta2_link', array(
        'default'           => '#about',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( '3to5_hero_cta2_link', array(
        'label'   => __( 'Secondary Button Link', '3to5' ),
        'section' => '3to5_hero',
        'type'    => 'url',
    ) );

    // Hero Video Enable
    $wp_customize->add_setting( '3to5_hero_video_enable', array(
        'default'           => false,
        'sanitize_callback' => 'three_to_five_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( '3to5_hero_video_enable', array(
        'label'       => __( 'Show Video in Hero', '3to5' ),
        'description' => __( 'Display an embedded video below the hero text.', '3to5' ),
        'section'     => '3to5_hero',
        'type'        => 'checkbox',
    ) );

    // Hero Video Type
    $wp_customize->add_setting( '3to5_hero_video_type', array(
        'default'           => 'youtube',
        'sanitize_callback' => 'three_to_five_sanitize_video_type',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( '3to5_hero_video_type', array(
        'label'   => __( 'Video Type', '3to5' ),
        'section' => '3to5_hero',
        'type'    => 'select',
        'choices' => array(
            'youtube' => __( 'YouTube', '3to5' ),
            'vimeo'   => __( 'Vimeo', '3to5' ),
            'self'    => __( 'Self-hosted (MP4)', '3to5' ),
        ),
    ) );

    // Hero Video URL/ID
    $wp_customize->add_setting( '3to5_hero_video_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( '3to5_hero_video_url', array(
        'label'       => __( 'Video URL', '3to5' ),
        'description' => __( 'For YouTube/Vimeo: paste the full video URL. For self-hosted: enter the MP4 file URL.', '3to5' ),
        'section'     => '3to5_hero',
        'type'        => 'url',
    ) );

    // Hero Video Poster (for self-hosted)
    $wp_customize->add_setting( '3to5_hero_video_poster', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, '3to5_hero_video_poster', array(
        'label'       => __( 'Video Poster Image', '3to5' ),
        'description' => __( 'Thumbnail shown before video plays (for self-hosted videos).', '3to5' ),
        'section'     => '3to5_hero',
    ) ) );

    // =========================================================================
    // Section: About
    // =========================================================================
    $wp_customize->add_section( '3to5_about', array(
        'title'    => __( 'About Section', '3to5' ),
        'panel'    => '3to5_campaign',
        'priority' => 20,
    ) );

    // About Enable
    $wp_customize->add_setting( '3to5_about_enable', array(
        'default'           => true,
        'sanitize_callback' => 'three_to_five_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( '3to5_about_enable', array(
        'label'   => __( 'Enable About Section', '3to5' ),
        'section' => '3to5_about',
        'type'    => 'checkbox',
    ) );

    // About Title
    $wp_customize->add_setting( '3to5_about_title', array(
        'default'           => __( 'Why Expand to 5 Commissioners?', '3to5' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( '3to5_about_title', array(
        'label'   => __( 'Title', '3to5' ),
        'section' => '3to5_about',
        'type'    => 'text',
    ) );

    // About Content (WYSIWYG Editor)
    $wp_customize->add_setting( '3to5_about_content', array(
        'default'           => __( 'Lewis County has grown significantly over the years, but our County Commission has remained at just three members. By expanding to five commissioners, we can ensure better representation for all residents, bring more diverse perspectives to local government, and improve transparency in decision-making.', '3to5' ),
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( new Three_To_Five_WYSIWYG_Control( $wp_customize, '3to5_about_content', array(
        'label'   => __( 'Content', '3to5' ),
        'section' => '3to5_about',
    ) ) );

    // About Image
    $wp_customize->add_setting( '3to5_about_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, '3to5_about_image', array(
        'label'   => __( 'About Image', '3to5' ),
        'section' => '3to5_about',
    ) ) );

    // =========================================================================
    // Section: Reasons/Benefits
    // =========================================================================
    $wp_customize->add_section( '3to5_reasons', array(
        'title'    => __( 'Reasons Section', '3to5' ),
        'panel'    => '3to5_campaign',
        'priority' => 30,
    ) );

    // Reasons Enable
    $wp_customize->add_setting( '3to5_reasons_enable', array(
        'default'           => true,
        'sanitize_callback' => 'three_to_five_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( '3to5_reasons_enable', array(
        'label'   => __( 'Enable Reasons Section', '3to5' ),
        'section' => '3to5_reasons',
        'type'    => 'checkbox',
    ) );

    // Reasons Section Title
    $wp_customize->add_setting( '3to5_reasons_title', array(
        'default'           => __( 'Key Benefits', '3to5' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( '3to5_reasons_title', array(
        'label'   => __( 'Section Title', '3to5' ),
        'section' => '3to5_reasons',
        'type'    => 'text',
    ) );

    // Reasons (up to 4)
    for ( $i = 1; $i <= 4; $i++ ) {
        $wp_customize->add_setting( "3to5_reason_{$i}_title", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ) );
        $wp_customize->add_control( "3to5_reason_{$i}_title", array(
            'label'   => sprintf( __( 'Reason %d Title', '3to5' ), $i ),
            'section' => '3to5_reasons',
            'type'    => 'text',
        ) );

        $wp_customize->add_setting( "3to5_reason_{$i}_text", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport'         => 'postMessage',
        ) );
        $wp_customize->add_control( "3to5_reason_{$i}_text", array(
            'label'   => sprintf( __( 'Reason %d Description', '3to5' ), $i ),
            'section' => '3to5_reasons',
            'type'    => 'textarea',
        ) );

        $wp_customize->add_setting( "3to5_reason_{$i}_icon", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ) );
        $wp_customize->add_control( "3to5_reason_{$i}_icon", array(
            'label'       => sprintf( __( 'Reason %d Icon (emoji or text)', '3to5' ), $i ),
            'section'     => '3to5_reasons',
            'type'        => 'text',
            'description' => __( 'Enter an emoji or short text like "1" or "✓"', '3to5' ),
        ) );
    }

    // Set default reasons
    $wp_customize->get_setting( '3to5_reason_1_title' )->default = __( 'Better Representation', '3to5' );
    $wp_customize->get_setting( '3to5_reason_1_text' )->default = __( 'Five commissioners means more neighborhoods and communities have a voice at the table.', '3to5' );
    $wp_customize->get_setting( '3to5_reason_1_icon' )->default = '👥';

    $wp_customize->get_setting( '3to5_reason_2_title' )->default = __( 'Diverse Perspectives', '3to5' );
    $wp_customize->get_setting( '3to5_reason_2_text' )->default = __( 'More commissioners bring varied backgrounds, experiences, and viewpoints to important decisions.', '3to5' );
    $wp_customize->get_setting( '3to5_reason_2_icon' )->default = '🌟';

    $wp_customize->get_setting( '3to5_reason_3_title' )->default = __( 'Increased Accountability', '3to5' );
    $wp_customize->get_setting( '3to5_reason_3_text' )->default = __( 'With more eyes on every decision, there is greater transparency and accountability in local government.', '3to5' );
    $wp_customize->get_setting( '3to5_reason_3_icon' )->default = '✅';

    $wp_customize->get_setting( '3to5_reason_4_title' )->default = __( 'Stronger Community', '3to5' );
    $wp_customize->get_setting( '3to5_reason_4_text' )->default = __( 'Better governance leads to better outcomes for roads, services, and quality of life for all residents.', '3to5' );
    $wp_customize->get_setting( '3to5_reason_4_icon' )->default = '🏘️';

    // =========================================================================
    // Section: Take Action
    // =========================================================================
    $wp_customize->add_section( '3to5_action', array(
        'title'    => __( 'Take Action Section', '3to5' ),
        'panel'    => '3to5_campaign',
        'priority' => 40,
    ) );

    // Action Enable
    $wp_customize->add_setting( '3to5_action_enable', array(
        'default'           => true,
        'sanitize_callback' => 'three_to_five_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( '3to5_action_enable', array(
        'label'   => __( 'Enable Action Section', '3to5' ),
        'section' => '3to5_action',
        'type'    => 'checkbox',
    ) );

    // Action Background Image
    $wp_customize->add_setting( '3to5_action_bg', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, '3to5_action_bg', array(
        'label'   => __( 'Background Image', '3to5' ),
        'section' => '3to5_action',
    ) ) );

    // Action Title
    $wp_customize->add_setting( '3to5_action_title', array(
        'default'           => __( 'How to Sign the Petition', '3to5' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( '3to5_action_title', array(
        'label'   => __( 'Section Title', '3to5' ),
        'section' => '3to5_action',
        'type'    => 'text',
    ) );

    // Action Subtitle
    $wp_customize->add_setting( '3to5_action_subtitle', array(
        'default'           => __( 'Your signature matters! Here is how you can help put this measure on the ballot.', '3to5' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( '3to5_action_subtitle', array(
        'label'   => __( 'Subtitle', '3to5' ),
        'section' => '3to5_action',
        'type'    => 'text',
    ) );

    // Action Steps (up to 3)
    for ( $i = 1; $i <= 3; $i++ ) {
        $wp_customize->add_setting( "3to5_step_{$i}_title", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ) );
        $wp_customize->add_control( "3to5_step_{$i}_title", array(
            'label'   => sprintf( __( 'Step %d Title', '3to5' ), $i ),
            'section' => '3to5_action',
            'type'    => 'text',
        ) );

        $wp_customize->add_setting( "3to5_step_{$i}_text", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport'         => 'postMessage',
        ) );
        $wp_customize->add_control( "3to5_step_{$i}_text", array(
            'label'   => sprintf( __( 'Step %d Description', '3to5' ), $i ),
            'section' => '3to5_action',
            'type'    => 'textarea',
        ) );

        $wp_customize->add_setting( "3to5_step_{$i}_btn_text", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ) );
        $wp_customize->add_control( "3to5_step_{$i}_btn_text", array(
            'label'   => sprintf( __( 'Step %d Button Text', '3to5' ), $i ),
            'section' => '3to5_action',
            'type'    => 'text',
        ) );

        $wp_customize->add_setting( "3to5_step_{$i}_btn_link", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh',
        ) );
        $wp_customize->add_control( "3to5_step_{$i}_btn_link", array(
            'label'   => sprintf( __( 'Step %d Button Link', '3to5' ), $i ),
            'section' => '3to5_action',
            'type'    => 'url',
        ) );
    }

    // Set default steps
    $wp_customize->get_setting( '3to5_step_1_title' )->default = __( 'Find a Signing Location', '3to5' );
    $wp_customize->get_setting( '3to5_step_1_text' )->default = __( 'Visit one of our signing locations listed below or contact us to arrange a signature gatherer to come to you.', '3to5' );

    $wp_customize->get_setting( '3to5_step_2_title' )->default = __( 'Bring Valid ID', '3to5' );
    $wp_customize->get_setting( '3to5_step_2_text' )->default = __( 'You must be a registered voter in Lewis County. Bring a valid form of identification.', '3to5' );

    $wp_customize->get_setting( '3to5_step_3_title' )->default = __( 'Sign & Share', '3to5' );
    $wp_customize->get_setting( '3to5_step_3_text' )->default = __( 'Sign the petition and spread the word! Tell your friends, family, and neighbors about this important initiative.', '3to5' );

    // =========================================================================
    // Section: Locations
    // =========================================================================
    $wp_customize->add_section( '3to5_locations', array(
        'title'    => __( 'Signing Locations', '3to5' ),
        'panel'    => '3to5_campaign',
        'priority' => 50,
    ) );

    // Locations Enable
    $wp_customize->add_setting( '3to5_locations_enable', array(
        'default'           => true,
        'sanitize_callback' => 'three_to_five_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( '3to5_locations_enable', array(
        'label'   => __( 'Enable Locations Section', '3to5' ),
        'section' => '3to5_locations',
        'type'    => 'checkbox',
    ) );

    // Locations Title
    $wp_customize->add_setting( '3to5_locations_title', array(
        'default'           => __( 'Where to Sign', '3to5' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( '3to5_locations_title', array(
        'label'   => __( 'Section Title', '3to5' ),
        'section' => '3to5_locations',
        'type'    => 'text',
    ) );

    // Locations (up to 4)
    for ( $i = 1; $i <= 4; $i++ ) {
        $wp_customize->add_setting( "3to5_location_{$i}_name", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ) );
        $wp_customize->add_control( "3to5_location_{$i}_name", array(
            'label'   => sprintf( __( 'Location %d Name', '3to5' ), $i ),
            'section' => '3to5_locations',
            'type'    => 'text',
        ) );

        $wp_customize->add_setting( "3to5_location_{$i}_address", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ) );
        $wp_customize->add_control( "3to5_location_{$i}_address", array(
            'label'   => sprintf( __( 'Location %d Address', '3to5' ), $i ),
            'section' => '3to5_locations',
            'type'    => 'text',
        ) );

        $wp_customize->add_setting( "3to5_location_{$i}_hours", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ) );
        $wp_customize->add_control( "3to5_location_{$i}_hours", array(
            'label'   => sprintf( __( 'Location %d Hours', '3to5' ), $i ),
            'section' => '3to5_locations',
            'type'    => 'text',
        ) );
    }

    // =========================================================================
    // Section: FAQ
    // =========================================================================
    $wp_customize->add_section( '3to5_faq', array(
        'title'    => __( 'FAQ Section', '3to5' ),
        'panel'    => '3to5_campaign',
        'priority' => 60,
    ) );

    // FAQ Enable
    $wp_customize->add_setting( '3to5_faq_enable', array(
        'default'           => true,
        'sanitize_callback' => 'three_to_five_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( '3to5_faq_enable', array(
        'label'   => __( 'Enable FAQ Section', '3to5' ),
        'section' => '3to5_faq',
        'type'    => 'checkbox',
    ) );

    // FAQ Title
    $wp_customize->add_setting( '3to5_faq_title', array(
        'default'           => __( 'Frequently Asked Questions', '3to5' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( '3to5_faq_title', array(
        'label'   => __( 'Section Title', '3to5' ),
        'section' => '3to5_faq',
        'type'    => 'text',
    ) );

    // FAQs Repeater (dynamic)
    $default_faqs = array(
        array(
            'question' => __( 'How many signatures are needed?', '3to5' ),
            'answer'   => __( 'We need to collect a specific number of valid signatures from registered voters in Lewis County. Every signature counts toward getting this measure on the ballot.', '3to5' ),
        ),
        array(
            'question' => __( 'Who can sign the petition?', '3to5' ),
            'answer'   => __( 'Any registered voter who resides in Lewis County can sign the petition. You will need to provide valid identification.', '3to5' ),
        ),
        array(
            'question' => __( 'When is the deadline?', '3to5' ),
            'answer'   => __( 'We have a limited time to collect all necessary signatures. Please sign as soon as possible and encourage others to do the same.', '3to5' ),
        ),
    );

    $wp_customize->add_setting( '3to5_faq_items', array(
        'default'           => wp_json_encode( $default_faqs ),
        'sanitize_callback' => 'three_to_five_sanitize_faq_items',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new Three_To_Five_FAQ_Repeater_Control( $wp_customize, '3to5_faq_items', array(
        'label'       => __( 'FAQ Items', '3to5' ),
        'description' => __( 'Add, edit, remove, and reorder your FAQ items.', '3to5' ),
        'section'     => '3to5_faq',
    ) ) );

    // =========================================================================
    // Section: Contact
    // =========================================================================
    $wp_customize->add_section( '3to5_contact', array(
        'title'    => __( 'Contact Information', '3to5' ),
        'panel'    => '3to5_campaign',
        'priority' => 70,
    ) );

    // Contact Enable
    $wp_customize->add_setting( '3to5_contact_enable', array(
        'default'           => true,
        'sanitize_callback' => 'three_to_five_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( '3to5_contact_enable', array(
        'label'   => __( 'Enable Contact Section', '3to5' ),
        'section' => '3to5_contact',
        'type'    => 'checkbox',
    ) );

    // Contact Title
    $wp_customize->add_setting( '3to5_contact_title', array(
        'default'           => __( 'Get Involved', '3to5' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( '3to5_contact_title', array(
        'label'   => __( 'Section Title', '3to5' ),
        'section' => '3to5_contact',
        'type'    => 'text',
    ) );

    // Contact Email
    $wp_customize->add_setting( '3to5_contact_email', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_email',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( '3to5_contact_email', array(
        'label'   => __( 'Email Address', '3to5' ),
        'section' => '3to5_contact',
        'type'    => 'email',
    ) );

    // Contact Phone
    $wp_customize->add_setting( '3to5_contact_phone', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( '3to5_contact_phone', array(
        'label'   => __( 'Phone Number', '3to5' ),
        'section' => '3to5_contact',
        'type'    => 'text',
    ) );

    // Social Links
    $social_networks = array( 'facebook', 'twitter', 'instagram' );
    foreach ( $social_networks as $network ) {
        $wp_customize->add_setting( "3to5_social_{$network}", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh',
        ) );
        $wp_customize->add_control( "3to5_social_{$network}", array(
            'label'   => sprintf( __( '%s URL', '3to5' ), ucfirst( $network ) ),
            'section' => '3to5_contact',
            'type'    => 'url',
        ) );
    }

    // =========================================================================
    // Section: Colors
    // =========================================================================
    $wp_customize->add_section( '3to5_colors', array(
        'title'    => __( 'Theme Colors', '3to5' ),
        'panel'    => '3to5_campaign',
        'priority' => 80,
    ) );

    // Primary Color
    $wp_customize->add_setting( '3to5_color_primary', array(
        'default'           => '#1e3a5f',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, '3to5_color_primary', array(
        'label'   => __( 'Primary Color', '3to5' ),
        'section' => '3to5_colors',
    ) ) );

    // Secondary Color
    $wp_customize->add_setting( '3to5_color_secondary', array(
        'default'           => '#c9a227',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, '3to5_color_secondary', array(
        'label'   => __( 'Secondary/Accent Color', '3to5' ),
        'section' => '3to5_colors',
    ) ) );

    // =========================================================================
    // Section: Social Sharing
    // =========================================================================
    $wp_customize->add_section( '3to5_social_sharing', array(
        'title'       => __( 'Social Sharing', '3to5' ),
        'description' => __( 'Configure how your site appears when shared on social media.', '3to5' ),
        'panel'       => '3to5_campaign',
        'priority'    => 85,
    ) );

    // OG Title
    $wp_customize->add_setting( '3to5_og_title', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( '3to5_og_title', array(
        'label'       => __( 'Share Title', '3to5' ),
        'description' => __( 'Leave blank to use the site title.', '3to5' ),
        'section'     => '3to5_social_sharing',
        'type'        => 'text',
    ) );

    // OG Description
    $wp_customize->add_setting( '3to5_og_description', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( '3to5_og_description', array(
        'label'       => __( 'Share Description', '3to5' ),
        'description' => __( 'A brief description shown when shared. Leave blank to use the site tagline.', '3to5' ),
        'section'     => '3to5_social_sharing',
        'type'        => 'textarea',
    ) );

    // OG Image
    $wp_customize->add_setting( '3to5_og_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, '3to5_og_image', array(
        'label'       => __( 'Share Image', '3to5' ),
        'description' => __( 'Recommended size: 1200×630 pixels. This image appears when your site is shared on Facebook, LinkedIn, etc.', '3to5' ),
        'section'     => '3to5_social_sharing',
    ) ) );

    // Twitter Card Type
    $wp_customize->add_setting( '3to5_twitter_card', array(
        'default'           => 'summary_large_image',
        'sanitize_callback' => 'three_to_five_sanitize_twitter_card',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( '3to5_twitter_card', array(
        'label'   => __( 'Twitter Card Type', '3to5' ),
        'section' => '3to5_social_sharing',
        'type'    => 'select',
        'choices' => array(
            'summary'             => __( 'Summary (small image)', '3to5' ),
            'summary_large_image' => __( 'Summary with Large Image', '3to5' ),
        ),
    ) );

    // Twitter Handle
    $wp_customize->add_setting( '3to5_twitter_handle', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( '3to5_twitter_handle', array(
        'label'       => __( 'Twitter/X Handle', '3to5' ),
        'description' => __( 'Your Twitter username (without the @).', '3to5' ),
        'section'     => '3to5_social_sharing',
        'type'        => 'text',
    ) );

    // =========================================================================
    // Section: Footer
    // =========================================================================
    $wp_customize->add_section( '3to5_footer', array(
        'title'    => __( 'Footer Settings', '3to5' ),
        'panel'    => '3to5_campaign',
        'priority' => 90,
    ) );

    // Footer Text
    $wp_customize->add_setting( '3to5_footer_text', array(
        'default'           => __( 'Paid for by the 3 to 5 Campaign Committee.', '3to5' ),
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( '3to5_footer_text', array(
        'label'   => __( 'Footer Disclaimer Text', '3to5' ),
        'section' => '3to5_footer',
        'type'    => 'textarea',
    ) );
}
add_action( 'customize_register', 'three_to_five_customize_register' );

/**
 * Sanitize checkbox
 */
function three_to_five_sanitize_checkbox( $checked ) {
    return ( ( isset( $checked ) && true === $checked ) ? true : false );
}

/**
 * Sanitize video type select
 */
function three_to_five_sanitize_video_type( $input ) {
    $valid = array( 'youtube', 'vimeo', 'self' );
    return in_array( $input, $valid, true ) ? $input : 'youtube';
}

/**
 * Sanitize Twitter card type select
 */
function three_to_five_sanitize_twitter_card( $input ) {
    $valid = array( 'summary', 'summary_large_image' );
    return in_array( $input, $valid, true ) ? $input : 'summary_large_image';
}

/**
 * Sanitize FAQ items (JSON array)
 */
function three_to_five_sanitize_faq_items( $input ) {
    if ( is_string( $input ) ) {
        $input = json_decode( $input, true );
    }

    if ( ! is_array( $input ) ) {
        return '[]';
    }

    $sanitized = array();
    foreach ( $input as $item ) {
        if ( ! is_array( $item ) ) {
            continue;
        }
        $sanitized[] = array(
            'question' => isset( $item['question'] ) ? sanitize_text_field( $item['question'] ) : '',
            'answer'   => isset( $item['answer'] ) ? wp_kses_post( $item['answer'] ) : '',
        );
    }

    return wp_json_encode( $sanitized );
}

/**
 * Get FAQ items as array
 */
function three_to_five_get_faq_items() {
    $default_faqs = array(
        array(
            'question' => __( 'How many signatures are needed?', '3to5' ),
            'answer'   => __( 'We need to collect a specific number of valid signatures from registered voters in Lewis County. Every signature counts toward getting this measure on the ballot.', '3to5' ),
        ),
        array(
            'question' => __( 'Who can sign the petition?', '3to5' ),
            'answer'   => __( 'Any registered voter who resides in Lewis County can sign the petition. You will need to provide valid identification.', '3to5' ),
        ),
        array(
            'question' => __( 'When is the deadline?', '3to5' ),
            'answer'   => __( 'We have a limited time to collect all necessary signatures. Please sign as soon as possible and encourage others to do the same.', '3to5' ),
        ),
    );

    $faqs = get_theme_mod( '3to5_faq_items', wp_json_encode( $default_faqs ) );

    if ( is_string( $faqs ) ) {
        $faqs = json_decode( $faqs, true );
    }

    if ( ! is_array( $faqs ) ) {
        return $default_faqs;
    }

    return $faqs;
}

/**
 * Extract YouTube video ID from URL
 */
function three_to_five_get_youtube_id( $url ) {
    $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i';
    if ( preg_match( $pattern, $url, $matches ) ) {
        return $matches[1];
    }
    return '';
}

/**
 * Extract Vimeo video ID from URL
 */
function three_to_five_get_vimeo_id( $url ) {
    $pattern = '/(?:vimeo\.com\/)(\d+)/i';
    if ( preg_match( $pattern, $url, $matches ) ) {
        return $matches[1];
    }
    return '';
}

/**
 * Output custom CSS for colors
 */
function three_to_five_custom_css() {
    $primary   = get_theme_mod( '3to5_color_primary', '#1e3a5f' );
    $secondary = get_theme_mod( '3to5_color_secondary', '#c9a227' );

    $css = "
        :root {
            --color-primary: {$primary};
            --color-secondary: {$secondary};
            --color-hero-overlay: {$primary}d9;
        }
    ";

    wp_add_inline_style( '3to5-style', $css );
}
add_action( 'wp_enqueue_scripts', 'three_to_five_custom_css', 20 );

/**
 * Customizer preview script
 */
function three_to_five_customize_preview_js() {
    wp_enqueue_script(
        '3to5-customizer-preview',
        THREE_TO_FIVE_URI . '/assets/js/customizer-preview.js',
        array( 'jquery', 'customize-preview' ),
        THREE_TO_FIVE_VERSION,
        true
    );
}
add_action( 'customize_preview_init', 'three_to_five_customize_preview_js' );

/**
 * Helper function to get theme mod with default
 */
function three_to_five_get_mod( $key, $default = '' ) {
    return get_theme_mod( "3to5_{$key}", $default );
}

/**
 * Output Open Graph and Twitter Card meta tags
 */
function three_to_five_social_meta_tags() {
    // Get values with fallbacks
    $og_title = get_theme_mod( '3to5_og_title', '' );
    if ( empty( $og_title ) ) {
        $og_title = get_bloginfo( 'name' );
    }

    $og_description = get_theme_mod( '3to5_og_description', '' );
    if ( empty( $og_description ) ) {
        $og_description = get_bloginfo( 'description' );
    }

    $og_image        = get_theme_mod( '3to5_og_image', '' );
    $twitter_card    = get_theme_mod( '3to5_twitter_card', 'summary_large_image' );
    $twitter_handle  = get_theme_mod( '3to5_twitter_handle', '' );
    $site_url        = home_url( '/' );
    $site_name       = get_bloginfo( 'name' );

    // Open Graph tags
    ?>
    <!-- Open Graph Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo esc_url( $site_url ); ?>">
    <meta property="og:title" content="<?php echo esc_attr( $og_title ); ?>">
    <?php if ( $og_description ) : ?>
    <meta property="og:description" content="<?php echo esc_attr( $og_description ); ?>">
    <?php endif; ?>
    <meta property="og:site_name" content="<?php echo esc_attr( $site_name ); ?>">
    <?php if ( $og_image ) : ?>
    <meta property="og:image" content="<?php echo esc_url( $og_image ); ?>">
    <meta property="og:image:alt" content="<?php echo esc_attr( $og_title ); ?>">
    <?php
        // Try to get image dimensions
        $image_id = attachment_url_to_postid( $og_image );
        if ( $image_id ) {
            $image_meta = wp_get_attachment_image_src( $image_id, 'full' );
            if ( $image_meta ) {
                echo '<meta property="og:image:width" content="' . esc_attr( $image_meta[1] ) . '">' . "\n";
                echo '    <meta property="og:image:height" content="' . esc_attr( $image_meta[2] ) . '">' . "\n";
            }
        }
    ?>
    <?php endif; ?>

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="<?php echo esc_attr( $twitter_card ); ?>">
    <meta name="twitter:title" content="<?php echo esc_attr( $og_title ); ?>">
    <?php if ( $og_description ) : ?>
    <meta name="twitter:description" content="<?php echo esc_attr( $og_description ); ?>">
    <?php endif; ?>
    <?php if ( $og_image ) : ?>
    <meta name="twitter:image" content="<?php echo esc_url( $og_image ); ?>">
    <?php endif; ?>
    <?php if ( $twitter_handle ) : ?>
    <meta name="twitter:site" content="@<?php echo esc_attr( $twitter_handle ); ?>">
    <meta name="twitter:creator" content="@<?php echo esc_attr( $twitter_handle ); ?>">
    <?php endif; ?>
    <?php
}
add_action( 'wp_head', 'three_to_five_social_meta_tags', 5 );
