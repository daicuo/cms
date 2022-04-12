<?php
//http://htmlpurifier.org/docs/enduser-customize.html
/**
 * 安全输出Ckeditor编辑器
 * @version 1.0.0 首次引入
 * @param string $string 待过滤的字符串
 * @return string 处理后的字符串
 */
function ckeditorParse($string=''){
    // 手动加载
    require_once './apps/ckeditor/vendor/htmlpurifier/HTMLPurifier.auto.php';
    // 创建配置对象
    $cfg = HTMLPurifier_Config::createDefault();
    // 设置编码
    $cfg->set('Core.Encoding', 'UTF-8');
    // 设置允许使用的HTML标签
    $cfg->set('HTML.Allowed', 'div,h1,h2,h3,h4,h5,table,td,th,tr,dl,dd,dt,font,u,p,b,strong,small,i,em,sub,sup,center,pre,code,a[href|title|id|name|class|data-url],ul,ol,li,br,hr,s,span[style],img[width|height|alt|src|id|class]');//embed,video,source,audio,
    // 设置允许出现的CSS样式属性
    $cfg->set('CSS.AllowedProperties', 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align'); 
    // 让文本自动添加段落标签
    $cfg->set('AutoFormat.AutoParagraph', true);
    // 清除空标签
    $cfg->set('AutoFormat.RemoveEmpty', true);
    // 设置a标签上是否允许使用target="_blank"
    $cfg->set('HTML.TargetBlank', true);
    //$cfg->set('Attr.AllowedFrameTargets', array('_blank', '_self', '_parent', '_top'));
    //自定义属性
    $def = $cfg->getHTMLDefinition(true);
    $def->addAttribute('a', 'data-url', 'Text');
    // 使用配置生成过滤用的对象
    $obj = new HTMLPurifier($cfg);
    // 过滤字符串
    return $obj->purify( ckeditorTrim($string) );
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
function ckeditorSubstr($string, $start=0, $length=420, $suffix=true, $charset="UTF-8"){
    $string = htmlspecialchars(ckeditorTrim($string));
    return DcSubstr($string, $start, $length, $suffix, $charset);
}

/**
 * 过滤连续空白
 * @version 1.0.0 首次引入
 * @param string $str 待过滤的字符串
 * @return string 处理后的字符串
 */
function ckeditorTrim($str=''){
    $str = str_replace("　",' ',str_replace("&nbsp;",' ',trim($str)));
    $str = preg_replace('#\s+#', ' ', $str);
    return $str;
}