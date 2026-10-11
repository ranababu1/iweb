/**
 * Service page script. Loaded only on pages using the "Service – Get Found"
 * template (see inc/enqueue.php).
 *
 * Keeps one FAQ answer open at a time. Without JavaScript every item still
 * opens and closes independently through the native details element.
 *
 * @package iweb
 */
( function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {
		var list = document.querySelector( '[data-faq]' );

		if ( ! list ) {
			return;
		}

		var items = list.querySelectorAll( 'details' );

		items.forEach( function ( item ) {
			item.addEventListener( 'toggle', function () {
				if ( ! item.open ) {
					return;
				}

				items.forEach( function ( other ) {
					if ( other !== item ) {
						other.open = false;
					}
				} );
			} );
		} );
	} );
}() );
