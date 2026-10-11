/**
 * Homepage script. Loaded only on the front page (see inc/enqueue.php).
 *
 * Eases anchor links to in-page sections (for example #services and
 * #process from the header) and moves focus to the target so keyboard
 * and screen reader users land where the page scrolled.
 *
 * @package iweb
 */
( function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {
		var reduceMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

		document.querySelectorAll( 'a[href*="#"]' ).forEach( function ( link ) {
			link.addEventListener( 'click', function ( event ) {
				var url = new URL( link.href, window.location.href );

				if ( url.pathname !== window.location.pathname || ! url.hash ) {
					return;
				}

				var target = document.getElementById( url.hash.slice( 1 ) );

				if ( ! target ) {
					return;
				}

				event.preventDefault();
				target.scrollIntoView( { behavior: reduceMotion ? 'auto' : 'smooth', block: 'start' } );
				target.setAttribute( 'tabindex', '-1' );
				target.focus( { preventScroll: true } );
				window.history.pushState( null, '', url.hash );
			} );
		} );
	} );
}() );
