/**
 * Subtle reveal-on-scroll for section content. Skipped entirely when the
 * user prefers reduced motion or IntersectionObserver is unavailable.
 */
( function () {
	'use strict';
	if ( ! ( 'IntersectionObserver' in window ) || window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) {
		return;
	}
	var items = document.querySelectorAll( '.site-main > section:not(:first-child) > .container > *' );
	var io = new IntersectionObserver( function ( entries ) {
		entries.forEach( function ( e ) {
			if ( e.isIntersecting ) {
				e.target.classList.add( 'is-visible' );
				io.unobserve( e.target );
			}
		} );
	}, { rootMargin: '0px 0px -8% 0px' } );
	Array.prototype.forEach.call( items, function ( el ) {
		el.classList.add( 'ed-reveal' );
		io.observe( el );
	} );
}() );
