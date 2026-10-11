/**
 * Gentle fade-up for section content (80ms stagger). Does nothing when the
 * visitor prefers reduced motion.
 */
( function () {
	'use strict';
	if ( ! ( 'IntersectionObserver' in window ) || window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) {
		return;
	}
	var groups = document.querySelectorAll( '.site-main > section:not(:first-child) .container > *, .big-cta__inner > *' );
	var io = new IntersectionObserver( function ( entries ) {
		entries.forEach( function ( e ) {
			if ( e.isIntersecting ) {
				e.target.classList.add( 'is-visible' );
				io.unobserve( e.target );
			}
		} );
	}, { rootMargin: '0px 0px -6% 0px' } );
	Array.prototype.forEach.call( groups, function ( el, i ) {
		el.classList.add( 'iws-fade' );
		el.style.setProperty( '--iws-delay', ( ( i % 4 ) * 80 ) + 'ms' );
		io.observe( el );
	} );
}() );
