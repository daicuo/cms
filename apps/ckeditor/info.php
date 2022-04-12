<?php
return [
    //插件唯一标识
    'module'   => 'ckeditor',
    //插件名称
    'name'     => 'CKEditor',
    //插件描述
    'info'     => 'CKEditor是全球最优秀的网页在线文字编辑器之一，因其惊人的性能与可扩展性被运用于呆错后台管理框架。',
    //插件版本
    'version'  => '1.1.2',
    //依赖数据库
    'datatype' => ['sqlite', 'mysql'],
    //依赖插件版本
    'rely'     => [
        'daicuo' => '1.8.46',
    ],
];