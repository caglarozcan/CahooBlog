/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	 //config.language = 'tr';
	 //config.uiColor = '#AADC6E';
	 
	config.entities = false;
	config.htmlEncodeOutput = false;
	config.entities_latin = false;
	config.ProcessHTMLEntities=true;
	config.entities_greek = false;
};
