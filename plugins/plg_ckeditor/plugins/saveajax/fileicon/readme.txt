
/*********************************************************************************************************/
/**
 * fileicon plugin for CKEditor 3.x (Author: Lajox ; Email: lajox@19www.com)
 * version:	 1.0
 * Released: On 2009-12-11
 * Download: http://code.google.com/p/lajox
 */
/*********************************************************************************************************/

/**************************************************************************************************************
fileicon plugin for CKEditor 3.x

 --Insert File Icons Plugin

Plugin Description： CKEditor 3.0 Insert File Icons Plugin 1.0

***************************************************************************************************************/


/**************Help Begin***************/

1. Upload fileicon folder to  ckeditor/plugins/

2. Configured in the ckeditor/config.js :
    Add to config.toolbar a value 'fileicon'
e.g. 

config.toolbar = 
[
    [ 'Source', '-', 'Bold', 'Italic', 'fileicon' ]
];


3. Again Configured in the ckeditor/config.js ,
   Expand the extra plugin 'fileicon' such as:

config.extraPlugins='myplugin1,myplugin2,fileicon';

4. Modify the default language in inserthtml/plugin.js
	Just the line:
		lang : ['en'],

/**************Help End***************/


