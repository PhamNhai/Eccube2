<?php /* Smarty version 2.6.26, created on 2018-10-24 15:35:33
         compiled from C:%5Cxampp%5Chtdocs%5Ceccube2%5Chtml/../data/Smarty/templates/default/footer.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'script_escape', 'C:\\xampp\\htdocs\\eccube2\\html/../data/Smarty/templates/default/footer.tpl', 28, false),array('modifier', 'date_format', 'C:\\xampp\\htdocs\\eccube2\\html/../data/Smarty/templates/default/footer.tpl', 28, false),array('modifier', 'default', 'C:\\xampp\\htdocs\\eccube2\\html/../data/Smarty/templates/default/footer.tpl', 29, false),array('modifier', 'h', 'C:\\xampp\\htdocs\\eccube2\\html/../data/Smarty/templates/default/footer.tpl', 29, false),)), $this); ?>

<!--▼FOOTER-->
<div id="footer_wrap">
    <div id="footer" class="clearfix">
        <div id="pagetop"><a href="#top">このページの先頭へ</a></div>
        <div id="copyright">Copyright ©
            <?php if (((is_array($_tmp=@RELEASE_YEAR)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) != ((is_array($_tmp=((is_array($_tmp=time())) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y") : smarty_modifier_date_format($_tmp, "%Y"))): ?><?php echo ((is_array($_tmp=@RELEASE_YEAR)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
-<?php endif; ?><?php echo ((is_array($_tmp=((is_array($_tmp=time())) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y") : smarty_modifier_date_format($_tmp, "%Y")); ?>

            <?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrSiteInfo']['shop_name_eng'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('default', true, $_tmp, ((is_array($_tmp=$this->_tpl_vars['arrSiteInfo']['shop_name'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))) : smarty_modifier_default($_tmp, ((is_array($_tmp=$this->_tpl_vars['arrSiteInfo']['shop_name'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
 All rights reserved.
        </div>
    </div>
</div>
<!--▲FOOTER-->