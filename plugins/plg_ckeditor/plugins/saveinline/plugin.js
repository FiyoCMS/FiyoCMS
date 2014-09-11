/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

/**
 * @fileOverview The Save plugin.
 */

(function() {
	var saveCmd = {
			$.ajax({			
				url: "<?php echo FUrl; ?>apps/app_article/controller/ajaxquery.php",
				data: "article="+data+"&id="+id,
				success: function(data){
				$(".savebutton").attr( "value","Save");	
							
					
					$("#article-main").css({opacity: "1"});
					setTimeout(function(){
						$('#stat').fadeOut(1000, function() {
						});				
					}, 3000);
				}
			});	
	};

	var pluginName = 'saveinline';

	// Register a plugin named "save".
	CKEDITOR.plugins.add( pluginName, {
		lang: 'af,ar,bg,bn,bs,ca,cs,cy,da,de,el,en,en-au,en-ca,en-gb,eo,es,et,eu,fa,fi,fo,fr,fr-ca,gl,gu,he,hi,hr,hu,id,is,it,ja,ka,km,ko,ku,lt,lv,mk,mn,ms,nb,nl,no,pl,pt,pt-br,ro,ru,si,sk,sl,sq,sr,sr-latn,sv,th,tr,ug,uk,vi,zh,zh-cn', // %REMOVE_LINE_CORE%
		icons: 'save', // %REMOVE_LINE_CORE%
		hidpi: true, // %REMOVE_LINE_CORE%
		init: function( editor ) {
		
			var command = editor.addCommand( pluginName, saveCmd );
			command.modes = { wysiwyg: !!( editor.element.$.form ) };

			editor.ui.addButton && editor.ui.addButton( 'Saveinline', {
				label: editor.lang.save.toolbar,
				command: pluginName,
				toolbar: 'document2,110'
			});
		}
	});
})();

/**
 * Fired when the user clicks the Save button on the editor toolbar.
 * This event allows to overwrite the default Save button behavior.
 *
 * @since 4.2
 * @event save
 * @member CKEDITOR.editor
 * @param {CKEDITOR.editor} editor This editor instance.
 */
