//https://ckeditor.com/docs/ckeditor4/latest/guide/dev_basepath.html
//https://gitee.com/mirrors/ckeditor
CKEDITOR.editorConfig = function( config ) {
    //config.language      = 'zh-cn';
    //config.width         = '100%';
    //config.height        = '100px';
    //config.uiColor     = '#9AB8F3';
    config.contentsCss   = CKEDITOR_BASEPATH+'contents.css';
    config.extraPlugins  = 'dcvideo,dcimage';
    config.toolbar       = [{name:"clipboard",items:["Source","PasteText","-","Undo","Redo"]},{name:"styles",items:["Styles","Format"]},{name:"basicstyles",items:["Bold","Italic","Strike","TextColor","BGColor","-","RemoveFormat"]},{name:"paragraph",items:["NumberedList","BulletedList","-","Outdent","Indent","-","Blockquote"]},{name:"links",items:["Link","Unlink","Anchor"]},{name:"insert",items:["dcimage","dcvideo","Image","Table","PageBreak"]},{name:"tools",items:["Maximize"]}];
    //config.filebrowserImageUploadUrl = window.daicuo.config.upload;
    //config.filebrowserImageBrowseUrl = window.daicuo.config.upload;
    //config.allowedContent      = true;//允许所有的标签和属性
    config.disallowedContent     = 'img{width,height};img[width,height]';//不允许的规则（单个配置）
    config.extraAllowedContent   = 'img(img-fluid);a[data-url](dc-player)';//允许的规则（单个配置）
    config.image_previewText     = ' ';
    config.image2_disableResizer = true;
    config.removeDialogTabs      = 'image:Link;image:advanced;link:advanced;link:upload';//image:info;
    //config.removeButtons       = 'Underline,Subscript,Superscript';
    //config.format_tags         = 'p;h1;h2;h3;pre';
    //config.enterMode           = CKEDITOR.ENTER_BR;
    //config.shiftEnterMode      = CKEDITOR.ENTER_P;
};