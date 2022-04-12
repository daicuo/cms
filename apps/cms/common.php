<?php
/**
 * 添加一篇文章
 * @version 1.2.4 首次引入
 * @param array $post 必需;数组格式,支持的字段列表请参考手册
 * @param bool $autoSave 可选;当分类与标签不存在时是否自动新增;默认:false
 * @return int 返回自增ID或0
 */
function cmsSave($post=[], $autoSave=false)
{
    $post = DcArrayArgs($post,[
        'info_module'   => 'cms',
        'info_controll' => 'detail',
        'info_action'   => 'index',
        'info_staus'    => 'normal',
        'info_type'     => 'index',
        'info_user_id'  => 1,
    ]);
    $post = cmsDataSet($post, $autoSave);
    
    config('common.validate_name','cms/Detail');
        
    config('common.validate_scene','save');

    config('common.where_slug_unique',['info_module'=>['eq','cms']]);
    
    config('custom_fields.info_meta',cmsMetaKeys('detail',NULL));

    return \daicuo\Info::save($post, 'info_meta,term_map');
}

/**
 * 按ID删除一条或多条文章
 * @version 1.2.4 首次引入
 * @param mixed $ids 必需;多个用逗号分隔或使用数组传入(array|string);默认：空 
 * @return array ID作为键名,键值为删除结果(bool)
 */
function cmsDelete($ids=[])
{
    return model('common/Info','loglic')->deleteIds($ids);
}

/**
 * 修改一篇文章(需传入主键值作为更新条件)
 * @version 1.2.4 首次引入
 * @param array $post 必需;表单字段 {
 *     @type int $info_id 必需;按ID修改;默认：空
 * }
 * @param bool $autoSave 可选;当分类与标签不存在时是否自动新增;默认:false
 * @return mixed 成功时返回obj,失败时null
 */
function cmsUpdate($post=[], $autoSave=false)
{
    $post = DcArrayArgs($post,[
        'info_module'   => 'cms',
        'info_controll' => 'detail',
        'info_action'   => 'index',
        'info_staus'    => 'normal',
        'info_type'     => 'index',
        'info_user_id'  => 1,
    ]);
    $post = cmsDataSet($post, $autoSave);
    
    config('common.validate_name','cms/Detail');
        
    config('common.validate_scene','update');

    config('common.where_slug_unique',['info_module'=>['eq','cms']]);
    
    config('custom_fields.info_meta',cmsMetaKeys('detail',NULL));
    
    return \daicuo\Info::update_id($post['info_id'], $post, 'info_meta,term_map');
}

/**
 * 按条件查询多条文章数据
 * @version 1.2.4 首次引入
 * @param array $args 必需;查询条件数组格式 {
 *     @type bool $cache 可选;是否缓存;默认：true
 *     @type string $result 可选;返回结果类型(array|obj);默认：array
 *     @type string $field 可选;查询字段;默认：*
 *     @type string $status 可选;显示状态（normal|hidden|private）;默认：空
 *     @type string $limit 可选;分页大小;默认：0
 *     @type string $page 可选;当前分页;默认：0
 *     @type string $sort 可选;排序字段名(info_id|info_order|info_views|info_hits|meta_value_num);默认：info_id
 *     @type string $order 可选;排序方式(asc|desc);默认：asc
 *     @type string $search 可选;搜索关键词（info_name|info_slug|info_excerpt）;默认：空
 *     @type mixed $id 可选;内容ID限制条件(int|array);默认：空
 *     @type mixed $title 可选;标题限制条件(stirng|array);默认：空
 *     @type mixed $name 可选;名称限制条件(stirng|array);默认：空
 *     @type mixed $slug 可选;别名限制条件(stirng|array);默认：空
 *     @type mixde $action 可选;所属操作名(stirng|array);默认：空
 *     @type mixde $controll 可选;所属控制器(stirng|array);默认：空
 *     @type mixed $term_id 可选;分类法ID限制条件(string|array);默认：空
 *     @type array $meta_query 可选;自定义字段(二维数组[key=>['eq','key'],value=>['in','key']]);默认：空
 *     @type array $with 可选;自定义关联查询条件;默认：空
 *     @type array $view 可选;自定义视图查询条件;默认：空
 *     @type array $where 可选;自定义高级查询条件;默认：空
 *     @type array $paginate 可选;自定义高级分页参数;默认：空
 * }
 * @return mixed 查询结果（array|null）
 */
function cmsSelect($args)
{
    $args = DcArrayArgs($args,[
        'cache'    => true,
        'result'   => 'array',
        'module'   => 'cms',
    ]);
    return model('common/Info','loglic')->select($args);
}

