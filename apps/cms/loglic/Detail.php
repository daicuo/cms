<?php
namespace app\cms\loglic;

class Detail
{
    // 错误信息
    protected $error = '';
    
    /**
    * 定义文章模型的字段
    * @version 1.3.1 首次引入
    * @param array $data 可选;初始数据;默认：空
    * @return array 表格列字段属性（DcBuildTable）
    */
    public function fields($data=[])
    {
        $fields = [
            'html_1' => [
                'order'           => 1,
                'type'            => 'html',
                'value'           => '<div class="row"><div class="col-12 col-xl-10"><div class="bg-f9 rounded h-100 py-2 px-3">',
            ],
            'info_user_id' => [
                'order'           => 0,
                'type'            => 'hidden',
                'value'           => DcUserCurrentGetId(),
            ],
            'info_id' => [
                'order'           => 2,
                'type'            => 'hidden',
                'value'           => $data['info_id'],
                'data-title'      => lang('cms_id'),
                'data-filter'     => false,
                'data-visible'    => true,
                'data-sortable'   => true,
                'data-width'      => '80',
                'data-width-unit' => 'px',
            ],
            'info_name' => [
                'order'           => 3,
                'type'            => 'text',
                'value'           => $data['info_name'],
                'title'           => lang('cms_name'),
                'placeholder'     => lang('cms_name_placeholder'),
                'data-filter'     => false,
                'data-visible'    => true,
                'data-align'      => 'left',
                'data-class'      => 'text-wrap',
            ],
            'cms_category' => [
                'order'           => 6,
                'data-title'      => lang('cms_category'),
                'data-visible'    => true,
            ],
            'info_slug' => [
                'order'           => 4,
                'type'            => 'text',
                'value'           => $data['info_slug'],
                'title'           => lang('cms_slug'),
                'data-filter'     => false,
                'data-visible'    => false,
            ],
            'cms_cover' => [
                'order'           => 5,
                'type'            => 'image',
                'value'           => $data['cms_cover'],
                'title'           => lang('cms_cover'),
                'placeholder'     => '',
                'data-filter'     => false,
                'data-visible'    => false,
            ],
            'cms_slide' => [
                'order'           => 6,
                'type'            => 'image',
                'value'           => $data['cms_slide'],
                'title'           => lang('cms_slide'),
                'placeholder'     => '',
                'data-filter'     => false,
                'data-visible'    => false,
            ],
            'tag_name'  => [
                'order'           => 7,
                'type'            =>'tags',
                'value'           => implode(',',$data['tag_name']),
                'option'          => cmsTags(20),
                'title'           => lang('cms_tag'),
                'placeholder'     => '',
                'class_tags'      => 'form-text pt-1',
                'class_tags_list' => 'text-purple mr-2',
            ],
            'info_excerpt' => [
                'order'           => 8,
                'type'            => 'textarea',
                'value'           => $data['info_excerpt'],
                'rows'            => 3,
                'data-filter'     => false,
                'data-visible'    => false,
            ],
            'info_content' => [
                'order'           => 9,
                'type'            => 'editor',
                'value'           => $data['info_content'],
                'title'           => lang('cms_content'),
                'rows'            => 50,
                'height'          => '50rem',
                'data-filter'     => false,
                'data-visible'    => false,
            ],
            'html_2' => [
                'order'           => 10,
                'type'            => 'html',
                'value'           => '</div></div><div class="col-12 col-xl-2"><div class="bg-f9 rounded h-100 py-2 px-3">',
            ],
            'cms_attr' => [
                'order'             => 11,
                'type'              => 'checkbox',
                'value'             => cmsAttrValue($data),
                'option'            => cmsAttrOption(),
                'class_right'       => 'row pl-4',
                'class_right_check' => 'col-6 form-check form-check-inline pl-2 mr-0 mb-1',
                'data-filter'       => true,
                'data-type'         => 'select',
                'data-option'       => cmsDataOption(cmsAttrOption()),
            ],
            'category_id' => [
                'order'             => 12,
                'type'              => 'checkbox',
                'value'             => $data['category_id'],
                'option'            => DcTermCheck(['module'=>['eq','cms']]),
                'title'             => lang('cms_category'),
                'data-filter'       => true,
                'data-visible'      => false,
                'class_right'       => 'row pl-4',
                'class_right_check' => 'col-6 form-check form-check-inline pl-2 mr-0 mb-1',
                'data-type'         => 'select',
                'data-option'       => cmsDataOption(DcTermCheck(['module'=>['eq','cms']])), 
            ],
            'info_type' => [
                'order'           => 15,
                'type'            => 'select',
                'value'           => DcEmpty($data['info_type'],'index'),
                'option'          => cmsTypeOption(),
                'title'           => lang('cms_type'),
                'data-title'      => lang('cms_type'),
                'data-filter'     => true,
                'data-visible'    => true,
                'data-width'      => 80,
            ],
            'info_status' => [
                'order'           => 13,
                'type'            => 'select',
                'value'           => DcEmpty($data['info_status'],'normal'),
                'option'          => ['normal'=>lang('normal'),'hidden'=>lang('hidden'),'private'=>lang('private')],
                'title'           => lang('cms_status'),
                'data-filter'     => true,
                'data-visible'    => false,
            ],
            'info_status_text' => [
                'order'           => 14,
                'data-title'      => lang('cms_status'),
                'data-visible'    => true,
                'data-width'      => 80,
            ],
            'cms_color'       => [
                'order'           => 16,
                'type'            => 'select',
                'value'           => DcEmpty($data['cms_color'],'text-dark'),
                'option'          => [
                    'text-dark'      => 'text-dark',
                    'text-danger'    => 'text-danger',
                    'text-success'   => 'text-success',
                    'text-primary'   => 'text-primary',
                    'text-info'      => 'text-info',
                    'text-secondary' => 'text-secondary',
                    'text-muted'     => 'text-muted',
                    'text-light'     => 'text-light',
                ],
                'title'              => lang('cms_color'),
            ],
            'info_order' => [
                'order'           => 17,
                'type'            => 'number',
                'value'           => intval($data['info_order']),
                'data-filter'     => false,
                'data-visible'    => true,
                'data-sortable'   => true,
                'data-width'      => 80,
            ],
            'info_views' => [
                'order'           => 18,
                'type'            => 'number',
                'value'           => intval($data['info_views']),
                'data-filter'     => false,
                'data-visible'    => true,
                'data-sortable'   => true,
                'data-width'      => 80,
            ],
            'info_hits' => [
                'order'           => 19,
                'type'            => 'number',
                'value'           => intval($data['info_hits']),
                'data-filter'     => false,
                'data-visible'    => true,
                'data-sortable'   => true,
                'data-width'      => 80,
            ],
            'cms_up' => [
                'order'           => 20,
                'type'            => 'number',
                'value'           => intval($data['cms_up']),
                'title'           => lang('cms_up'),
                'data-title'      => lang('cms_up'),
                'data-filter'     => false,
                'data-visible'    => true,
                'data-sortable'   => true,
                'data-width'      => 80,
            ],
            'cms_down' => [
                'order'           => 21,
                'type'            => 'number',
                'value'           => intval($data['cms_down']),
                'title'           => lang('cms_down'),
                'data-title'      => lang('cms_down'),
                'data-filter'     => false,
                'data-visible'    => true,
                'data-sortable'   => true,
                'data-width'      => 80,
            ],
            'cms_letter' => [
                'order'           => 22,
                'type'            => 'text',
                'value'           => $data['cms_letter'],
                'title'           => lang('cms_letter'),
                'placeholder'     => lang('cms_letter_placeholder'),
                'data-title'      => lang('cms_letter'),
                'data-filter'     => false,
                'data-visible'    => true,
                'data-sortable'   => true,
                'data-width'      => 80,
            ],
            'cms_tpl' => [
                'order'           => 23,
                'type'            => 'text',
                'value'           => $data['cms_tpl'],
                'title'           => lang('cms_tpl'),
                'placeholder'     => lang('cms_tpl_placeholder'),
                'data-filter'     => false,
                'data-visible'    => false,
            ],
            'cms_referer' => [
                'order'           => 24,
                'type'            => 'text',
                'value'           => $data['cms_referer'],
                'title'           => lang('cms_referer'),
                'placeholder'     => lang('cms_referer_placeholder'),
                'data-filter'     => false,
                'data-visible'    => false,
            ],
            'info_title' => [
                'order'           => 25,
                'type'            => 'text',
                'value'           => $data['info_title'],
                'title'           => lang('cms_seo_title'),
                'data-filter'     => false,
                'data-visible'    => false,
            ],
            'info_keywords' => [
                'order'           => 26,
                'type'            => 'text',
                'value'           => $data['info_keywords'],
                'title'           => lang('cms_seo_keywords'),
                'data-filter'     => false,
                'data-visible'    => false,
            ],
            'info_description' => [
                'order'           => 27,
                'type'            => 'textarea',
                'value'           => $data['info_description'],
                'rows'            => 3,
                'title'           => lang('cms_seo_description'),
                'data-filter'     => false,
                'data-visible'    => false,
            ],
            'info_update_time' => [
                'order'           => 510,
                'data-visible'    => true,
                'data-sortable'   => true,
                'data-width'      => 120,
            ],
            'html_3'      => [
                'order'           => 29,
                'type'            => 'html',
                'value'           => '</div></div></div>',
            ]
        ];
        //动态扩展字段（可精确到操作名）
        $customs = cmsMetaList('detail', 'index');
        //合并所有字段
        if($customs){
            $fields = DcArrayPush($fields, DcFields($customs, $data), 'html_2');
        }
        //返回所有表单字段
        return $fields;
    }
    
