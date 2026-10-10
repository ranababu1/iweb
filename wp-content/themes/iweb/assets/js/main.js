/**
 * iweb global scripts.
 *
 * A minimal, working boilerplate: an IIFE, a DOMContentLoaded handler, and
 * a `js` class added to the <html> element. The theme stylesheets use that
 * class to apply progressive enhancements, for example showing the menu
 * toggle only when JavaScript is available. Add your own code inside the
 * DOMContentLoaded handler below.
 *
 * @package iweb
 */
( function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {
		// Flag that JavaScript is available to the theme stylesheets.
		document.documentElement.classList.add( 'js' );
	} );
}() );