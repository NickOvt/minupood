<?php
/**
 * 2007-2015 IQIT-COMMERCE.COM
 *
 * NOTICE OF LICENSE
 *
 *  @author    IQIT-COMMERCE.COM <support@iqit-commerce.com>
 *  @copyright 2007-2015 IQIT-COMMERCE.COM
 *  @license   GNU General Public License version 2
 *
 * You can not resell or redistribute this software.
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_1_2_0($object)
{
    $newContent = '<div class="addthis_sharing_toolbox addthis_inline_share_toolbox addthis_inline_share_toolbox_slg1"></div>';
    Configuration::updateValue('addthisplugin_content', $newContent, true);
    $object->clearCache();
    return true;
}
