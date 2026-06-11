<?php
/**
 * Plugin Name: WooCommerce Custom AJAX Store Engine (MonexPro Layouts)
 * Description: High-performance asynchronous catalog rendering engine with native RTL support and cryptographic nonce security layers.
 * Version: 1.0.0
 * Author: So9digi
 * License: GPL2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class MonexPro_Catalog_Engine {
    
    public function __construct() {
        // Asynchronous AJAX Hooks for both logged-in and guest users
        add_action( 'wp_ajax_monexpro_filter_products', array( $this, 'handle_asynchronous_filter' ) );
        add_action( 'wp_ajax_nopriv_monexpro_filter_products', array( $this, 'handle_asynchronous_filter' ) );
        
        // Dynamic RTL/LTR layout context injector
        add_filter( 'body_class', array( $this, 'inject_direction_context_classes' ) );
    }

    /**
     * Secure and process the catalog filtering pipeline asynchronously via Fetch API
     */
    public function handle_asynchronous_filter() {
        // 1. Cryptographic Security Validation (Anti-CSRF Nonce Check)
        if ( ! isset( $_POST['security'] ) || ! wp_verify_nonce( $_POST['security'], 'monexpro_catalog_nonce' ) ) {
            wp_send_json_error( array( 'message' => 'Security token mismatch. Asynchronous query terminated.' ), 403 );
        }

        // 2. Sanitize incoming request metrics
        $category_slug = isset( $_POST['category'] ) ? sanitize_text_field( $_POST['category'] ) : '';
        
        // 3. Construct optimized, direct database query skipping heavy wrappers
        $query_args = array(
            'post_type'      => 'product',
            'posts_per_page' => 12,
            'status'         => 'publish',
            'tax_query'      => array()
        );

        if ( ! empty( $category_slug ) ) {
            $query_args['tax_query'][] = array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => $category_slug,
            );
        }

        $products_query = new WP_Query( $query_args );
        
        ob_start();

        // 4. Dynamic Template Overrides Execution Layer
        if ( $products_query->have_posts() ) {
            while ( $products_query->have_posts() ) {
                $products_query->the_post();
                // Utilizes native template overrides avoiding UI layout shifting
                if ( function_exists( 'wc_get_template_part' ) ) {
                    wc_get_template_part( 'content', 'product' );
                }
            }
            wp_reset_postdata();
        } else {
            echo '<p class="no-products-found">' . esc_html__( 'No products align with the selected criteria.', 'monexpro' ) . '</p>';
        }

        $html_output = ob_get_clean();

        // 5. Asynchronous Server Response payload delivery
        wp_send_json_success( array(
            'html_cards'  => $html_output,
            'vitals_score'=> performance_get_memory_usage()
        ) );
    }

    /**
     * Determines client presentation layout context recursively
     */
    public function inject_direction_context_classes( $classes ) {
        if ( function_exists( 'is_rtl' ) && is_rtl() ) {
            $classes[] = 'monexpro-native-rtl-layout';
            $classes[] = 'tailwind-fluid-grid-rtl';
        } else {
            $classes[] = 'monexpro-native-ltr-layout';
        }
        return $classes;
    }
}

// Initialize the enterprise core layout subsystem safely
if ( class_exists( 'MonexPro_Catalog_Engine' ) ) {
    new MonexPro_Catalog_Engine();
}
