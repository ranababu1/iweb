/**
 * Blog script. Loaded on blog views (see inc/enqueue.php).
 *
 * Copies the article link from the share buttons and highlights the current
 * section in the table of contents. Both are enhancements: the share links
 * and the contents list work without JavaScript.
 *
 * @package iweb
 */
( function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {
		var copy = document.querySelector( '[data-copy-link]' );

		if ( copy && navigator.clipboard ) {
			var label = copy.querySelector( '[data-copy-label]' );
			var original = label ? label.textContent : '';

			copy.addEventListener( 'click', function () {
				navigator.clipboard.writeText( copy.getAttribute( 'data-copy-link' ) ).then( function () {
					if ( label ) {
						label.textContent = 'Link copied';
						window.setTimeout( function () {
							label.textContent = original;
						}, 2000 );
					}
				} );
			} );
		} else if ( copy ) {
			copy.hidden = true;
		}

		var toc = document.querySelector( '[data-toc]' );

		if ( ! toc || ! ( 'IntersectionObserver' in window ) ) {
			return;
		}

		var links = toc.querySelectorAll( 'a[href^="#"]' );
		var map = {};

		links.forEach( function ( link ) {
			var target = document.getElementById( link.getAttribute( 'href' ).slice( 1 ) );

			if ( target ) {
				map[ target.id ] = link;
			}
		} );

		var observer = new IntersectionObserver( function ( entries ) {
			entries.forEach( function ( entry ) {
				if ( entry.isIntersecting ) {
					links.forEach( function ( link ) {
						link.classList.remove( 'is-current' );
					} );
					map[ entry.target.id ].classList.add( 'is-current' );
				}
			} );
		}, { rootMargin: '0px 0px -70% 0px' } );

		Object.keys( map ).forEach( function ( id ) {
			observer.observe( document.getElementById( id ) );
		} );
	} );
}() );
