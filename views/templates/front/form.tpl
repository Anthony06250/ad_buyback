{extends file='page.tpl'}

{block name='page_title'}
    <header class="page-header">
        <h1>
            {l s='Send buy back form' d='Modules.Advideoblock.Front'}
        </h1>
    </header>
{/block}

{block name='page_content'}
    <form name="{$form.options.id}" action="{$form.options.action}" method="{$form.options.method}"
          {if $form.options.multipart}enctype="multipart/form-data"{/if}
    >
        {foreach from=$form.fields item=field}
            {* Modification of the classic theme file : themes/classic/templates/_partials/form-fields.tpl *}
            {form_field field=$field}
        {/foreach}
        <footer class="form-footer text-sm-center clearfix">
            <button id="submit" class="btn btn-primary" type="submit">
                {l s='Send buy back form' d='Modules.Advideoblock.Front'}
            </button>
        </footer>
    </form>
{/block}
