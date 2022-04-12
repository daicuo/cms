CKEDITOR.plugins.add('dcimage', {
	init: function (editor) {
        editor.ui.addButton('dcimage',{
            // 鼠标移到按钮提示文字
            label: '插入图片',
            // 命令
            command: 'dcimage',
            // 图标
            icon: this.path + 'image.svg',
            // 添加点击事件   
            click: function(){
                //alert($('.cke_button__dcimage').html());
            }
        });
        //editor.addContentsCss(this.path + "styles/easyimage.css");
	},
    afterInit: function( editor ) {
        daicuo.upload.ajaxLoad(function(){
            editor.on('dataReady', function( evt ) {
                daicuo.upload.start({
                    element: '.cke_button__dcimage',
                    multiple: true,
                    onSuccess: function(up, file, xhr){
                        var insertHtml = '<img class="img-fluid" alt="'+file.responseTp.data.old_name+'" src="'+file.responseTp.data.url+'" />';
                        editor.insertHtml(insertHtml);
                    }
                });
            } );
        });
        
    }
});