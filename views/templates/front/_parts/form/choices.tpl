<section class="form-group row">
    <label class="col-md-3 form-control-label {if $field.required}required{/if}" for="field-{$field.name}">
        {$field.label}
    </label>
    <article class="col-md-6">
        <div class="form-select">
            <select id="field-{$field.name}" name="{$field.name}"
                    class="form-control custom-select {if isset($field.readonly) and $field.readonly}readonly{/if}"
            >
                <option>
                    {$field.placeholder}
                </option>
                {foreach from=$field.choices item=choice}
                    <option value="{$choice->value}"
                        {if $choice->value == $field['value']}selected{/if}
                    >
                        {$choice->label}
                    </option>
                {/foreach}
            </select>
        </div>
    </article>
    <footer class="col-md-3 form-control-comment"></footer>
</section>
