<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 41.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $woocommerce;
?>

<?php do_action( 'woocommerce_before_mini_cart' ); ?>
<div class="cart-toggler">
	<span class="cart-quantity">
		<?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'james'), $woocommerce->cart->cart_contents_count);?>
	</span>
</div>
<div class="mini_cart_content">
	<div class="mini_cart_inner">
		<div class="mini_cart_arrow"></div>
		<?php if ( ! WC()->cart->is_empty() ) : ?>
			<ul class="cart_list product_list_widget <?php echo esc_attr($args['list_class']); ?>">
				<?php
				foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
					$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
					$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

					if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

						$product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
						$thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
						$product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );

						?>
						<li id="mcitem-<?php echo esc_attr($cart_item_key); ?>">
							<a class="product-image" href="<?php echo get_permalink( $product_id ); ?>">
								<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ); ?>
								<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s', $cart_item['quantity'] ) . '</span>', $cart_item, $cart_item_key ); ?>
							</a>
							<div class="product-details">
								<?php echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" onclick="roadMiniCartRemove(\'%s\', \'%s\');return false;" class="remove" title="%s"><i class="fa fa-times-circle"></i></a>', esc_url( wc_get_cart_remove_url( $cart_item_key ) ), esc_url( wc_get_cart_remove_url( $cart_item_key ) ), $cart_item_key, esc_html__( 'Remove this item', 'james' ) ), $cart_item_key ); ?>
								<a class="product-name" href="<?php echo esc_url(get_permalink( $product_id )); ?>"><?php echo esc_html($product_name); ?></a>
								<?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>
								<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s', $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>
							</div>
						</li>
						<?php
					}
				}
				?>
			</ul><!-- end product list -->
		<?php else: ?>
			<ul class="cart_empty <?php echo esc_attr($args['list_class']); ?>">
				<li><?php esc_html_e( 'You have no items in your shopping cart', 'james' ); ?></li>
				<li class="total"><?php esc_html_e( 'Subtotal', 'james' ); ?>: <?php echo WC()->cart->get_cart_subtotal(); ?></li>
			</ul>
		<?php endif; ?>

		<?php if ( ! WC()->cart->is_empty() ) : ?>

			<p class="total"><?php esc_html_e( 'Subtotal', 'james' ); ?>: <?php echo WC()->cart->get_cart_subtotal(); ?></p>

			<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

			<p class="buttons">
				<a href="<?php echo wc_get_cart_url(); ?>" class="button wc-forward"><?php esc_html_e( 'View Cart', 'james' ); ?></a>
				<a href="<?php echo wc_get_checkout_url(); ?>" class="button checkout wc-forward"><?php esc_html_e( 'Checkout', 'james' ); ?></a>
			</p>

		<?php endif; ?>
	</div>
	<div class="loading"></div>
</div>
<?php do_action( 'woocommerce_after_mini_cart' ); ?>