<script type="text/x-tmpl" id="tmpl-notification">
<div class="row">
    <span class="title">{%=o.content%}</span>
    <div class="buttons">
        <span style="margin-right: 10px" data-ref-id="{%=o.id%}" data-ref-type="{%=o.type%}" data-ref-value="1">Yes</span>
        <span data-ref-id="{%=o.id%}" data-ref-type="{%=o.type%}" data-ref-value="0">No</span>
    </div>
    <span class="time">{%=o.create_time%}</span>
</div>
</script>
<script type="text/x-tmpl" id="tmpl-message">
<div class="row">
    <span class="title">{%=o.content%}</span>
    <span class="time">{%=o.create_time%}</span>
</div>
</script>