<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>
	<!-- GET VARIATION DATA -->

	<?php

		$product_id = $product->get_id();

		// Check if the product is a variable product
		if ($product->is_type('variable')) {
			// Get the variations
			$variations = $product->get_available_variations();

			// Check if there are any variations
			if (!empty($variations)) {
				// Prepare the data array
				$data = array();

				// Get the variation object of the first variation
				$first_variation_obj = wc_get_product($variations[0]['variation_id']);

				// Get the variation attributes
				$variation_attributes = $first_variation_obj->get_variation_attributes();

				// Loop through each variation
				foreach ($variations as $variation) {
					// Get the variation object
					$variation_obj = wc_get_product($variation['variation_id']);

					// Get the variation image URL
					$variation_image_url = wp_get_attachment_image_src($variation['image_id'], 'full');

					// Get the variation data
					$variation_data = array(
						'variation_id' => $variation['variation_id'],
						'sku' => $variation_obj->get_sku(),
						'price' => $variation_obj->get_price(),
						'regular_price' => $variation_obj->get_regular_price(),
						'sale_price' => $variation_obj->get_sale_price(),
						'stock_status' => $variation_obj->get_stock_status(),
						'description' => $variation_obj->get_description(),
						'image_url' => $variation_image_url[0],

					);

					// Loop through each variation attribute
					foreach ($variation_attributes as $attribute_name => $attribute_values) {
						// Remove the "attribute_" prefix from the attribute name
						$attribute_name = str_replace('attribute_', '', $attribute_name);

						// Get the attribute value for the current variation
						$attribute_value = $variation_obj->get_attribute($attribute_name);

						// Add the attribute to the variation data
						$variation_data[$attribute_name] = $attribute_value;
					}

					// Add the variation data to the array
					$data[] = $variation_data;
				}

				// Convert the data array to JSON
				$json_data = json_encode($data, JSON_PRETTY_PRINT);

				// Wrap the JSON data in HTML <pre> tags for formatting
				$html_data = '<pre>' . htmlentities($json_data) . '</pre>';

				// Embed the JSON data within a <script> tag
				$js_code = '<script>var variationData = ' . json_encode($data) . ';</script>';

				// Print the HTML data and JS code
				// echo $html_data . $js_code;
				echo $js_code;
			} else {
				echo 'No variations available for the product.';
			}
		} else {
		}
	?>

	<div class="product-area-cont">
		<div class="product-area-one-cont">
			<div class="product-area-grid-cont">
				<div class="product-area-grid">
				<?php
					// Get the product object
					$product = wc_get_product( $product_id );

					//get product image
					$image_id = get_post_thumbnail_id( $product_id );
					$image_url = wp_get_attachment_url( $image_id );
					echo '<div class="product-area-grid-item-cont">';
						echo '<img id="variationImg" class="product-area-grid-item-img" src="'.$image_url.'" />';
					echo '</div>';

					// Get the product gallery image IDs
					$gallery_image_ids = $product->get_gallery_image_ids();
					// Loop through the gallery image IDs and output the URLs
					foreach ( $gallery_image_ids as $gallery_image_id ) {
						$gallery_image_url = wp_get_attachment_url( $gallery_image_id );
						echo '<div class="product-area-grid-item-cont">';
							echo '<img class="product-area-grid-item-img" src="'.$gallery_image_url.'" />';
						echo '</div>';
					}
				?>
				</div>
			</div>
		</div>
		<div class="product-area-two-cont">
			<div class="product-area-info-cont">
				<div class="product-area-info-component info-component-breadcrumb">
					<?php
						if ( function_exists( 'woocommerce_breadcrumb' ) ) {
							woocommerce_breadcrumb();
						}
					?>
					<div class="product-area-info-logo">
						<img class="product-area-info-logo-img" src="<?php echo get_template_directory_uri().'/assets/logo/1.png' ?>">
					</div>
				</div>
				<div class="product-area-info-component info-component-product-name">
					<h1 class="info-component-product-name-text"><?php echo the_title(); ?></h1>
				</div>
				<div class="product-area-info-component info-component-product-price">
					<p class="info-component-product-price-regular regular-price"></p>
					<p class="info-component-product-price-sale sale-price"></p>
				</div>
				<div class="product-area-info-component info-component-product-description">
					<p><?php echo $product->get_description(); ?></p>
				</div>
				<div class="product-area-info-component info-component-product-form">
					<?php do_action( 'woocommerce_single_product_summary' );  ?>
				</div>
				<div class="product-area-info-component info-component-product-additional-info">
					<?php do_action( 'woocommerce_after_single_product_summary' ); ?>
				</div>
			</div>
		</div>
	</div>

	<?php
	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */
	do_action( 'woocommerce_before_single_product_summaryx' );
	?>

	<div class="summary entry-summary">
		<?php
		/**
		 * Hook: woocommerce_single_product_summary.
		 *
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generate_product_data() - 60
		 */
		do_action( 'woocommerce_single_product_summaryx' );
		?>
	</div>

	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	do_action( 'woocommerce_after_single_product_summaryx' );
	?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
