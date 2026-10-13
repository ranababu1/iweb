/**
 * Header navigation: Services mega menu (hover and keyboard) and the mobile drawer.
 */
( function () {
	'use strict';
	var header = document.querySelector( '.iws-header' );
	if ( ! header ) { return; }

	/* ---------- Mega menu ---------- */
	var item = header.querySelector( '.iws-nav__item--mega' );
	var trigger = header.querySelector( '.iws-nav__trigger' );
	var mega = document.getElementById( 'iws-mega' );
	var closeTimer;
	var hoverable = window.matchMedia( '(hover: hover)' );

	function setCat( key ) {
		mega.querySelectorAll( '.iws-cat' ).forEach( function ( c ) { c.classList.toggle( 'is-active', c.dataset.cat === key ); } );
		mega.querySelectorAll( '.iws-mega__panel' ).forEach( function ( p ) { p.classList.toggle( 'is-active', p.dataset.panel === key ); } );
	}
	function openMega() {
		clearTimeout( closeTimer );
		mega.hidden = false;
		mega.classList.add( 'is-open' );
		trigger.setAttribute( 'aria-expanded', 'true' );
	}
	function closeMega( focusTrigger ) {
		mega.classList.remove( 'is-open' );
		trigger.setAttribute( 'aria-expanded', 'false' );
		closeTimer = setTimeout( function () { mega.hidden = true; }, 200 );
		if ( focusTrigger ) { trigger.focus(); }
	}
	if ( item && mega ) {
		trigger.addEventListener( 'click', function () {
			if ( 'true' === trigger.getAttribute( 'aria-expanded' ) ) { closeMega(); } else { openMega(); }
		} );
		item.addEventListener( 'mouseenter', function () { if ( hoverable.matches ) { openMega(); } } );
		item.addEventListener( 'mouseleave', function () { if ( hoverable.matches ) { closeTimer = setTimeout( function () { closeMega(); }, 150 ); } } );
		mega.querySelectorAll( '.iws-cat' ).forEach( function ( c ) {
			c.addEventListener( 'mouseenter', function () { setCat( c.dataset.cat ); } );
			c.addEventListener( 'focus', function () { setCat( c.dataset.cat ); } );
		} );
		item.addEventListener( 'keydown', function ( e ) {
			if ( 'Escape' === e.key ) { closeMega( true ); }
			if ( 'ArrowDown' === e.key && document.activeElement === trigger ) {
				e.preventDefault(); openMega();
				var first = mega.querySelector( '.iws-cat' ); if ( first ) { first.focus(); }
			}
		} );
		item.addEventListener( 'focusout', function ( e ) {
			if ( ! item.contains( e.relatedTarget ) ) { closeMega(); }
		} );
		document.addEventListener( 'click', function ( e ) { if ( ! item.contains( e.target ) && 'true' === trigger.getAttribute( 'aria-expanded' ) ) { closeMega(); } } );
	}

	/* ---------- Mobile drawer ---------- */
	var burger = header.querySelector( '.iws-burger' );
	var drawer = document.getElementById( 'iws-drawer' );
	var scrim = header.querySelector( '.iws-scrim' );
	if ( ! burger || ! drawer ) { return; }
	var closeBtn = drawer.querySelector( '.iws-drawer__close' );
	var hideTimer;

	function focusables() {
		return Array.prototype.filter.call(
			drawer.querySelectorAll( 'a[href], button:not([disabled])' ),
			function ( el ) { return el.offsetParent !== null; }
		);
	}
	function openDrawer() {
		clearTimeout( hideTimer );
		drawer.hidden = false; scrim.hidden = false;
		requestAnimationFrame( function () { drawer.classList.add( 'is-open' ); scrim.classList.add( 'is-open' ); } );
		document.documentElement.classList.add( 'iws-lock' );
		burger.setAttribute( 'aria-expanded', 'true' );
		setTimeout( function () { closeBtn.focus(); }, 50 );
	}
	function closeDrawer() {
		drawer.classList.remove( 'is-open' ); scrim.classList.remove( 'is-open' );
		document.documentElement.classList.remove( 'iws-lock' );
		burger.setAttribute( 'aria-expanded', 'false' );
		hideTimer = setTimeout( function () { drawer.hidden = true; scrim.hidden = true; }, 320 );
		burger.focus();
	}
	burger.addEventListener( 'click', openDrawer );
	closeBtn.addEventListener( 'click', closeDrawer );
	scrim.addEventListener( 'click', closeDrawer );
	drawer.addEventListener( 'keydown', function ( e ) {
		if ( 'Escape' === e.key ) { closeDrawer(); return; }
		if ( 'Tab' !== e.key ) { return; }
		var f = focusables(); if ( ! f.length ) { return; }
		var first = f[0], last = f[ f.length - 1 ];
		if ( e.shiftKey && document.activeElement === first ) { e.preventDefault(); last.focus(); }
		else if ( ! e.shiftKey && document.activeElement === last ) { e.preventDefault(); first.focus(); }
	} );
	drawer.querySelectorAll( 'button[aria-controls]' ).forEach( function ( b ) {
		b.addEventListener( 'click', function () {
			var panel = document.getElementById( b.getAttribute( 'aria-controls' ) );
			var open = 'true' !== b.getAttribute( 'aria-expanded' );
			b.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
			panel.hidden = ! open;
		} );
	} );
	window.matchMedia( '(min-width: 1024px)' ).addEventListener( 'change', function ( m ) { if ( m.matches && drawer.classList.contains( 'is-open' ) ) { closeDrawer(); } } );
}() );
