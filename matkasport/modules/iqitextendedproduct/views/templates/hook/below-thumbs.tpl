{*
* 2017 IQIT-COMMERCE.COM
*
* NOTICE OF LICENSE
*
* This file is licenced under the Software License Agreement.
* With the purchase or the installation of the software in your application
* you accept the licence agreement
*
* @author    IQIT-COMMERCE.COM <support@iqit-commerce.com>
* @copyright 2017 IQIT-COMMERCE.COM
* @license   Commercial license (You can not resell or redistribute this software.)
*
*}

{if isset($productVideoContent) && $productVideoContent}
    {foreach $productVideoContent as $video}
        <a href="#" class="btn btn-secondary mr-1 ml-1 video_thumb" data-button-action="open-iqitvideos" type="button" data-toggle="modal"
                data-target="#iqit-iqitvideos-modal">
            <div class="video_icon">
                <i class="fa fa-play icon_play"></i>
                <img src="http://img.youtube.com/vi/{$video.id}/hqdefault.jpg">
            </div>
        </a>
    {/foreach}

    <div class="modal fade js-iqit-iqitvideos-modal" id="iqit-iqitvideos-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title">{l s='Videos' mod='iqitextendedproduct'}</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {foreach $productVideoContent as $video}
                    <div class="modal-body">
                        <div id="iqitvideos-block" class="iqitvideos-block">
                            <div class="iqitvideo">
                                <iframe class="iframe" width="100%" height="300" src="//www.youtube.com/embed/{$video.id}?rel=0&showinfo=0"></iframe>
                            </div>
                        </div>
                    </div>
                {/foreach}
            </div>
        </div>
    </div>
{/if}

{if isset($isThreeSixtyContent) && $isThreeSixtyContent}
    <button class="btn btn-secondary mr-1 ml-1" data-button-action="open-iqitthreesixty" type="button" data-toggle="modal"
            data-target="#iqit-threesixty-modal">
        <i class="fa fa-arrows-h"></i> {l s='360 view' mod='iqitextendedproduct'}
    </button>
    <div class="modal fade js-iqit-threesixty-modal" id="iqit-threesixty-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title">{l s='Drag or swipe on image' mod='iqitextendedproduct'}</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="iqit-threesixty" data-threesixty="{$threeSixtyContent nofilter}"><i class="fa fa-circle-o-notch fa-spin fa-2x "></i></div>
                </div>
            </div>
        </div>
    </div>
{/if}






