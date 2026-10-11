<?php
/**
 * The search form.
 *
 * A unique ID is generated so the form can appear more than once per page
 * (for example in a widget and on a 404 page) with valid label associations.
 *
 * @package iweb
 * @since 1.0.0
 */

$iweb_search_id = wp_unique_id( 'iweb-search-' );
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="search-label" for="<?php echo esc_attr( $iweb_search_id ); ?>"><?php esc_html_e( 'Search for:', 'iweb' ); ?></label>
	<input
		type="search"
		class="search-field"
		placeholder="<?php esc_attr_e( 'Search …', 'iweb' ); ?>"
		value="<?php echo esc_attr( get_search_query() ); ?>"
		name="s"
		id="<?php echo esc_attr( $iweb_search_id ); ?>"
	/>
	<button type="submit" class="search-submit"><?php esc_html_e( 'Search', 'iweb' ); ?></button>
</form>