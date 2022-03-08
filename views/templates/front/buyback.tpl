{extends file='page.tpl'}

{block name='page_title'}
    <header class="page-header">
        <h1>
            {l s='Buyback' d='Modules.Adbuyback.Front'}
        </h1>
    </header>
{/block}

{block name='page_content'}
    <section id="accordion">
        {foreach from=$buybacks item=buyback}
            <section class="ad-bb-front-buyback card">
                <header class="card-header" id="header-{$buyback['id_ad_buyback']}"
                        data-toggle="collapse" data-target="#collapse-{$buyback['id_ad_buyback']}"
                        aria-expanded="{($buyback['id_ad_buyback'] === $buybacks[0]['id_ad_buyback'])|var_export:true}"
                        aria-controls="collapse-{$buyback['id_ad_buyback']}"
                >
                    <section class="d-flex justify-content-between">
                        <h5 class="card-header-title m-0">
                            <i class="material-icons md-18">transform</i>
                            <span class="align-middle">
                                {l s='Buyback ID : %buybackId%' sprintf=['%buybackId%' => $buyback['id_ad_buyback']] d='Modules.Adbuyback.Front'}
                            </span>
                        </h5>
                        {include file='modules/ad_buyback/views/templates/front/_parts/buyback/buyback_infos.tpl'}
                    </section>
                </header>
                <article id="collapse-{$buyback['id_ad_buyback']}" data-parent="#accordion"
                         class="collapse {if $buyback['id_ad_buyback'] === $buybacks[0]['id_ad_buyback']}in{/if}"
                         aria-labelledby="header-{$buyback['id_ad_buyback']}"
                >
                    <section class="card-body p-1">
                        {if isset($buyback.chats)}
                            {foreach from=$buyback.chats item=chat}
                                <article class="ad-bb-front-chat card container p-0">
                                    {include file='modules/ad_buyback/views/templates/front/_parts/chat/chat.tpl'}
                                    <footer class="card-footer p-0">
                                        <section class="ad-bb-front-chat-footer d-flex justify-content-end">
                                            <a href="{$link->getModuleLink('ad_buyback', 'chat', ['chatId' => $chat['id_ad_buyback_chat']])}"
                                               class="btn btn-primary btn-sm"
                                            >
                                                {l s='View chat' d='Modules.Adbuyback.Front'}
                                            </a>
                                        </section>
                                    </footer>
                                </article>
                            {/foreach}
                        {/if}
                    </section>
                </article>
            </section>
        {/foreach}
    </section>
{/block}

{block name='page_footer'}
    {block name='my_account_links'}
        {include file='customer/_partials/my-account-links.tpl'}
    {/block}
{/block}
