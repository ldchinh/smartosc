(function ($) {

    // Overide Drupal.ajax.prototype.commands.insert in misc/ajax.js.

    Drupal.ajax.prototype.commands.pagerViewFade = function (ajax, response, status) {
        // Get fade duration
        // var duration = response.settings.fade_duration;

        // Get information from the response. If it is not there, default to our presets.
        var wrapper = response.selector ? $(response.selector) : $(ajax.wrapper);
        var method = response.method || ajax.method;
        var effect = ajax.getEffect(response);
        // $(response.data) or $('<div></div>').replaceWith(response.data).
        var new_content_wrapped = $(response.data);
        var new_content = new_content_wrapped.contents();

        if (new_content.length != 1 || new_content.get(0).nodeType != 1) {
            new_content = new_content_wrapped;
        }

        // If removing content from the wrapper, detach behaviors first.
        switch (method) {
            case 'html':
            case 'replaceWith':
            case 'replaceAll':
            case 'empty':
            case 'remove':
                var settings = response.settings || ajax.settings || Drupal.settings;
                Drupal.detachBehaviors(wrapper, settings);
        }

        // Add the new content to the page.
        wrapper[method](new_content);

        // Immediately hide the new content if we're using any effects.
        if (effect.showEffect != 'show') {
            new_content.hide();
        }

        // Determine which effect to use and what content will receive the effect, then show the new content.
        if ($('.ajax-new-content', new_content).length > 0) {
            $('.ajax-new-content', new_content).hide();
            new_content.show();
            $('.ajax-new-content', new_content)[effect.showEffect](effect.showSpeed);
        }
        else if (effect.showEffect != 'show') {
            new_content[effect.showEffect](effect.showSpeed);
        }

        // Attach all JavaScript behaviors to the new content, if it was successfully added to the page, this if statement allows #ajax['wrapper'] to be optional.
        if (new_content.parents('html').length > 0) {
            // Apply any settings from the returned JSON if available.
            var settings = response.settings || ajax.settings || Drupal.settings;
            Drupal.attachBehaviors(new_content, settings);
        }

    };

})(jQuery);
