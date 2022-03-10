<header class="card-header">
    <section class="d-flex justify-content-between">
        <h5 class="card-header-title m-0">
            <i class="material-icons md-18">sms</i>
            <span class="align-middle">
                {l s='Chat ID: %chatId%' sprintf=['%chatId%' => $chat['id_ad_buyback_chat']] d='Modules.Adbuyback.Front'}
            </span>
        </h5>
        {include file='modules/ad_buyback/views/templates/front/_parts/chat/chat_infos.tpl'}
    </section>
</header>
<article class="ad-bb-front-chat-content container">
    {if isset($chat['messages'])}
        {foreach from=$chat['messages'] item=message}
            {assign var='direction' value=($message['id_employee'] === '0')|var_export:true}
            <section class="row">
                {if $direction === 'true'}
                    <aside class="col-md-3"></aside>
                {/if}
                <article class="col-md-9 p-0">
                    {include file='modules/ad_buyback/views/templates/front/_parts/chat/message.tpl'}
                </article>
                {if $direction === 'false'}
                    <aside class="col-md-3"></aside>
                {/if}
            </section>
        {/foreach}
    {else}
        <article class="alert alert-warning mt-1" role="alert" data-alert="warning">
            <ul>
                <li>
                    {l s='No active message' d='Modules.Adbuyback.Front'}
                </li>
            </ul>
        </article>
    {/if}
</article>
