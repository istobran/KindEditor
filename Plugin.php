<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * KindEditor 4.1.10 For Typecho
 *
 * @package KindEditor
 * @author Wanan
 * @version 4.1.10
 * @link Http://WwW.SbPHP.CoM/
 */
class KindEditor_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     *
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        Typecho_Plugin::factory('Widget_Archive')->header = array('KindEditor_Plugin', 'header');
        Typecho_Plugin::factory('admin/write-post.php')->richEditor = array('KindEditor_Plugin', 'render');
        Typecho_Plugin::factory('admin/write-page.php')->richEditor = array('KindEditor_Plugin', 'render');

        //去除段落
        Typecho_Plugin::factory('Widget_Contents_Post_Edit')->write = array('KindEditor_Plugin', 'filter');
        Typecho_Plugin::factory('Widget_Contents_Page_Edit')->write = array('KindEditor_Plugin', 'filter');
    }

    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     *
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate(){}

    /**
     * 获取插件配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form){}

    /**
     * 个人用户的配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}

    /**
     * 头部样式
     *
     * @access public
     * @param unknown $header
     * @return unknown
     */
    public static function header() {
        $options = Helper::options();
        $url=Typecho_Common::url('KindEditor/kindeditor', $options->pluginUrl);
echo <<<EOF
<link rel="stylesheet" type="text/css" href="{$url}/plugins/code/shCoreDefault.css" />
<script type="text/javascript" src="{$url}/plugins/code/shCore.js"></script>
<script>SyntaxHighlighter.all()</script>
EOF;
    }
    /**
     * 去除段落
     *
     * @access public
     * @param array $post 数据结构体
     * @return array
     */
    public static function filter($posts)
    {
        // file_put_contents('12.txt',$post);  换换位置
        $post['text'] = str_replace("\n", '', $post['text']);
        $post['text'] = str_replace("&lt;!--more--&gt;", '<!--more-->', $post['text']);
        file_put_contents('12.txt',$post);
        return $post;
    }

    /**
     * 插件实现方法
     *
     * @access public
     * @return void
     */
    public static function render()
    {
        $options = Helper::options();
        echo '<link rel="stylesheet" href="'.Typecho_Common::url('KindEditor/kindeditor', $options->pluginUrl).'/themes/default/default.css" />
        <script charset="utf-8" src="'.Typecho_Common::url('KindEditor/kindeditor', $options->pluginUrl).'/kindeditor-min.js"></script>
        <script charset="utf-8" src="'.Typecho_Common::url('KindEditor/kindeditor', $options->pluginUrl).'/lang/zh_CN.js"></script>
        <script type="text/javascript">var editor;
            KindEditor.ready(function(K) {
                editor = K.create(\'textarea[name="text"]\', {
                    allowFileManager : true,
                    themeType : "simple",
                });

            });</script>';
    }
}