/**
 * 按条件查询一条文章
 * @version 1.2.4 首次引入
 * @param array $args 必需;查询条件数组格式 {
 *     @type bool $cache 可选;是否缓存;默认：true
 *     @type string $status 可选;显示状态（normal|hidden）;默认：空
 *     @type mixed $id 可选;内容ID(stirng|array);默认：空
 *     @type mixed $name 可选;内容名称(stirng|array);默认：空
 *     @type mixed $slug 可选;内容别名(stirng|array);默认：空
 *     @type mixed $title 可选;内容别名(stirng|array);默认：空
 *     @type mixed $user_id 可选;用户ID(stirng|array);默认：空
 *     @type array $with 可选;自定义关联查询条件;默认：空
 *     @type array $view 可选;自定义视图查询条件;默认：空
 *     @type array $where 可选;自定义高级查询条件;默认：空
 * }
 * @return mixed 查询结果（array|null）
 */
function cmsGet($args)
{
    $args = DcArrayArgs($args,[
        'cache'    => true,
        'module'   => 'cms',
    ]);
    
    $args = DcArrayEmpty($args);
    
    return cmsDataGet( model('common/Info','loglic')->get($args)  );
}

/**
 * 按ID快速获取一篇文章
 * @version 1.2.4 首次引入
 * @param int $value 必需;Id值；默认：空
 * @param bool $cache 可选;是否缓存;默认：true
 * @param string $status 可选;数据状态;默认：normal
 * @return mixed 查询结果(obj|null)
 */
function cmsGetId($value='', $cache=true, $status='normal')
{
    if (!$value) {
        return null;
    }
    return cmsGet([
        'cache'  => $cache,
        'status' => $status,
        'id'     => $value,
    ]);
}

/**
 * 按SLUG快速获取一篇文章
 * @version 1.2.4 首次引入
 * @param int $value 必需;Id值；默认：空
 * @param bool $cache 可选;是否缓存;默认：true
 * @param string $status 可选;数据状态;默认：normal
 * @return mixed 查询结果(obj|null)
 */
function cmsGetSlug($value='', $cache=true, $status='normal')
{
    if (!$value) {
        return null;
    }
    return cmsGet([
        'cache'  => $cache,
        'status' => $status,
        'slug'   => $value,
    ]);
}

/**
 * 按NAME快速获取一条文章
 * @version 1.2.4 首次引入
 * @param int $value 必需;Id值；默认：空
 * @param bool $cache 可选;是否缓存;默认：true
 * @param string $status 可选;数据状态;默认：normal
 * @return mixed 查询结果(obj|null)
 */
function cmsGetName($value='', $cache=true, $status='normal')
{
    if (!$value) {
        return null;
    }
    return cmsGet([
        'cache'  => $cache,
        'status' => $status,
        'name'   => $value,
    ]);
}

/**
 * 按ID快速获取上一篇文章列表
 * @version 1.2.4 首次引入
 * @param int $id 必需;Id值；默认：空
 * @return mixed 查询结果(obj|null)
 */
function cmsPrev($id=1, $limit=1)
{
    return cmsSelect(['status'=>'normal','limit'=>$limit,'id'=>['lt',$id],'sort'=>'info_id','order'=>'desc']);
}

/**
 * 按ID快速获取下一篇文章列表
 * @version 1.2.4 首次引入
 * @param int $id 必需;Id值；默认：空
 * @return mixed 查询结果(obj|null)
 */
function cmsNext($id=1, $limit=1)
{
    return cmsSelect(['status'=>'normal','limit'=>$limit,'id'=>['gt',$id],'sort'=>'info_id','order'=>'asc']);
}

/**
 * 数据修改器（表单处理）
 * @version 1.2.4 首次引入
 * @param array $post 必需;数组格式,支持的字段列表请参考手册;默认:空
 * @param bool $autoSave 可选;当分类与标签不存在时是否自动新增;默认:false
 * @return array 处理后的数据
 */
