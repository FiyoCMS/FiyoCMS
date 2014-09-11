/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	CKEDITOR.config.allowedContent = true;
	config.protectedSource.push(/<\?[\s\S]*?\?>/g); // PHP Code
	config.protectedSource.push(/<code>[\s\S]*?<\/code>/gi); // Code tags
	config.filebrowserBrowseUrl = '../plugins/plg_kcfinder/browse.php?type=files&dir=files';
	config.filebrowserImageBrowseUrl = '../plugins/plg_kcfinder/browse.php?type=images&dir=images';
	config.filebrowserFlashBrowseUrl = '../plugins/plg_kcfinder/browse.php?type=flash&dir=flash';	
	
	config.toolbar = 'Mini';
	config.toolbar_Mini =
	[
		
		{ name: 'basicstyles', items : [ 'Bold','Italic','Underline' ] },
		{ name: 'justify', items : [ 'JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'] },
		{ name: 'links', items : [ 'Link','Unlink','-','Image','Flash' ] },		
		// Defines toolbar group without name.
		'/',																					// Line break - next group will be placed in new line.
		{ name: 'styles', items : ['FontSize' ] },
		{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent'] },
		{ name: 'insert2', items : [ 'Blockquote','HorizontalRule' ] },
		{ name: 'links', items :[ 'Undo', 'Redo' ] },		
	];	
	config.toolbar = 'Minify';
	config.toolbar_Minify =
	[
		
		{ name: 'document', items: [ 'Source' ] },
		{ name: 'basicstyles', items : [ 'Bold','Italic','Underline'] },
		{ name: 'justify', items : [ 'JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'] },
		{ name: 'links', items : [ 'Link','Unlink' ] },		
		{ name: 'insert', items : [ 'Image','Flash','Table'] },	
		{ name: 'links', items :[ 'Undo', 'Redo' ] },		
		{ name: 'styles', items : ['Format','Font','FontSize' ] },
		{ name: 'colors', items : [ 'TextColor','BGColor' ] },
		{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent'] },
		{ name: 'insert2', items : [ 'Blockquote','HorizontalRule' ] },
	];	
	config.toolbar = 'Null';
	config.toolbar_Null =
	[		
		
	];	
	config.toolbar = 'Full';
	config.toolbar_Full =
	[
		{ name: 'sourssce', items : [ 'Source'] },
		{ name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
		{ name: 'editing', items : [ 'SpecialChar','Find','Replace','-','SpellChecker', 'Scayt' ] },
		{ name: 'tools', items : [  'Templates','Maximize','ShowBlocks' ] },
		{ name: 'insert2', items : [ 'Blockquote','HorizontalRule' ] },
		'/',
		{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','-','Subscript','Superscript','-','RemoveFormat' ] },
		{ name: 'colors', items : [ 'TextColor','BGColor' ] },
		{ name: 'justify', items : [ 'JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'] },
		{ name: 'links', items : [ 'Link','Unlink','Anchor' ] },
		{ name: 'insert', items : [ 'Image','Flash','Table'] },
		'/',
		
		{ name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
		{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent'] },
		{ name: 'insert2', items : [ 'PageBreak'] },
	];	
};
