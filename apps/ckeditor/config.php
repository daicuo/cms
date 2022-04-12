<?php
//编辑器列表
DcConfigMerge('common.editor_list', ['ckeditor']);

//插件配置
return [
    'ckeditor' => [
        'editor_path'     => './apps/ckeditor/view/editor/index.tpl',
        'editor_function' => 'ckeditorParse',
        'theme'           => 'default',
        'theme_wap'       => 'default'
    ]
];