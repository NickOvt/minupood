{**
 * 2007-2017 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2017 PrestaShop SA
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}

{block name='product_tabs'}
    <div class="tabs product-tabs">
        <ul id="product-infos-tabs" class="nav nav-tabs">
            {if $product.description}
                <li class="nav-item">
   
                    <a class="nav-link{if $product.description} active{/if}" data-toggle="tab"
                       href="#description">
                        <i class="tent_icon"></i> 
                        {l s='Description' d='Shop.Theme.Catalog'}
                    </a>
                </li>
            {/if}
            {* <li class="nav-item">
                <a class="nav-link{if !$product.description} active{/if}" data-toggle="tab"
                   href="#product-details-tab">
                    {l s='Product Details' d='Shop.Theme.Catalog'}
                </a>
            </li> *}
            {* {if $product.attachments}
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#attachments">
                        {l s='Attachments' d='Shop.Theme.Catalog'}
                    </a>
                </li>
            {/if} *}

            {if $iqitTheme.pp_accesories == 'tab'}
                {if $accessories}
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#accessories-tab">
                            {l s='Related products' d='Shop.Theme.Catalog'}
                        </a>
                    </li>
                {/if}
            {/if}

            {if $iqitTheme.pp_man_desc}
            {if isset($product_manufacturer) && $product_manufacturer->description != ''}
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#brand-tab">
                        {l s='About' d='Shop.Warehousetheme'} {$product_manufacturer->name}
                    </a>
                </li>
            {/if}
            {/if}

            {foreach from=$product.extraContent item=extra key=extraKey}
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab"
                       href="#extra-{$extraKey}">
                        <i class="tent_icon"></i>    
                       {$extra.title}
                    </a>
                </li>
            {/foreach}
        </ul>

        <div id="product-infos-tabs-content"  class="tab-content">
            <div class="tab-pane in{if $product.description} active{/if}" id="description">
                {block name='product_description'}
                    <div class="product-description">
                        <h3>{l s='Product information' d='Shop.Theme.Catalog'}</h3>
                        <div class="rte-content">{$product.description nofilter}</div>
                        {hook h='displayProductElementor'}
                    </div>
                {/block}
                
                {* <div id="product-details" data-product="{$product.embedded_attributes|json_encode}">
                    <h3>{l s='Product specification' d='Shop.Theme.Catalog'}</h3> *}
                    {block name='product_details'}
                        {include file='catalog/_partials/product-details.tpl'}
                    {/block}
                {* </div> *}
            </div>

            {* <div class="tab-pane {if !$product.description} in active{/if}"
                 id="product-details-tab"
            >
                <div id="product-details"
                     data-product="{$product.embedded_attributes|json_encode}"
                >

                {block name='product_details'}
                    {include file='catalog/_partials/product-details.tpl'}
                {/block}
                </div>
            </div> *}

{* PRODUCT Attachments MOVED TO product-details.tpl !!!!!*}

            {if $iqitTheme.pp_accesories == 'tab'}
                {if $accessories}
                    <div class="tab-pane in" id="accessories-tab">
                        {block name='product_accessories_tab'}
                                <div class="products row products-grid">
                                    {foreach from=$accessories item="product_accessory"}
                                        {block name='product_miniature'}
                                            {include file='catalog/_partials/miniatures/product.tpl' product=$product_accessory}
                                        {/block}
                                    {/foreach}
                                </div>
                        {/block}
                    </div>
                {/if}
            {/if}

            {if $iqitTheme.pp_man_desc}
            {if isset($product_manufacturer) && $product_manufacturer->description != ''}
                 <div class="tab-pane in" id="brand-tab">
                        <div class="rte-content">
                            {$product_manufacturer->description nofilter}
                        </div>
                    </div>
            {/if}
            {/if}


            {foreach from=$product.extraContent item=extra key=extraKey}
            <div class="tab-pane  in {$extra.attr.class}"
                 id="extra-{$extraKey}" {foreach $extra.attr as $key => $val} {$key}="{$val}"{/foreach}
            >
            {$extra.content nofilter}
        </div>
        {/foreach}
    </div>
    </div>

    <div class="iqit-accordion" id="product-infos-accordion-mobile" role="tablist" aria-multiselectable="true"></div>
{/block}
