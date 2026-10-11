/**
 * FAQ page script. Loaded only on pages using the "FAQ" template
 * (see inc/enqueue.php).
 *
 * Turns the category cards into tabs that show one group at a time, and
 * opens the right group and question for deep links. Without JavaScript
 * every group is visible.
 *
 * @package iweb
 */
( function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {
		var tabs = document.querySelectorAll( '.faq-tab' );
		var groups = document.querySelectorAll( '.faq-group' );

		if ( ! tabs.length || ! groups.length ) {
			return;
		}

		document.documentElement.classList.add( 'faq-tabbed' );

		function show( key ) {
			tabs.forEach( function ( tab ) {
				var on = tab.getAttribute( 'data-group' ) === key;
				tab.classList.toggle( 'is-active', on );
				tab.setAttribute( 'aria-selected', on ? 'true' : 'false' );
			} );

			groups.forEach( function ( group ) {
				group.classList.toggle( 'is-active', group.getAttribute( 'data-group' ) === key );
			} );
		}

		function openQuestion( id ) {
			var item = document.getElementById( id );

			if ( ! item || ! item.closest ) {
				return false;
			}

			var group = item.closest( '.faq-group' );

			if ( group ) {
				show( group.getAttribute( 'data-group' ) );
			}

			if ( 'DETAILS' === item.tagName ) {
				item.open = true;
			}

			item.scrollIntoView( { block: 'center' } );
			return true;
		}

		tabs.forEach( function ( tab ) {
			tab.addEventListener( 'click', function ( event ) {
				event.preventDefault();
				show( tab.getAttribute( 'data-group' ) );
			} );
		} );

		document.querySelectorAll( '[data-open]' ).forEach( function ( link ) {
			link.addEventListener( 'click', function ( event ) {
				event.preventDefault();
				openQuestion( link.getAttribute( 'data-open' ) );
				window.history.replaceState( null, '', '#' + link.getAttribute( 'data-open' ) );
			} );
		} );

		if ( window.location.hash ) {
			openQuestion( window.location.hash.slice( 1 ) );
		}
	} );
}() );