    /**
    * 添加文章高级用法（自定义场景与规则）
    * @version 1.0.0 首次引入
    * @param array $post 必需;数组格式,支持的字段列表请参考手册
    * @param bool $autoTerm 必需;当分类与标签不存在时是否自动新增;默认:false
    * @param string $action 必需;新增或修改(save|update);默认:save
    * @param string $scene 可选;验证场景(save|update|slugUnique|refererUnique);默认:slugUnique
    * @param array $sceneRule 可选;自定义验证规则;默认:无
    * @param array $slugRule 可选;别名规则;默认:false
    * @return mixed 成功时返回obj,失败时null
    */
    public function write($post=[], $autoTerm=false, $action='save', $scene='slugUnique', $sceneRule=[], $slugRule=false)
    {
        //数据格式化（修改器）
        $post = DcArrayArgs($post,[
            'info_module'   => 'cms',
            'info_controll' => 'detail',
            'info_action'   => 'index',
            'info_staus'    => 'normal',
            'info_type'     => 'index',
        ]);
        $post = cmsDataSet($post, $autoTerm);

        //取消框架模块验证
        config('common.validate_name', false);
        config('common.validate_scene', false);
        //自定义验证器与验证规则
        if($scene){
            //实例化验证器
            $validate = validate('cms/Detail', 'validate');
            //自定义验证场景规则
            if($sceneRule){
                $validate->scene($scene, $sceneRule);
            }
            //表单验证结果（失败）
            if(!$validate->scene($scene)->check($post)){
                $this->error = $validate->getError();
                return null;
            }
        }

        //定义框架别名处理规则（默认取消别名检测false）
        config('common.where_slug_unique', $slugRule);
        //config('common.where_slug_unique',['info_module'=>['eq','cms'],'info_controll'=>['eq','detail']]);
        //调用数据库接口
        if($action == 'save'){
            return \daicuo\Info::save($post, 'info_meta,term_map');
        }else if($action == 'update'){
            return DcArrayResult(\daicuo\Info::update_id($post['info_id'], $post, 'info_meta,term_map'));
        }
        //默认返回
        return null;
    }
    
    /**
     * 获取错误信息
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }
}