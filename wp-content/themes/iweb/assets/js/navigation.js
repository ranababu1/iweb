/**
 * iweb navigation scripts.
 *
 * Handles the mobile menu toggle and the keyboard behavior of the
 * navigation dropdowns. This is progressive enhancement only: without
 * JavaScript the menu stays visible and expanded (see style.css).
 *
 * Markup provided by header.php:
 * - <button id="iweb-menu-toggle" class="menu-toggle" aria-expanded="…"
 *       aria-controls="site-navigation"> containing a
 *       <span class="menu-toggle-label">.
 * - <nav id="site-navigation" class="primary-navigation"> containing a
 *   <ul class="nav-menu"> with optional submenus inside
 *   <li class="menu-item-has-children"> items.
 *
 * Translatable strings are injected as window.iwebNav via
 * wp_localize_script() in inc/enqueue.php.
 *
 * @package iweb
 */
( function () {
	'use strict';

	var nav = null;
	var toggle = null;
	var toggleLabel = null;
	var suppressNextFocusOpen = false;

	// Localized strings, with plain fallbacks.
	var strings = window.iwebNav || {};
	var openLabel = strings.openLabel || 'Menu';
	var closeLabel = strings.closeLabel || 'Close menu';

	/**
	 * Check whether the menu toggle is visible (mobile viewport).
	 *
	 * @return {boolean} True when the toggle is visible.
	 */
	function isToggleVisible() {
		return null !== toggle && 0 !== toggle.offsetWidth;
	}

	/**
	 * Check whether the mobile menu is open.
	 *
	 * @return {boolean} True when the menu is expanded.
	 */
	function isMenuOpen() {
		return null !== nav && ! nav.classList.contains( 'is-collapsed' );
	}

	/**
	 * Update the toggle button state and its visible label.
	 *
	 * @param {boolean} open Whether the menu is open.
	 * @return {void}
	 */
	function setToggleState( open ) {
		toggle.setAttribute( 'aria-expanded', open ? 'true' : 'false' );

		if ( toggleLabel ) {
			toggleLabel.textContent = open ? closeLabel : openLabel;
		}
	}

	/**
	 * Open the mobile menu.
	 *
	 * @return {void}
	 */
	function openMenu() {
		nav.classList.remove( 'is-collapsed' );
		setToggleState( true );
	}

	/**
	 * Close the mobile menu and optionally return focus to the toggle.
	 *
	 * @param {boolean} moveFocus Whether to focus the toggle button.
	 * @return {void}
	 */
	function closeMenu( moveFocus ) {
		nav.classList.add( 'is-collapsed' );
		setToggleState( false );

		if ( moveFocus ) {
			toggle.focus();
		}
	}

	/**
	 * Open a dropdown (submenu).
	 *
	 * @param {HTMLElement} li The parent menu item.
	 * @return {void}
	 */
	function openDropdown( li ) {
		li.classList.add( 'is-open' );
	}

	/**
	 * Close a dropdown (submenu).
	 *
	 * @param {HTMLElement} li The parent menu item.
	 * @return {void}
	 */
	function closeDropdown( li ) {
		li.classList.remove( 'is-open' );
	}

	/**
	 * Close a dropdown and every dropdown nested inside it.
	 *
	 * @param {HTMLElement} li The parent menu item.
	 * @return {void}
	 */
	function closeAllDropdowns( li ) {
		var openItems = li.querySelectorAll( '.is-open' );
		var i;

		for ( i = 0; i < openItems.length; i++ ) {
			openItems[ i ].classList.remove( 'is-open' );
		}

		li.classList.remove( 'is-open' );
	}

	/**
	 * Get the direct link of a parent menu item.
	 *
	 * @param {HTMLElement} li The parent menu item.
	 * @return {HTMLElement|null} The link, when found.
	 */
	function getDirectLink( li ) {
		var children = li.children;
		var i;

		for ( i = 0; i < children.length; i++ ) {
			if ( 'A' === children[ i ].tagName ) {
				return children[ i ];
			}
		}

		return null;
	}

	/**
	 * Collect the focusable elements of the open mobile menu.
	 *
	 * Hidden elements (for example links inside collapsed submenus) are
	 * filtered out so the focus trap never targets an invisible element.
	 *
	 * @return {HTMLElement[]} The visible focusable elements.
	 */
	function getFocusables() {
		var candidates = nav.querySelectorAll(
			'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])'
		);
		var focusables = [];
		var i;

		for ( i = 0; i < candidates.length; i++ ) {
			if ( 0 < candidates[ i ].getClientRects().length ) {
				focusables.push( candidates[ i ] );
			}
		}

		return focusables;
	}

	/**
	 * Keep Tab focus inside the toggle and the menu while the mobile menu is open.
	 *
	 * @param {Event} event The keydown event.
	 * @return {void}
	 */
	function trapTab( event ) {
		var list = [ toggle ].concat( getFocusables() );
		var first = list[ 0 ];
		var last = list[ list.length - 1 ];

		if ( event.shiftKey && document.activeElement === first ) {
			event.preventDefault();
			last.focus();
		} else if ( ! event.shiftKey && document.activeElement === last ) {
			event.preventDefault();
			first.focus();
		}
	}

	/**
	 * Handle keyboard events on the document.
	 *
	 * Tab is trapped while the mobile menu is open. Escape closes the open
	 * submenu first, then the mobile menu, returning focus to the toggle.
	 *
	 * @param {Event} event The keydown event.
	 * @return {void}
	 */
	function onKeyDown( event ) {
		var active;
		var openParent;
		var link;

		if ( 'Tab' === event.key && isToggleVisible() && isMenuOpen() ) {
			trapTab( event );

			return;
		}

		if ( 'Escape' !== event.key && 'Esc' !== event.key ) {
			return;
		}

		// Close the mobile menu, returning focus to the toggle.
		if ( isToggleVisible() && isMenuOpen() ) {
			closeMenu( true );

			return;
		}

		// Close the open submenu and focus its parent link.
		active = document.activeElement;
		openParent = active ? active.closest( 'li.is-open' ) : null;

		if ( openParent ) {
			link = getDirectLink( openParent );
			closeAllDropdowns( openParent );

			if ( link ) {
				// Keep the submenu closed while its parent link is focused.
				suppressNextFocusOpen = true;
				link.focus();
			}
		}
	}

	/**
	 * Handle clicks on the toggle button.
	 *
	 * @return {void}
	 */
	function onToggleClick() {
		if ( isMenuOpen() ) {
			closeMenu( false );
		} else {
			openMenu();
		}
	}

	/**
	 * Handle clicks outside the menu while the mobile menu is open.
	 *
	 * @param {Event} event The click event.
	 * @return {void}
	 */
	function onOutsideClick( event ) {
		if ( isToggleVisible() && isMenuOpen() && ! nav.contains( event.target ) && ! toggle.contains( event.target ) ) {
			closeMenu( false );
		}
	}

	/**
	 * Keep the menu state in sync when the viewport changes.
	 *
	 * @return {void}
	 */
	function onResize() {
		// The menu is never collapsed while the toggle is hidden (desktop).
		if ( ! isToggleVisible() && ! isMenuOpen() ) {
			openMenu();
		}
	}

	/**
	 * Wire up the menu behavior.
	 *
	 * @return {void}
	 */
	function init() {
		var parents;
		var i;

		nav = document.getElementById( 'site-navigation' );
		toggle = document.getElementById( 'iweb-menu-toggle' );

		if ( ! nav || ! toggle ) {
			return;
		}

		toggleLabel = toggle.querySelector( '.menu-toggle-label' );

		// Collapse the menu on the mobile viewport where the toggle is visible.
		if ( isToggleVisible() ) {
			closeMenu( false );
		}

		toggle.addEventListener( 'click', onToggleClick );

		// Dropdowns: open on focus and pointer, close when focus or the
		// pointer leaves the parent item.
		parents = nav.querySelectorAll( '.menu-item-has-children' );

		for ( i = 0; i < parents.length; i++ ) {
			( function () {
				var li = parents[ i ];

				li.addEventListener( 'focusin', function () {
					if ( suppressNextFocusOpen ) {
						suppressNextFocusOpen = false;

						return;
					}

					openDropdown( li );
				} );

				li.addEventListener( 'focusout', function ( event ) {
					if ( ! li.contains( event.relatedTarget ) ) {
						closeDropdown( li );
					}
				} );

				li.addEventListener( 'mouseenter', function () {
					openDropdown( li );
				} );

				li.addEventListener( 'mouseleave', function () {
					if ( ! li.contains( document.activeElement ) ) {
						closeDropdown( li );
					}
				} );
			}() );
		}

		document.addEventListener( 'keydown', onKeyDown );
		document.addEventListener( 'click', onOutsideClick );
		window.addEventListener( 'resize', onResize );
	}

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
}() );