function cmsDataSet($post=[], $autoSave=false){
    //属性处理
    if(in_array('top', $post['cms_attr'])){
        $post['cms_top'] = 1;
    }
    if(in_array('recommend', $post['cms_attr'])){
        $post['cms_recommend'] = 1;
    }
    if(in_array('head', $post['cms_attr'])){
        $post['cms_head'] = 1;
    }
    if(in_array('fast', $post['cms_attr'])){
        $post['cms_fast'] = 1;
    }
    //置顶处理
    if($post['cms_top']){
        $post['info_order'] = DcEmpty($post['info_order'],999);
    }
    //分类处理（category_name、category_id可自动合并）
    $post['term_id'] = [];
    if($post['category_id']){
        $post['term_id'] = DcArrayArgs($post['category_id'], $post['term_id']);
    }
    if($post['category_name']){
        $post['term_id'] = DcArrayArgs(cmsCategoryAuto($post['category_name'], $autoSave), $post['term_id']);
    }
    /*未分类
    if(!$post['term_id']){
        $post['term_id'] = ['1'];
    }*/
    //标签处理（tag_name、tag_id可自动合并）
    if($post['tag_id']){
        $post['term_id'] = DcArrayArgs($post['tag_id'], $post['term_id']);
    }
    if($post['tag_name']){
        $post['term_id'] = DcArrayArgs(cmsTagAuto($post['tag_name'], $autoSave), $post['term_id']);
    }
    //摘要截取
    if(!$post['info_excerpt']){
       $post['info_excerpt'] = cmsSubstr($post['info_content'], 0, 140, true);
    }
    //别名处理
    if(config('cms.slug_first') && !$post['info_slug']){
        $post['info_slug'] = \daicuo\Pinyin::get($post['info_name'], true);
    }
    //首字母
    if(!$post['cms_letter']){
        $post['cms_letter'] = substr($post['info_slug'], 0, 1);
    }
    //去除不需要的字段
    unset($post['cms_attr']);
    unset($post['category_name']);
    unset($post['category_id']);
    unset($post['tag_name']);
    unset($post['tag_id']);
    //返回结果
    return DcArrayArgs($post,[
        'cms_top'       => 0,
        'cms_recommend' => 0,
        'cms_head'      => 0,
        'cms_fast'      => 0,
    ]);
}

/**
 * 数据获取器
 * @version 1.2.4 首次引入
 * @param array $data 必需;数组格式,支持的字段列表请参考手册;默认:空
 * @return array 处理后的数据
 */
function cmsDataGet($data=[]){
    if($data){
       $data['cms_attr'] = cmsAttrValue($data); 
    }
    return $data;
}

/**
 * 按条件获取多个网站分类
 * @version 1.0.0 首次引入
 * @param array $args 必需;查询条件数组格式 {
 *     @type bool $cache 可选;是否缓存;默认：true
 *     @type int $limit 可选;分页大小;默认：0
 *     @type int $page 可选;当前分页;默认：0
 *     @type string $sort 可选;排序字段名;默认：op_order
 *     @type string $order 可选;排序方式(asc|desc);默认：asc
 *     @type string $status 可选;显示状态（normal|hidden）;默认：空
 *     @type string $module 可选;模型名称;默认：空
 *     @type string $result 可选;模型名称;默认：空
 *     @type array $where 可选;自定义高级查询条件;默认：空
 *     @type array $paginate 可选;自定义高级分页参数;默认：空
 * }
 * @return mixed 查询结果obj|null
 */
function cmsCategorySelect($args=[])
{
    return model('common/Term','loglic')->select( DcArrayArgs($args,[
        'cache'    => true,
        'result'   => 'array',
        'controll' => 'category',
        'module'   => 'cms',
    ]) );
}

/**
 * 按ID快速获取分类信息
 * @version 1.0.0 首次引入
 * @param int $value 必需;Id值;默认：空
 * @param bool $cache 可选;是否缓存;默认：true
 * @param string $status 可选;数据状态;默认：normal
 * @return mixed 查询结果(array|null)
 */
function cmsCategoryId($value='', $cache=true, $status='normal')
{
    $args = [
        'module'   => 'cms',
        'controll' => 'category',
        'cache'    => $cache,
        'status'   => $status,
        'id'       => $value,
    ];
    return model('common/Term','loglic')->get($args);
}

/**
 * 按别名快速获取分类信息
 * @version 1.0.0 首次引入
 * @param string $value 必需;别名值;默认：空
 * @param bool $cache 可选;是否缓存;默认：true
 * @param string $status 可选;数据状态;默认：normal
 * @return mixed 查询结果(array|null)
 */
function cmsCategorySlug($value='', $cache=true, $status='normal')
{
    $args = [
        'module'   => 'cms',
        'controll' => 'category',
        'cache'    => $cache,
        'status'   => $status,
        'slug'     => $value,
    ];
    return model('common/Term','loglic')->get($args);
}

/**
 * 按分类名称快速获取分类信息
 * @version 1.0.0 首次引入
 * @param string $value 必需;分类名称;默认：空
 * @param bool $cache 可选;是否缓存;默认：true
 * @param string $status 可选;数据状态;默认：normal
 * @return mixed 查询结果(array|null)
 */
