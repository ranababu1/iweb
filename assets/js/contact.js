/**
 * Start a project script. Loaded only on pages using the "Start a Project"
 * template (see inc/enqueue.php).
 *
 * Lists the chosen attachments and supports drag and drop onto the upload
 * area. Without JavaScript the native file input still works.
 *
 * @package iweb
 */
( function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {
		var zone = document.querySelector( '[data-dropzone]' );
		var input = document.getElementById( 'cf-files' );
		var names = document.querySelector( '[data-file-names]' );

		if ( ! zone || ! input || ! names ) {
			return;
		}

		function showNames() {
			names.textContent = Array.prototype.map.call( input.files, function ( file ) {
				return file.name;
			} ).join( ', ' );
		}

		input.addEventListener( 'change', showNames );

		[ 'dragenter', 'dragover' ].forEach( function ( type ) {
			zone.addEventListener( type, function ( event ) {
				event.preventDefault();
				zone.classList.add( 'is-dragover' );
			} );
		} );

		[ 'dragleave', 'drop' ].forEach( function ( type ) {
			zone.addEventListener( type, function ( event ) {
				event.preventDefault();
				zone.classList.remove( 'is-dragover' );
			} );
		} );

		zone.addEventListener( 'drop', function ( event ) {
			if ( event.dataTransfer && event.dataTransfer.files.length ) {
				input.files = event.dataTransfer.files;
				showNames();
			}
		} );

		input.addEventListener( 'focus', function () {
			zone.classList.add( 'is-focus' );
		} );

		input.addEventListener( 'blur', function () {
			zone.classList.remove( 'is-focus' );
		} );
	} );
}() );
