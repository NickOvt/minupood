<?php
/* Smarty version 3.1.32, created on 2018-08-13 15:04:55
  from 'module:iqitsocialloginviewstempl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5b7173e73436f3_26590330',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '61c5997c2183ea5ba1b537d10008fd4f75175c34' => 
    array (
      0 => 'module:iqitsocialloginviewstempl',
      1 => 1534151629,
      2 => 'module',
    ),
  ),
  'cache_lifetime' => 31536000,
),true)) {
function content_5b7173e73436f3_26590330 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->smarty->ext->_tplFunction->registerTplFunctions($_smarty_tpl, array (
));
?><!-- begin C:\xampp\htdocs\Prestashop/modules/iqitsociallogin/views/templates/hook/checkout.tpl -->
<script type="text/javascript">
    
    function iqitSocialPopup(url) {
        var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
        var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;
        var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;
        var left = ((width / 2) - (600 / 2)) + dualScreenLeft;
        var top = ((height / 2) - (600 / 2)) + dualScreenTop;
        var newWindow = window.open(url, '_blank', 'scrollbars=yes,top=' + top + ',left=' + left + ',width=600,height=600');
        if (window.focus) {
            newWindow.focus();
        }
    }
    
</script>




<!-- end C:\xampp\htdocs\Prestashop/modules/iqitsociallogin/views/templates/hook/checkout.tpl --><?php }
}