function cmsCategoryName($value='', $cache=true, $status='normal')
{
    $args = [
        'module'   => 'cms',
        'controll' => 'category',
        'cache'    => $cache,
        'status'   => $status,
        'name'     => $value,
    ];
    return model('common/Term','loglic')->get($args);
}

/**
 * 通过分类名获取分类ID（每个应用）
 * @version 1.2.11 首次引入
 * @param mixed $tagName 必需;标签名;默认：空
 * @param bool $autoSave可选;是否自动新增;默认：false
 * @return array 查询结果
 */
function cmsCategoryAuto($name=[], $autoSave=false){
    return model('common/Term','loglic')->nameToId($name, 'cms', 'category', $autoSave);
}

/**
 * 按条件获取多个标签信息
 * @version 1.0.0 首次引入
 * @param array $args 必需;查询条件数组格式 {
 *     @type bool $cache 可选;是否缓存;默认：true
 *     @type int $limit 可选;分页大小;默认：0
 *     @type int $page 可选;当前分页;默认：0
 *     @type string $sort 可选;排序字段名;默认：op_order
 *     @type string $order 可选;排序方式(asc|desc);默认：asc
 *     @type string $status 可选;显示状态（normal|hidden）;默认：空
 *     @type string $module 可选;模型名称;默认：空
 *     @type string $result 可选;模型名称;默认：空
 *     @type array $where 可选;自定义高级查询条件;默认：空
 *     @type array $paginate 可选;自定义高级分页参数;默认：空
 * }
 * @return mixed 查询结果obj|null
 */
function cmsTagSelect($args=[])
{
    return model('common/Term','loglic')->select( DcArrayArgs($args,[
        'cache'    => true,
        'result'   => 'array',
        'controll' => 'tag',
        'module'   => 'cms',
    ]) );
}

/**
 * 按ID快速获取标签信息
 * @version 1.0.0 首次引入
 * @param int $value 必需;Id值;默认：空
 * @param bool $cache 可选;是否缓存;默认：true
 * @param string $status 可选;数据状态;默认：normal
 * @return mixed 查询结果(array|null)
 */
function cmsTagId($value='', $cache=true, $status='normal')
{
    $args = [
        'module'   => 'cms',
        'controll' => 'tag',
        'cache'    => $cache,
        'status'   => $status,
        'id'       => $value,
    ];
    return model('common/Term','loglic')->get($args);;
}

/**
 * 按别名快速获取标签信息
 * @version 1.0.0 首次引入
 * @param string $value 必需;别名值;默认：空
 * @param bool $cache 可选;是否缓存;默认：true
 * @param string $status 可选;数据状态;默认：normal
 * @return mixed 查询结果(array|null)
 */
function cmsTagSlug($value='', $cache=true, $status='normal')
{
    $args = [
        'module'   => 'cms',
        'controll' => 'tag',
        'cache'    => $cache,
        'status'   => $status,
        'slug'     => $value,
    ];
    return model('common/Term','loglic')->get($args);
}

/**
 * 按名称快速获取标签信息
 * @version 1.0.0 首次引入
 * @param string $value 必需;分类名称;默认：空
 * @param bool $cache 可选;是否缓存;默认：true
 * @param string $status 可选;数据状态;默认：normal
 * @return mixed 查询结果(array|null)
 */
function cmsTagName($value='', $cache=true, $status='normal')
{
    $args = [
        'module'   => 'cms',
        'controll' => 'category',
        'cache'    => $cache,
        'status'   => $status,
        'name'     => $value,
    ];
    return model('common/Term','loglic')->get($args);
}

/**
 * 快速获取多个热门标签列表的某一个字段
 * @version 1.0.0 首次引入
 * @param int $limit 必需;数量限制；默认：10
 * @param string $field 可选;返回字段;默认：term_name
 * @return mixed 查询结果(array|null)
 */
function cmsTags($limit=10, $field='term_name')
{
    return array_column(cmsTagSelect([
        'status'=> 'normal',
        'limit' => $limit,
        'sort'  => 'term_count desc,term_id',
        'order' => 'desc',
    ]), $field);
}

/**
 * 通过标签名获取标签ID(所有应用共用一个标签)
 * @version 1.2.11 首次引入
 * @param mixed $tagName 必需;标签名;默认：空
 * @param bool $autoSave可选;是否自动新增;默认：false
 * @return array 查询结果
 */
function cmsTagAuto($name=[], $autoSave=false){
    return model('common/Term','loglic')->nameToId($name, 'cms', 'tag', $autoSave);
}

