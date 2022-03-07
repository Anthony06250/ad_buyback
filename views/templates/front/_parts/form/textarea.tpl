<section class="form-group row">
    {if $field.label}
        <label class="col-md-3 form-control-label {if $field.required}required{/if}" for="field-{$field.name}">
            {$field.label}
        </label>
    {/if}
    <article class="{($field.label) ? 'col-md-6' : 'col-md-12'}">
        <div class="form-select {if !$field.label}pl-1 pr-1{/if}">
            <textarea
                id="field-{$field.name}" name="{$field.name}" class="form-control"
                {if isset($field.attr.rows)}rows="{$field.attr.rows}"{/if}
                {if isset($field.attr.placeholder)}placeholder="{$field.attr.placeholder}"{/if}
            ></textarea>
        </div>
    </article>
    {if $field.label}
        <footer class="col-md-3 form-control-comment"></footer>
    {/if}
</section>
