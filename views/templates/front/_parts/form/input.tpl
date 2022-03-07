<section class="form-group row">
    <label class="col-md-3 form-control-label {if $field.required}required{/if}" for="field-{$field.name}">
        {$field.label}
    </label>
    <article class="col-md-6">
        <div class="form-select">
            <input class="form-control" name="{$field.name}" type="{$field.type}" value="{$field.value}"
                   {if isset($field.attr.placeholder)}placeholder="{$field.attr.placeholder}" {/if}
                   {if isset($field.maxLength)}maxlength="{$field.maxLength}" {/if}
                   {if $field.required}required{/if}
                   {if isset($field.readonly) and $field.readonly}readonly{/if}
            >
        </div>
    </article>
    <footer class="col-md-3 form-control-comment"></footer>
</section>