/**
 * 按条件获取导航菜单列表
 * @version 1.1.0 首次引入
 * @param array $args 必需;查询条件数组格式 {
 *     @type bool $cache 可选;是否缓存;默认：true
 *     @type string $result 可选;返回状态(array|tree|level);默认：tree
 *     @type string $status 可选;显示状态（normal|hidden）;默认：空
 *     @type string $module 可选;模型名称;默认：空
 *     @type string $controll 可选;控制器名称;默认：空
 *     @type string $action 可选;操作名称(navbar|navs);默认：空
 *     @type int $limit 可选;分页大小;默认：0
 *     @type string $sort 可选;排序字段名;默认：op_order
 *     @type string $order 可选;排序方式(asc|desc);默认：asc
 *     @type array $where 可选;自定义高级查询条件;默认：空
 * }
 * @return mixed 查询结果obj|null
 */
function cmsNavsSelect($args=[])
{
    return model('common/Navs','loglic')->select($args);
}

/**
 * 文章属性选项（checkOption）
 * @version 1.0.0 首次引入
 * @return array 处理后的数据
 */
function cmsAttrOption(){
    return [
        'top'       => lang('cms_attr_top'),
        'recommend' => lang('cms_attr_recommend'),
        'head'      => lang('cms_attr_head'),
        'fast'      => lang('cms_attr_fast'),
    ];
}

/**
 * 文章属性值转化为(checkValue)
 * @version 1.0.0 首次引入
 * @param array $data 必需;查询的数据;默认:空
 * @return array 处理后的数据
 */
function cmsAttrValue($data=[]){
    $value = [];
    $attrKeys = array_keys(cmsAttrOption());
    foreach($attrKeys as $key=>$field){
        if($data['cms_'.$field]){
           array_push($value,$field); 
        }
    }
    return $value;
}

/**
 * 文章内型选项
 * @version 1.2.22 优化
 * @version 1.0.0 首次引入
 * @return array 处理后的数据
 */
function cmsTypeOption(){
    //折分扩展属性;
    $types = [];
    foreach(explode(',',config('cms.type_option')) as $value){
        if($value){
            list($key, $lang) = explode('=>', $value);
            $types[$key] = DcEmpty($lang, 'cms_type_'.$key);
        }
    }
    //合并初始值
    $types = DcArrayArgs($types, [
        'index' => lang('cms_type_index'),
        'image' => lang('cms_type_image'),
        'album' => lang('cms_type_album'),
        'video' => lang('cms_type_video'),
        'auido' => lang('cms_type_auido'),
        'link'  => lang('cms_type_link'),
    ]);
    //返回数据
    return $types;
}

/**
 * 获取文章模型所有字段
 * @version 1.2.18 优化获取扩展字段
 * @version 1.1.0 首次引入
 * @return mixed 成功时返回array,失败时null
 */
function cmsFields()
{
    $fields = array_keys(DcFields('info'));
    $fieldsMeta = cmsMetaKeys('detail',NULL);
    if(is_array($fields) && is_array($fieldsMeta)){
        return array_merge($fields, $fieldsMeta);
    }
    return null;
}

/**
 * 提取HTML代码的图片地址
 * @version 1.0.0 首次引入
 * @param string $content 必需;待提取的正文内容HTML;空
 * @param string $result 可选;array|first|last;默认:array
 * @return mixed array|string 数组或链接
 */
function cmsImagePreg($content='',$result='array')
{
    //有后缀
    /*$preg="/<img.*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png|\.jpeg|\.?]))[\'|\"].*?[\/]?>/";*/
    $preg = '/(src)=([\"|\']?)([^ \"\'>]+\.(gif|jpg|jpeg|bmp|png|webp))\\2/i';
    preg_match_all($preg, $content, $match);
    $images = $match[3];
    //无后缀
    if(!$images){
        preg_match_all('/<img.*?src=[\'|\"](.*?)[\'|\"].*?[\/]?>/', $content, $match);
        $images = $match[1];
    }
    //返回结果
    if($result == 'first'){
        return current($images);
    }elseif($result == 'last'){
        return end($images);
    }else{
        return $images;
    }
}

/**
 * 格式化标题颜色
 * @version 1.0.0 首次引入
 * @param string $color 必需;规定时间戳的格式;空
 * @param string $default 可选;默认颜色值;text-dark
 * @return string 格式化后颜色class伪类
 */
function cmsColor($color, $default='text-dark')
{
    return DcEmpty($color, $default);
}

