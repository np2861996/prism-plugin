<?php 
//add_action( 'woocommerce_before_shop_loop', 'cpt_display_qproduct_table', 5 );

function cpt_diqsplay_product_table() {
    if ( is_product_category() ) {
        global $wp_query;
        $category = $wp_query->get_queried_object();
        $category_id = $category->term_id;
        $products = new WP_Query( array(
            'post_type' => 'product',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id',
                    'terms' => $category_id,
                    'include_children' => false,
                )
            )
        ) );
        
        if ( $products->have_posts() ) {
            $attribute_names = array( 'sku', 'regular_price', 'sale_price', 'weight' );
            $headers = array( 'Product', 'Image' );
            foreach ( $attribute_names as $name ) {
                $headers[] = ucfirst( str_replace( '_', ' ', $name ) );
            }
            echo '<table class="product-table">';
            echo '<thead><tr>';
            foreach ( $headers as $header ) {
                echo '<th>' . $header . '</th>';
            }
            echo '</tr></thead>';
            echo '<tbody>';
            while ( $products->have_posts() ) {
                $products->the_post();
                global $product;
                
                echo '<tr>';
                // Display the product name and image
                echo '<td>';
                echo '<a href="' . esc_url( get_permalink() ) . '">' . get_the_title() . '</a>';
                echo '</td>';
                echo '<td>';
                echo get_the_post_thumbnail( $product->get_id(), 'thumbnail' );
                echo '</td>';
                
                // Display the product attributes
                foreach ( $attribute_names as $name ) {
                    echo '<td>';
                    switch ( $name ) {
                        case 'sku':
                            echo $product->get_sku();
                            break;
                        case 'regular_price':
                            echo $product->get_regular_price();
                            break;
                        case 'sale_price':
                            echo $product->get_sale_price();
                            break;
                        case 'weight':
                            echo $product->get_weight() . ' ' . get_option( 'woocommerce_weight_unit' );
                            break;
                        default:
                            echo '-';
                            break;
                    }
                    echo '</td>';
                }
                echo '</tr>';
            }
            echo '</tbody></table>';
            
            // Reset the query
            wp_reset_query();
        }
    }
}
