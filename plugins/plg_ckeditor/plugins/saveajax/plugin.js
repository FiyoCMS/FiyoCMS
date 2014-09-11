CKEDITOR.plugins.add('ajaxsave',  {    

    init:function(editor) {

        var pluginName = 'ajaxsave';
        var command = editor.addCommand(pluginName,saveCmd);
        command.modes = {wysiwyg:1 };   

        editor.ui.addButton('ajaxsave', {
            label: 'Save text',
            command: pluginName,
            toolbar: 'undo,1',
            icon: this.path+'save.png'
        });
    }
});