/**
 * 对日期或时间进行格式化
 * @version 1.0.0 首次引入
 * @param string $format 必需;规定时间戳的格式;空
 * @param mixed $timestamp 可选;规定时间戳;空
 * @return string 格式化后的时间
 */
function cmsDate($format='Y-m-d', $timestamp='')
{
    if(!is_numeric($timestamp)){
        $timestamp = strtotime($timestamp);
    }
    return date($format, $timestamp);
}

/**
 * 替换全站搜索引擎关键字
 * @version 1.0.0 首次引入
 * @param string $route 必需;包含待替换的关键字;空
 * @param string $page 可选;页码;空
 * @return string 过滤后的文本
 */
function cmsSeo($string='', $page=0)
{
    if(!$string){
        return '欢迎使用呆错文章管理系统（DaiCuoCms）';
    }
    $page = DcEmpty($page, input('param.pageNumber/d',1) );
    $search = ['[siteName]', '[siteDomain]', '[pageNumber]'];
    $replace = [config('common.site_name'), config('common.site_domain'), $page];
    return str_replace($search, $replace, cmsTrim($string));
}

/**
 * 内容模型基础字段计数增加
 * @version 1.0.0 首次引入
 * @param int $id 必需;ID值;默认:空
 * @param string $field 必需;字段值;默认:info_views
 * @param int $numb 可选;步进值;默认:1
 * @param int $time 可选;延迟更新;默认:0
 * @return int 最新值
 */
function cmsInfoInc($id=0, $field='info_views', $num=1, $time=0){
    if(!$id){
        return 0;
    }
    return dbUpdateInc('common/Info', ['info_id'=>['eq',$id]], $field, $num, $time);
}

/**
 * 内容模型扩展字段计数增加
 * @version 1.2.14 首次引入
 * @param int $id 必需;ID值;默认:空
 * @param string $field 必需;字段值;默认:info_views
 * @param int $numb 可选;步进值;默认:1
 * @param int $time 可选;延迟更新;默认:0
 * @return int 最新值
 */
function cmsMetaInc($id=0, $field='cms_up', $num=1, $time=0){
    if(!$id){
        return 0;
    }
    return dbUpdateInc('common/infoMeta', ['info_id'=>['eq',$id],'info_meta_key'=>['eq',$field]], 'info_meta_value', $num, $time);
}

/**
 * 字符串截取
 * @version 1.0.0 首次引入
 * @param string $string 必需;待截取的字符串
 * @param int $start 必需;起始位置;默认：0
 * @param int $length 必需;截取长度;默认：420
 * @param bool $suffix 可选;超出长度是否以...显示;默认：true
 * @param string $charset 可选;字符编码;默认：utf-8
 * @return string $string 截取后的字符串
 */
function cmsSubstr($string, $start=0, $length=420, $suffix=true, $charset="UTF-8"){
    $string = strip_tags(htmlspecialchars_decode(cmsTrim($string)));
    return htmlspecialchars(DcSubstr($string, $start, $length, $suffix, $charset));
}

/**
 * 过滤连续空白
 * @version 1.0.0 首次引入
 * @param string $str 待过滤的字符串
 * @return string 处理后的字符串
 */
function cmsTrim($str=''){
    $str = str_replace("　",' ',str_replace("&nbsp;",' ',trim($str)));
    $str = preg_replace('#\s+#', ' ', $str);
    return $str;
}

/**
 * 生成站内链接
 * @version 1.1.0 首次引入
 * @param string $url 必需;调用地址
 * @param string|array $vars 可选;调用参数，支持字符串和数组;默认：空
 * @return string $string 站内链接
 */
function cmsUrl($url='', $vars=''){
    return DcUrl($url, $vars);
}

/**
 * 获取分类页内部链接
 * @version 1.2.6 优化
 * @version 1.0.0 首次引入
 * @param array $info 必需;[id,name,slug]；默认:空
 * @param mixed $pageNumber 可选;int|[PAGE];默认:空
 * @return string 生成的内部网址链接
 */
function cmsUrlCategory($info=[], $pageNumber='')
{
    $route = config('cms.rewrite_category');
    $args = [];
    if( preg_match('/:slug|<slug/i',$route) ){
        $args['slug'] = $info['term_slug'];
    }elseif( preg_match('/:name|<name/i',$route) ){
        $args['name'] = $info['term_name'];
    }else{
        $args['id'] = $info['term_id'];
    }
    if($pageNumber){
        $args['pageNumber'] = $pageNumber;
    }
    return DcUrl('cms/category/index', $args);
}

