<div id="wppe-metabox-wrapper" class="pure-form">
    <fieldset>
        <div class="pure-control-group wppe-terms-group">
            <label for="wppe-terms">Terms</label>
            <input id="wppe-terms" class="pure-input-1-2" type="text" autocomplete="off" placeholder="What terms to search?" required>
        </div>

        <div class="pure-control-group wppe-options-group">
            <label for="wppe-option-youtube" class="pure-checkbox">
                <input id="wppe-option-youtube" type="radio" name="wppe-option-group" value="youtube" checked>
                Youtube
            </label>
            <label for="wppe-option-google-search" class="pure-checkbox">
                <input id="wppe-option-google-search" type="radio" name="wppe-option-group" value="google-search">
                Google Search
            </label>
            <label for="wppe-option-twitter" class="pure-checkbox">
                <input id="wppe-option-twitter" type="radio" name="wppe-option-group" value="twitter">
                Twitter
            </label>
            <label for="wppe-option-word-metrics" class="pure-checkbox">
                <input id="wppe-option-word-metrics" type="radio" name="wppe-option-group" value="word-metrics">
                Word Metrics
            </label>
        </div>

        <p class="wppe-error-box"></p>

        <div class="pure-control-group">
            <a id="wppe-button-search" class="pure-button" href="">Search</a>
        </div>

        <div id="wppe-results-wrapper">
            <div id="wppe-loading"><image src="<?php echo $loadingImgUrl; ?>"></image></div>
            <div id="wppe-results"></div>
        </div>
    </fieldset>
</div>
