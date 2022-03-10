<aside class="ad-bb-front-chat-infos d-flex align-items-center">
    <article>
        <i class="material-icons md-18">timer</i>
        <span class="align-middle">
            {dateFormat date=$chat['date_upd'] full=1}
        </span>
    </article>
    <article class="ml-2">
        <span class="badge {($chat['active']) ? 'badge-success' : 'badge-danger'}">
            {($chat['active'])
            ? {l s='Active' d='Modules.Adbuyback.Front'}
            : {l s='Inactive' d='Modules.Adbuyback.Front'}}
        </span>
    </article>
</aside>
