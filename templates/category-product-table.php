<?php 

 get_header(); 

  if ( have_posts() ) : ?>

    <header class="woocommerce-products-header">
        <h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
    </header>

<?php endif; 
 
cpt_display_product_table();

function cpt_display_product_table() {
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
                echo '<a class="image-popup" href="'.get_the_post_thumbnail_url( $product->get_id(), 'thumbnail' ).'" title="9.jpg">
                <img width="150" height="150" src="'.get_the_post_thumbnail_url( $product->get_id(), 'thumbnail' ).'" class="attachment-thumbnail size-thumbnail wp-post-image" alt="" decoding="async" loading="lazy" > </a>';
                echo '</td>';
                
                // Display the product attributes
                foreach ( $attribute_names as $name ) {
                    echo '<td>';
                    switch ( $name ) {
                        case 'sku':
                            echo !empty($product->get_sku()) ? $product->get_sku() : '-';
                            break;
                        case 'regular_price':
                            echo !empty($product->get_regular_price()) ? $product->get_regular_price() : '-';;
                            break;
                        case 'sale_price':
                            echo !empty($product->get_sale_price()) ? $product->get_sale_price() : '-';
                            break;
                        case 'weight':
                            echo !empty($product->get_weight()) ? $product->get_weight() . ' ' . get_option( 'woocommerce_weight_unit' ) : '-'; ;
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
?>


<?php get_footer(); ?>
