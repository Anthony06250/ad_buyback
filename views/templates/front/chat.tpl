{extends file='page.tpl'}

{block name='page_title'}
    <header class="page-header">
        <h1>
            {l s='Chat ID: %chatId%' sprintf=['%chatId%' => $chat['id_ad_buyback_chat']] d='Modules.Adbuyback.Front'}
        </h1>
    </header>
{/block}

{block name='page_content'}
    <article class="ad-bb-front-chat card container p-0">
        <form id="ad-buyback-front-message-form" name="{$form.options.id}" action="{$form.options.action}" method="{$form.options.method}"
              {if $form.options.multipart}enctype="multipart/form-data"{/if}
        >
            {include file='modules/ad_buyback/views/templates/front/_parts/chat/chat.tpl'}
            {if $chat['active']}
                <input type="hidden" name="id_ad_buyback_chat" value="{$chat['id_ad_buyback_chat']}">
                <input type="hidden" name="id_customer" value="{$customer.id}">
                <input type="hidden" name="active" value="1">
                {$form.fields.message.label = null}
                {include file='modules/ad_buyback/views/templates/front/_parts/form/textarea.tpl' field=$form.fields.message}
                {form_field field=$form.fields._token}
            {/if}
            <footer class="card-footer p-0">
                <section class="ad-bb-front-chat-footer d-flex justify-content-between">
                    <span>
                        {if $customer['id']}
                            <a href="{$link->getModuleLink('ad_buyback', 'buyback', ['buybackId' => $chat['id_ad_buyback']])}"
                               class="btn btn-secondary btn-sm"
                            >
                                {l s='Return' d='Modules.Adbuyback.Front'}
                            </a>
                        {/if}
                    </span>
                    <span>
                        {if $chat['active']}
                            <button name="ad-buyback-front-message-form" class="btn btn-primary btn-sm" type="submit">
                                {l s='Send message' d='Modules.Adbuyback.Front'}
                            </button>
                        {/if}
                    </span>
                </section>
            </footer>
        </form>
    </article>
{/block}

{block name='page_footer'}
    {block name='my_account_links'}
        {include file='customer/_partials/my-account-links.tpl'}
    {/block}
{/block}