/**
 * 获取标签页内部链接
 * @version 1.2.6 优化
 * @version 1.0.0 首次引入
 * @param array $info 必需;[id,name,slug]；默认:空
 * @param mixed $pageNumber 可选;int|[PAGE];默认:空
 * @return string 生成的内部网址链接
 */
function cmsUrlTag($info=[], $pageNumber='')
{
    //伪静态规则
    $route = config('cms.rewrite_tag');
    //URL链接参数
    $args  = [];
    if( preg_match('/:slug|<slug/i',$route) ){
        $args['slug'] = $info['term_slug'];
    }elseif( preg_match('/:name|<name/i',$route) ){
        $args['name'] = $info['term_name'];
    }else{
        $args['id'] = $info['term_id'];
    }
    //分页参数
    if($pageNumber){
        $args['pageNumber'] = $pageNumber;
    }
    return DcUrl('cms/tag/index', DcArrayEmpty($args));
}

/**
 * CMS结构搜索页内部链接
 * @version 1.2.6 优化
 * @version 1.0.0 首次引入
 * @param array $args 可选;['searchText','pageNumber','pageSize','sortName','sortOrder'];默认:空
 * @param string $module 可选;模块名;默认:cms
 * @param string $action 可选;操作名;默认:index
 * @return string 生成的内部网址链接
 */
function cmsUrlSearch($args=[], $action='index')
{
    $args  = DcArrayFilter($args,['searchText','pageNumber']);
    
    return DcUrl('cms/search/'.$action, $args);
}

/**
 * 获取筛选页链接
 * @version 1.2.6 首次引入
 * @param array $args 必需;[id,name,slug]；默认:空
 * @param mixed $pageNumber 可选;int|[PAGE];默认:空
 * @return string 生成的内部网址链接
 */
function cmsUrlFilter($args=[])
{
    return DcUrl('cms/filter/index', $args);
}

/**
 * 获取详情页内部链接
 * @version 1.2.6 优化
 * @version 1.0.0 首次引入
 * @param array $info 必需;[id,name,slug]；默认：空
 * @param mixed $pageNumber 可选;int|[PAGE];默认:空
 * @return string 生成的内部网址链接
 */
function cmsUrlDetail($info=[], $pageNumber='')
{
    $route = config('cms.rewrite_detail');
    $args = [];
    //必要参数
    if( preg_match('/:slug|<slug/i',$route) ){
        $args['slug'] = $info['info_slug'];
    }elseif( preg_match('/:name|<name/i',$route) ){
        $args['name'] = $info['info_name'];
    }else{
        $args['id'] = $info['info_id'];
    }
    //分类参数
    if( preg_match('/:termSlug|<termSlug/i',$route) ){
        $args['termSlug'] = $info['category_slug'][0];
    }
    if( preg_match('/:termId|<termId/i',$route) ){
        $args['termId'] = $info['category_id'][0];
    }
    if( preg_match('/:termName|<termName/i',$route) ){
        $args['termName'] = $info['category_name'][0];
    }
    return DcUrl('cms/detail/index', $args);
}

/**
 * 获取图片附件链接
 * @version 1.0.0 首次引入
 * @param string $file 必需;图片传件路径;默认：空
 * @param string $root 可选;根目录;默认：/
 * @param string $default 可选;默认图片地址;默认：x.gif
 * @return string 无图片时返回默认横向图
 */
function cmsUrlImage($file='', $root='/', $default='public/images/x.gif')
{
    return DcEmpty(DcUrlAttachment($file), $root.$default);
}

/**
 * 格式化分页大小
 * @version 1.2.7 首次引入
 * @param string $pageSize 必需;每页大小;默认：10
 * @param string $page 可选;当前分页;默认：1
 * @return intval 页码值
 */
function cmsPageSize($pageSize=10)
{
    $pageSize = intval( DcEmpty($pageSize,config('cms.limit_default')) );
    if($pageSize > 0 && $pageSize < 1001){
        return $pageSize;
    }
    return 10;
}

/**
 * 验证请求是否合法（防CC、假墙功能）
 * @version 1.2.7 首次引入
 * @param string $ip 必需;客户端IP;默认：127.0.0.1
 * @param string $agent 必需;浏览器头;默认：default
 * @return bool true|false
 */
function cmsRequestCheck($ip='127.0.0.1', $agent='default'){
    //后台验证开关
    $configMax = intval(config('cms.request_max'));
    if($configMax < 1){
        return true;
    }
    //客户端唯一标识
    $client = md5($ip.$agent);
    //60秒内最大请求次数
    $requestMax = intval(DcCache('request'.$client));
    if($requestMax > $configMax){
        return false;
    }
    DcCache('request'.$client, $requestMax+1, 60);
    //未超出限制
    return true;
}

