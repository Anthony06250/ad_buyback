<section class="ad-bb-message p-0 {($direction === 'true') ? 'message-success' : 'message-info' }">
    <header class="ad-bb-message-header d-flex justify-content-between">
        <h6 class="m-0">
            {if $message['id_customer']}
                {$message['customer_name']}
            {elseif $message['id_employee']}
                {$message['employee_name']}
            {else}
                {$message['default_name']}
            {/if}
        </h6>
    </header>
    <article class="ad-bb-message-content p-1 {($direction === 'true') ? 'border-top-success' : 'border-top-info' }">
        {$message['message']|nl2br nofilter}
    </article>
    <footer class="ad-bb-message-footer d-flex justify-content-between {($direction === 'true') ? 'border-top-success' : 'border-top-info' }">
        <small class="align-middle">
            <i class="material-icons md-12">timer</i>
            {dateFormat date=$message['date_add'] full=1}
        </small>
        <small>
            {if $message['date_add'] != $message['date_upd']}
                ({l s='Edited on : %date_upd%' sprintf=['%date_upd%' => {dateFormat date=$message['date_upd'] full=1}] d='Modules.Adbuyback.Front'})
            {/if}
        </small>
    </footer>
</section>
