<div id="email-export" title="Send to Email" class="hide">
    <p class="validateTips">
        <?php echo __('Please provide email addresses you would like to send this report to‭ (‬use commas to send to multiple‭) .'); ?>
    </p>
    <form>
        <fieldset>
            <label for="from_email">From Email Address</label>
            <input type="text" id="from_email" name="from" value="" class="from text ui-widget-content ui-corner-all" />

            <label for="reply_email">Send to</label>
            <input type="text" id="reply_email" name="reply" value="" class="reply text ui-widget-content ui-corner-all" />
        </fieldset>
    </form>
</div>