/*********************************************************************************************************/
/**
 * fileicon plugin for CKEditor 3.x (Author: Lajox ; Email: lajox@19www.com)
 * version:	 1.0
 * Released: On 2009-12-11
 * Download: http://code.google.com/p/lajox
 */
/*********************************************************************************************************/

CKEDITOR.plugins.add('fileicon',   
  {    
    requires: ['fileicon'],
	lang : ['en'], 
    init:function(a) { 
	var b="fileicon";
	var c=a.addCommand(b,new CKEDITOR.dialogCommand(b));
		c.modes={wysiwyg:1,source:0};
		c.canUndo=false;
	a.ui.addButton("fileicon",{
					label:a.lang.fileicon.title,
					command:b,
					icon:this.path+"fileicon.gif"
	});
	CKEDITOR.dialog.add(b,this.path+"dialogs/fileicon.js")}
});

CKEDITOR.config.fileicon_path=CKEDITOR.basePath+'plugins/fileicon/icons/';
CKEDITOR.config.fileicon_images=['ai.gif','avi.gif','bmp.gif','cs.gif','dll.gif','doc.gif','exe.gif','fla.gif','gif.gif','ico.gif','html.gif','jpg.gif','js.gif','mdb.gif','mp3.gif','pdf.gif','png.gif','ppt.gif','rdp.gif','swf.gif','txt.gif','vsd.gif','xls.gif','xml.gif','zip.gif'];
CKEDITOR.config.fileicon_descriptions=[
	'ai', 'avi', 'bmp', 'cs', 'dll', 'doc','exe', 'fla', 'gif','ico',
	'html', 'jpg', 'js', 'mdb', 'mp3', 'pdf','png', 'ppt', 'rdp','swf',
	'txt', 'vsd', 'xls', 'xml', 'zip'];