/**
 * 表格筛选选项处理
 * @version 1.3.3 首次引入
 * @return array 处理后的数据
 */
function cmsDataOption($options=[]){
    return array_merge([0=>'---'],$options);
}

/**
 * 排序字段格式化
 * @version 1.2.0 首次引入
 * @param string $sortName 必需;排序字段；默认:空
 * @param string $sortDefault 必需;默认字段；默认:info_update_time
 * @return string 生成合法的排序字段
 */
function cmsSortName($sortName='',$sortDefault='info_update_time')
{
    if( in_array($sortName,['cms_up','cms_down','info_id','info_order','info_views','info_hits','info_create_time','info_update_time']) ){
        return $sortName;
    }
    return $sortDefault;
}

/**
 * 排序方式格式化
 * @version 1.2.0 首次引入
 * @param string $sortName 必需;排序字段；默认:空
 * @param string $sortDefault 必需;默认字段；默认:desc
 * @return string 生成合法的排序字段
 */
function cmsSortOrder($sortOrder='',$sortDefault='desc')
{
    if( in_array($sortOrder,['desc','asc']) ){
        return $sortOrder;
    }
    return $sortDefault;
}

/**
 * 获取文章模型的所有扩展字段（初始扩展+自定义扩展）
 * @version 1.2.17 首次引入
 * @return array 文章模型的扩展字段
 */
function cmsMetaFields(){
    //解析自定义字段
    $plus = array_keys( json_decode(config('cms.info_meta'),true) );
    //文章初始扩展字段
    return DcArrayArgs($plus, config('cms.meta_detail'));
}

/**
 * 根据地址栏参数的扩展字段生成多条件查询参数
 * @version 1.2.19 首次引入
 * @param array $query 必需;地址栏请求参数;默认：空
 * @return array 适用于模型查询函数的meta_query选项
 */
function cmsMetaQuery($query=[]){
    if($query['cms_attr'] == 'top'){
        $query['cms_top'] = 1;
    }elseif($query['cms_attr'] == 'recommend'){
        $query['cms_recommend'] = 1;
    }elseif($query['cms_attr'] == 'head'){
        $query['cms_head'] = 1;
    }elseif($query['cms_attr'] == 'fast'){
        $query['cms_fast'] = 1;
    }
    return DcMetaQuery(cmsMetaList('detail',NULL), $query);
}

/**
 * 只获取模块的所有动态扩展字段KEY
 * @version 1.3.1 首次引入
 * @param string $controll 可选;控制器；默认:category
 * @param string $action 可选;操作名；默认:system
 * @return array 二维数组
 */
function cmsMetaKeys($controll='detail', $action='index')
{
    $args = [];
    $args['module']   = 'cms';
    $args['controll'] = $controll;
    $args['action']   = $action;
    $keys = model('common/Field','loglic')->forms(DcArrayEmpty($args),'keys');
    return array_unique($keys);
}

/**
 * 获取模块的所有动态扩展字段列表
 * @version 1.3.1 首次引入
 * @param string $controll 可选;控制器；默认:category
 * @param string $action 可选;操作名；默认:system
 * @return array 二维数组
 */
function cmsMetaList($controll='detail', $action='index')
{
    $args = [];
    $args['module']   = 'cms';
    $args['controll'] = $controll;
    $args['action']   = $action;
    return model('common/Field','loglic')->forms( DcArrayEmpty($args) );
}

/**
 * 文章内容图片解析
 * @version 1.3.1 首次引入
 * @param string $content 必需;正文内容；默认:空
 * @param bool $isAttr 可选;是否只返回附件；默认:false
 * @return mixed string|array
 */
function cmsEditor($content='', $isAttr=false)
{
    $content = DcEditor($content);
    //只匹配图片
    //preg_match_all('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i', $content, $matches);
    //匹配附件（图片+文件）
    $ext = str_replace(',','|',config('common.upload_file_ext'));
    $ext = DcEmpty($ext,'gif|jpg|jpeg|bmp|png|webp|svg|zip|rar|7z');
    preg_match_all("/(href|src)=([\"|']?)([^ \"'>]+\.($ext))\\2/i", $content, $matches);
    //替换规则
    $search  = $matches[3];
    $replace = [];
    foreach($search as $key=>$value){
        $replace[$key] = DcUrlAttachment($value);
        if(!$value){
            unset($search[$key]);
            unset($replace[$key]);
        }
    }
    //是否只返回图片
    if($isAttr){
        return $replace;
    }
    //替换正文
    return str_replace($search, $replace, $content);
}