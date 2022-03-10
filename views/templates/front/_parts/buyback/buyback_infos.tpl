<aside class="ad-bb-front-buyback-infos d-flex align-items-center">
    <article>
        <i class="material-icons md-18">timer</i>
        <span class="align-middle">
            {dateFormat date=$buyback['date_add'] full=1}
        </span>
    </article>
    <article class="ml-2">
        <span class="badge {($buyback['active']) ? 'badge-success' : 'badge-danger'}">
            {($buyback['active'])
            ? {l s='Active' d='Modules.Adbuyback.Front'}
            : {l s='Inactive' d='Modules.Adbuyback.Front'}}
        </span>
    </article>
</aside>
