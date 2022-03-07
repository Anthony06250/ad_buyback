<section class="form-group row">
    <label class="col-md-3 form-control-label {if $field.required}required{/if}" for="field-{$field.name}">
        {$field.label}
    </label>
    <article class="col-md-6">
        <div class="form-select">
            <section class="input-group">
                <input id="input-{$field.name}" class="form-control" type="text" readonly
                       {if isset($field.attr.placeholder)}placeholder="{$field.attr.placeholder}"{/if}
                >
                <div class="input-group-btn">
                    <label class="btn btn-primary m-0" for="field-{$field.name}" style="height: 100%">
                        {l s='Browse' d='Shop.Forms.Labels'}
                    </label>
                    <input id="field-{$field.name}" name="{$field.name}[]" type="{$field.type}" hidden
                           data-multiple-files-text="{l s='%count% file(s)' d='Shop.Forms.Labels'}"
                           {if isset($field.attr.multiple)}multiple="multiple"{/if}
                    >
                </div>
            </section>
        </div>
    </article>
    <footer class="col-md-3 form-control-comment"></footer>
</section>
