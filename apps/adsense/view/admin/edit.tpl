<div class="modal-content">
  <div class="modal-body"> 
    {:DcBuildForm([
        'name'     => 'hook_create',
        'class'    => 'bg-white px-2 py-2 form-create',
        'action'   => DcUrlAddon(['module'=>'adsense','controll'=>'admin','action'=>'update']),
        'method'   => 'post',
        'ajax'     => true,
        'submit'   => lang('submit'),
        'reset'    => lang('reset'),
        'close'    => lang('close'),
        'disabled' => false,
        'callback' => '',
        'data'     => $data,
        'items'    => [
            [
                'type'=>'hidden',
                'name'=>'info_module',
                'value'=>'adsense',
            ],
            [
                'type'=>'hidden',
                'name'=>'info_controll',
                'value'=>'index',
            ],
            [
                'type'=>'hidden',
                'name'=>'info_id',
                'value'=>$data['info_id'],
            ],
            [
                'type'=>'text',
                'name'=>'info_slug',
                'id'=>'info_slug',
                'title'=>'广告标识（必填）',
                'placeholder'=>'广告标识用来在模板里调用广告，唯一性',
                'tips'=>'',
                'value'=>$data['info_slug'],
                'readonly'=>false,
                'disabled'=>false,
                'required'=>true,
                'class'=>'row form-group',
                'class_left'=>'col-12',
                'class_right'=>'col-12',
                'class_right_control'=>'',
                'class_tips'=>'',
            ],
            [
                'type'=>'text',
                'name'=>'info_name',
                'id'=>'info_name',
                'title'=>'广告标题（必填）',
                'placeholder'=>'广告标题只为识别辨认不同广告条目之用，并不在广告中显示',
                'tips'=>'',
                'value'=>$data['info_name'],
                'readonly'=>false,
                'disabled'=>false,
                'required'=>true,
                'class'=>'row form-group',
                'class_left'=>'col-12',
                'class_right'=>'col-12',
                'class_right_control'=>'',
                'class_tips'=>'',
            ],
            [
                'type'=>'select',
                'name'=>'info_status',
                'id'=>'info_status',
                'title'=>'广告状态',
                'placeholder'=>'控制广告是否展示的开关',
                'tips'=>'',
                'value'=>$data['info_status'],
                'option'=>['normal'=>lang('normal'),'hidden'=>lang('hidden')],
                'readonly'=>false,
                'disabled'=>false,
                'required'=>false,
                'multiple'=>false,
                'class'=>'row form-group',
                'class_left'=>'col-12',
                'class_right'=>'col-12',
                'class_right_control'=>'',
                'class_tips'=>'',
            ],
            [
                'type'=>'custom',
                'name'=>'info_order',
                'id'=>'info_order',
                'title'=>'广告统计',
                'tips'=>'开启后会统计展示与点击次数，会轻微加重服务器负担',
                'value'=>$data['info_order'],
                'option'=>['0'=>'关闭','1'=>'开启'],
                'readonly'=>false,
                'disabled'=>false,
                'required'=>false,
                'class'=>'row form-group',
                'class_left'=>'col-12',
                'class_right'=>'col-12',
                'class_right_control'=>'',
                'class_tips'=>'custom-control-label text-muted pt-2 pl-3',
            ],
            [
                'type'=>'radio',
                'name'=>'info_action',
                'title'=>'展现方式',
                'tips'=>'',
                'value'=>$data['info_action'],
                'option'=>['code'=>'代码','image'=>'图片','text'=>'文字'],
                'readonly'=>false,
                'disabled'=>false,
                'required'=>true,
                'class'=>'row form-group info_action',
                'class_left'=>'col-12',
                'class_right'=>'col-12',
                'class_right_control'=>'',
                'class_tips'=>'',
            ],
            [
                'type'=>'html',
                'value'=>'<ul class="nav nav-tabs mb-3" id="formTab"><li class="nav-item"><a class="nav-link rounded-0 active" id="tab-1" data-toggle="tab" href="#platform-web">电脑端</a></li><li class="nav-item"><a class="nav-link rounded-0 " id="tab-2" data-toggle="tab" href="#platform-mobile">移动端</a></li></ul><div class="tab-content" id="formTabContent"><div class="tab-pane fade show active" id="platform-web">',
            ],
            [
                'type'=>'textarea',
                'name'=>'web[code][html]',
                'id'=>'web_code_html',
                'title'=>'广告 HTML 代码（必填）',
                'placeholder'=>'请直接输入需要展现的广告的 HTML 代码',
                'tips'=>'',
                'value'=>$data['web']['code']['html'],
                'readonly'=>false,
                'disabled'=>false,
                'required'=>false,
                'rows'=>5,
                'class'=>'row form-group adsense code',
                'class_left'=>'col-12',
                'class_right'=>'col-12',
                'class_right_control'=>'',
                'class_tips'=>'',
            ],
            [
                'type'=>'text',
                'name'=>'web[text][title]',
                'id'=>'web_text_title',
                'title'=>'文字内容（必填）',
                'placeholder'=>'请输入文字广告的显示内容',
                'tips'=>'',
                'value'=>$data['web']['text']['title'],
                'readonly'=>false,
                'disabled'=>false,
                'required'=>false,
                'class'=>'row form-group adsense text d-none',
                'class_left'=>'col-12',
                'class_right'=>'col-12',
                'class_right_control'=>'',
                'class_tips'=>'',
            ],
            [
                'type'=>'text',
                'name'=>'web[text][link]',
                'id'=>'web_text_link',
                'title'=>'文字链接（必填）',
                'placeholder'=>'请输入文字广告指向的 URL 链接地址。注意：站外的地址必须以http(s)://开头',
                'tips'=>'',
                'value'=>$data['web']['text']['link'],
                'readonly'=>false,
                'disabled'=>false,
                'required'=>false,
                'class'=>'row form-group adsense text d-none',
                'class_left'=>'col-12',
                'class_right'=>'col-12',
                'class_right_control'=>'',
                'class_tips'=>'',
            ],
            [
                'type'=>'text',
                'name'=>'web[text][class]',
                'id'=>'web_text_class',
                'title'=>'文字样式名（选填）',
                'placeholder'=>'请输入文字的样式名，如：text-info',
                'tips'=>'',
                'value'=>$data['web']['text']['class'],
                'readonly'=>false,
                'disabled'=>false,
                'required'=>false,
                'class'=>'row form-group adsense text d-none',
                'class_left'=>'col-12',
                'class_right'=>'col-12',
                'class_right_control'=>'',
                'class_tips'=>'',
            ],
            [
                'type'=>'text',
                'name'=>'web[text][size]',
                'id'=>'web_text_size',
                'title'=>'文字大小（必填）',
                'placeholder'=>'请输入文字广告的内容显示字体，可使用 pt、px、em 为单位',
                'tips'=>'',
                'value'=>$data['web']['text']['size'],
                'readonly'=>false,
                'disabled'=>false,
                'required'=>false,
                'class'=>'row form-group adsense text d-none',
                'class_left'=>'col-12',
                'class_right'=>'col-12',
                'class_right_control'=>'',
                'class_tips'=>'',
            ],
            [
                'type'=>'image',
                'name'=>'web[image][src]',
                'id'=>'web_image_src',
                'title'=>'图片地址（必填）',
                'placeholder'=>'请输入图片广告的图片调用地址',
                'tips'=>'',
                'value'=>$data['web']['image']['src'],
                'readonly'=>false,
                'disabled'=>false,
                'required'=>false,
                'class'=>'row form-group adsense image d-none',
                'class_left'=>'col-12',
                'class_right'=>'col-12',
                'class_right_control'=>'',
                'class_tips'=>'',
            ],
            [
                'type'=>'text',
                'name'=>'web[image][link]',
                'id'=>'web_image_link',
                'title'=>'图片链接（必填）',
                'placeholder'=>'请输入图片广告指向的 URL 链接地址',
                'tips'=>'',
                'value'=>$data['web']['image']['link'],
                'readonly'=>false,
                'disabled'=>false,
                'required'=>false,
                'class'=>'row form-group adsense image d-none',
                'class_left'=>'col-12',
                'class_right'=>'col-12',
                'class_right_control'=>'',
                'class_tips'=>'',
            ],
            [
                'type'=>'text',
                'name'=>'web[image][alt]',
                'id'=>'web_image_alt',
                'title'=>'图片替换文字（选填）',
                'placeholder'=>'请输入图片广告的鼠标悬停文字信息',
                'tips'=>'',
                'value'=>$data['web']['image']['alt'],
                'readonly'=>false,
                'disabled'=>false,
                'required'=>false,
                'class'=>'row form-group adsense image d-none',
                'class_left'=>'col-12',
                'class_right'=>'col-12',
                'class_right_control'=>'',
                'class_tips'=>'',
            ],
            [
                'type'=>'text',
                'name'=>'web[image][class]',
                'id'=>'web_image_class',
                'title'=>'图片样式名（选填）',
                'placeholder'=>'请输入图片的样式名，如：img-fluid',
                'tips'=>'',
                'value'=>$data['web']['image']['class'],
                'readonly'=>false,
                'disabled'=>false,
                'required'=>false,
                'class'=>'row form-group adsense image d-none',
                'class_left'=>'col-12',
                'class_right'=>'col-12',
                'class_right_control'=>'',
                'class_tips'=>'',
            ],
            [
                'type'=>'text',
                'name'=>'web[image][width]',
                'id'=>'web_image_width',
                'title'=>'图片宽度（选填）',
                'placeholder'=>'请输入图片广告的宽度，单位为像素',
                'tips'=>'',
                'value'=>$data['web']['image']['width'],
                'readonly'=>false,
                'disabled'=>false,
                'required'=>false,
                'class'=>'row form-group adsense image d-none',
                'class_left'=>'col-12',
                'class_right'=>'col-12',
                'class_right_control'=>'',
                'class_tips'=>'',
            ],
            [
                'type'=>'text',
                'name'=>'web[image][height]',
                'id'=>'web_image_height',
                'title'=>'图片高度（选填）',
                'placeholder'=>'请输入图片广告的高度，单位为像素',
                'tips'=>'',
                'value'=>$data['web']['image']['height'],
                'readonly'=>false,
                'disabled'=>false,
                'required'=>false,
                'class'=>'row form-group adsense image d-none',
                'class_left'=>'col-12',
                'class_right'=>'col-12',
                'class_right_control'=>'',
                'class_tips'=>'',
            ],
            [
                'type'=>'html',
                'value'=>'</div>',
            ],
            [
                'type'=>'html',
                'value'=>'<div class="tab-pane fade show" id="platform-mobile">',
            ],
            [
                'type'=>'textarea',
                'name'=>'mobile[code][html]',
                'id'=>'mobile_code_html',
                'title'=>'广告 HTML 代码（必填）',
                'placeholder'=>'请直接输入需要展现的广告的 HTML 代码',
                'tips'=>'',
                'value'=>$data['mobile']['code']['html'],
                'readonly'=>false,
                'disabled'=>false,
                'required'=>false,
                'rows'=>5,
                'class'=>'row form-group adsense code',
                'class_left'=>'col-12',
                'class_right'=>'col-12',
                'class_right_control'=>'',
                'class_tips'=>'',
            ],
            [
                'type'=>'text',
                'name'=>'mobile[text][title]',
                'id'=>'mobile_text_title',
                'title'=>'文字内容（必填）',
                'placeholder'=>'请输入文字广告的显示内容',
                'tips'=>'',
                'value'=>$data['mobile']['text']['title'],
                'readonly'=>false,
                'disabled'=>false,
                'required'=>false,
                'class'=>'row form-group adsense text d-none',
                'class_left'=>'col-12',
                'class_right'=>'col-12',
                'class_right_control'=>'',
                'class_tips'=>'',
            ],
            [
                'type'=>'text',
                'name'=>'mobile[text][link]',
                'id'=>'mobile_text_link',
                'title'=>'文字链接（必填）',
                'placeholder'=>'请输入文字广告指向的 URL 链接地址。注意：站外的地址必须以http(s)://开头',
                'tips'=>'',
                'value'=>$data['mobile']['text']['link'],
                'readonly'=>false,
                'disabled'=>false,
                'required'=>false,
                'class'=>'row form-group adsense text d-none',
                'class_left'=>'col-12',
                'class_right'=>'col-12',
                'class_right_control'=>'',
                'class_tips'=>'',
            ],
            [
                'type'=>'text',
                'name'=>'mobile[text][class]',
                'id'=>'mobile_text_class',
                'title'=>'文字样式名（选填）',
                'placeholder'=>'请输入文字的样式名，如：text-info',
                'tips'=>'',
                'value'=>$data['mobile']['text']['class'],
                'readonly'=>false,
                'disabled'=>false,
                'required'=>false,
                'class'=>'row form-group adsense text d-none',
                'class_left'=>'col-12',
                'class_right'=>'col-12',
                'class_right_control'=>'',
                'class_tips'=>'',
            ],
            [
                'type'=>'text',
                'name'=>'mobile[text][size]',
                'id'=>'mobile_text_size',
                'title'=>'文字大小（必填）',
                'placeholder'=>'请输入文字广告的内容显示字体，可使用 pt、px、em 为单位',
                'tips'=>'',
                'value'=>$data['mobile']['text']['size'],
                'readonly'=>false,
                'disabled'=>false,
                'required'=>false,
                'class'=>'row form-group adsense text d-none',
                'class_left'=>'col-12',
                'class_right'=>'col-12',
                'class_right_control'=>'',
                'class_tips'=>'',
            ],
            [
                'type'=>'image',
                'name'=>'mobile[image][src]',
                'id'=>'mobile_image_src',
                'title'=>'图片地址（必填）',
                'placeholder'=>'请输入图片广告的图片调用地址',
                'tips'=>'',
                'value'=>$data['mobile']['image']['src'],
                'readonly'=>false,
                'disabled'=>false,
                'required'=>false,
                'class'=>'row form-group adsense image d-none',
                'class_left'=>'col-12',
                'class_right'=>'col-12',
                'class_right_control'=>'',
                'class_tips'=>'',
            ],
            [
                'type'=>'text',
                'name'=>'mobile[image][link]',
                'id'=>'mobile_image_link',
                'title'=>'图片链接（必填）',
                'placeholder'=>'请输入图片广告指向的 URL 链接地址',
                'tips'=>'',
                'value'=>$data['mobile']['image']['link'],
                'readonly'=>false,
                'disabled'=>false,
                'required'=>false,
                'class'=>'row form-group adsense image d-none',
                'class_left'=>'col-12',
                'class_right'=>'col-12',
                'class_right_control'=>'',
                'class_tips'=>'',
            ],
            [
                'type'=>'text',
                'name'=>'mobile[image][alt]',
                'id'=>'mobile_image_alt',
                'title'=>'图片替换文字（选填）',
                'placeholder'=>'请输入图片广告的鼠标悬停文字信息',
                'tips'=>'',
                'value'=>$data['mobile']['image']['alt'],
                'readonly'=>false,
                'disabled'=>false,
                'required'=>false,
                'class'=>'row form-group adsense image d-none',
                'class_left'=>'col-12',
                'class_right'=>'col-12',
                'class_right_control'=>'',
                'class_tips'=>'',
            ],
            [
                'type'=>'text',
                'name'=>'mobile[image][class]',
                'id'=>'mobile_image_class',
                'title'=>'图片样式名（选填）',
                'placeholder'=>'请输入图片的样式名，如：img-fluid',
                'tips'=>'',
                'value'=>$data['mobile']['image']['class'],
                'readonly'=>false,
                'disabled'=>false,
                'required'=>false,
                'class'=>'row form-group adsense image d-none',
                'class_left'=>'col-12',
                'class_right'=>'col-12',
                'class_right_control'=>'',
                'class_tips'=>'',
            ],
            [
                'type'=>'text',
                'name'=>'mobile[image][width]',
                'id'=>'mobile_image_width',
                'title'=>'图片宽度（选填）',
                'placeholder'=>'请输入图片广告的宽度，单位为像素',
                'tips'=>'',
                'value'=>$data['mobile']['image']['width'],
                'readonly'=>false,
                'disabled'=>false,
                'required'=>false,
                'class'=>'row form-group adsense image d-none',
                'class_left'=>'col-12',
                'class_right'=>'col-12',
                'class_right_control'=>'',
                'class_tips'=>'',
            ],
            [
                'type'=>'text',
                'name'=>'mobile[image][height]',
                'id'=>'mobile_image_height',
                'title'=>'图片高度（选填）',
                'placeholder'=>'请输入图片广告的高度，单位为像素',
                'tips'=>'',
                'value'=>$data['mobile']['image']['height'],
                'readonly'=>false,
                'disabled'=>false,
                'required'=>false,
                'class'=>'row form-group adsense image d-none',
                'class_left'=>'col-12',
                'class_right'=>'col-12',
                'class_right_control'=>'',
                'class_tips'=>'',
            ],
            [
                'type'=>'html',
                'value'=>'</div></div>',
            ],
        ]
    ])}
  </div>
</div>