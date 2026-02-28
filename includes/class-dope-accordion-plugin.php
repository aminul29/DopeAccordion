<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

final class Dope_Accordion_Plugin {
    const MINIMUM_ELEMENTOR_VERSION = '3.20.0';
    const MINIMUM_PHP_VERSION       = '7.4';

    private static $instance = null;

    public static function instance(): self {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        add_action( 'plugins_loaded', array( $this, 'init' ) );
    }

    public function init(): void {
        if ( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', array( $this, 'admin_notice_missing_elementor' ) );
            return;
        }

        if ( version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '<' ) ) {
            add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
            return;
        }

        if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
            add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
            return;
        }

        add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
        add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'register_assets' ) );
        add_filter( 'attachment_fields_to_edit', array( $this, 'add_media_link_field' ), 10, 2 );
        add_filter( 'attachment_fields_to_save', array( $this, 'save_media_link_field' ), 10, 2 );
    }

    public function register_assets(): void {
        wp_register_style(
            'dope-accordion-widget',
            DOPE_ACCORDION_URL . 'assets/css/dope-accordion.css',
            array(),
            DOPE_ACCORDION_VERSION
        );

        wp_register_script(
            'dope-accordion-widget',
            DOPE_ACCORDION_URL . 'assets/js/dope-accordion.js',
            array(),
            DOPE_ACCORDION_VERSION,
            true
        );
    }

    public function register_widgets( $widgets_manager ): void {
        require_once DOPE_ACCORDION_PATH . '/includes/widgets/class-dope-accordion-widget.php';
        $widgets_manager->register( new Dope_Accordion_Widget() );
    }

    public function add_media_link_field( array $form_fields, WP_Post $post ): array {
        $media_link = get_post_meta( $post->ID, '_da_media_link', true );

        $form_fields['da_media_link'] = array(
            'label' => esc_html__( 'Accordion Image Link', 'dope-accordion' ),
            'input' => 'text',
            'value' => is_string( $media_link ) ? $media_link : '',
            'helps' => esc_html__( 'Used by Dope Accordion gallery cards for per-image linking.', 'dope-accordion' ),
        );

        return $form_fields;
    }

    public function save_media_link_field( array $post, array $attachment ): array {
        if ( isset( $attachment['da_media_link'] ) ) {
            $media_link = esc_url_raw( trim( (string) $attachment['da_media_link'] ) );

            if ( ! empty( $media_link ) ) {
                update_post_meta( $post['ID'], '_da_media_link', $media_link );
            } else {
                delete_post_meta( $post['ID'], '_da_media_link' );
            }
        }

        return $post;
    }

    public function admin_notice_missing_elementor(): void {
        if ( ! current_user_can( 'activate_plugins' ) ) {
            return;
        }

        echo '<div class="notice notice-warning is-dismissible"><p>';
        echo esc_html__( 'Dope Accordion requires Elementor to be installed and activated.', 'dope-accordion' );
        echo '</p></div>';
    }

    public function admin_notice_minimum_elementor_version(): void {
        if ( ! current_user_can( 'activate_plugins' ) ) {
            return;
        }

        printf(
            '<div class="notice notice-warning is-dismissible"><p>%s</p></div>',
            esc_html(
                sprintf(
                    /* translators: 1: required Elementor version. */
                    __( 'Dope Accordion requires Elementor version %1$s or greater.', 'dope-accordion' ),
                    self::MINIMUM_ELEMENTOR_VERSION
                )
            )
        );
    }

    public function admin_notice_minimum_php_version(): void {
        if ( ! current_user_can( 'activate_plugins' ) ) {
            return;
        }

        printf(
            '<div class="notice notice-warning is-dismissible"><p>%s</p></div>',
            esc_html(
                sprintf(
                    /* translators: 1: required PHP version. */
                    __( 'Dope Accordion requires PHP version %1$s or greater.', 'dope-accordion' ),
                    self::MINIMUM_PHP_VERSION
                )
            )
        );
    }
}
