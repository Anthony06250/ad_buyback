{extends file='page.tpl'}

{block name='page_title'}
    <header class="page-header">
        <h1>
            {l s='Buyback form' d='Modules.Adbuyback.Front'}
        </h1>
    </header>
{/block}

{block name='page_content'}
    <form id="ad-buyback-front-form" name="{$form.options.id}" action="{$form.options.action}" method="{$form.options.method}"
          {if $form.options.multipart}enctype="multipart/form-data"{/if}
    >
        {foreach from=$form.fields item=field}
            {if $field.type === 'choice'}
                {$field['value'] = $customer.gender.id}
                {$field['readonly'] = ($customer.gender.id)}
                {include file='modules/ad_buyback/views/templates/front/_parts/form/choices.tpl'}
            {elseif $field.type === 'textarea'}
                {include file='modules/ad_buyback/views/templates/front/_parts/form/textarea.tpl'}
            {elseif $field.type === 'file'}
                {include file='modules/ad_buyback/views/templates/front/_parts/form/file.tpl'}
            {elseif  $field.type === 'text' or  $field.type === 'email'}
                {if $field['id']|strpos: 'firstname'}
                    {$field['value'] = $customer.firstname}
                    {$field['readonly'] = ($customer.firstname)}
                {elseif $field['id']|strpos: 'lastname'}
                    {$field['value'] = $customer.lastname}
                    {$field['readonly'] = ($customer.lastname)}
                {elseif $field['id']|strpos: 'email'}
                    {$field['value'] = $customer.email}
                    {$field['readonly'] = ($customer.email)}
                {/if}
                {include file='modules/ad_buyback/views/templates/front/_parts/form/input.tpl'}
            {else}
                {if $field['id']|strpos: 'id_customer'}
                    {$field['value'] = $customer.id}
                {/if}
                {form_field field=$field}
            {/if}
        {/foreach}
        <footer class="form-footer text-sm-center clearfix">
            <button name="ad-buyback-front-form" class=" btn btn-primary" type="submit">
                {l s='Send buyback form' d='Modules.Adbuyback.Front'}
            </button>
        </footer>
    </form>
{/block}
