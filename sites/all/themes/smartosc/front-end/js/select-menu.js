(function($){
    $.fn.select_menu = function(parameters_class, show_all) {
        var $this_select = $(this),
            $class_arg = parameters_class;

        // HTML UL for Select
        var $wrapper         = $('<div class="style-'+$class_arg+'"/>'),
            $wrap_menu       = $('<div class="'+$class_arg+'"/>'),
            $menu_select     = $('<ul class="list-'+$class_arg+'"/>'),
            $label_select    = $('<div class="select-label"/>'),
            $text_selected   = '<div class="label-type">'+$this_select.find(":selected").text()+'</div>';


        $label_select.prepend($text_selected);

        $this_select.wrap($wrapper).after($wrap_menu);
        $wrap_menu.prepend($label_select);
        $wrap_menu.append($menu_select);

        var list_html = [];
        $.each($this_select.find("option"),function (key, value) {
            var $this_option = $(this),
                $this_li = $("<li/>");

                $value_text = (key==0) ? show_all : $this_option.text();

                //menu_select.append('<li value="' + $this_option.val() + '">' + $this_option.text() + '</li>');
                $this_option.prop("selected") && $this_li.addClass("selected activated"),
                $this_option.val() && $this_li.attr("data-value", $this_option.val()),
                list_html.push($this_li.text($value_text).get(0).outerHTML)
        })
        $menu_select.html(list_html.join(""));

        // Click UL change Select
        $menu_select.on('click', 'li', function() {
            return $this_select.val($(this).data("value")), $this_select.trigger("change"),$this_select.trigger("blur");
        })
        // Click UL show Select
        $label_select.on('click',function() {
            $this_select.trigger("focus");
            $label_select.addClass("open");
            $menu_select.addClass("open");
        })
        //focusout
        $this_select.on('blur', function() {
            $label_select.removeClass("open");
            $menu_select.removeClass("open");
        });
        // Press Keyboard
        $this_select.on('keydown',function(e) {
            var keyCode     = e.which,
                li_active   = $menu_select.find(".activated");

            if ($menu_select.hasClass("open")) {
                if(keyCode == 38){
                    //key up
                    li_active.removeClass("activated");
                    if (li_active.index()>0)
                        li_active.prev().addClass("activated");
                    else
                        $menu_select.find("li:last-child").addClass("activated");
                }else if(keyCode == 40){
                    //key down
                    li_active.removeClass("activated");
                    if(li_active.index() < ($menu_select.find("li").length - 1))
                        li_active.next().addClass("activated");
                    else
                        $menu_select.find("li:first-child").addClass("activated");
                }else if(keyCode == 27){
                    //key esc
                    $this_select.trigger("blur");
                }else if(keyCode == 13 || keyCode == 32){
                    // key enter or space
                    li_active.trigger("click");
                }else if(keyCode == 9){
                    // key tabs
                    if($label_select.hasClass("open"))
                        $this_select.trigger("blur");
                }
                e.preventDefault();
            }
        });
    };

    // Running JQuery scripts on AJAX loaded content
    $(document).bind('ready ajaxComplete', function(){
        var $wrapper_content = $('.work-filter-gird'),
            $default_text = ($('.label-all', $wrapper_content).length > 0) ? $('.label-all', $wrapper_content).text() : "all";

        if ($('select',$wrapper_content).length > 0) {
            $wrapper_content.find('select').each(function () {
                if ($(this).closest('.style-select-menu').length < 1) {
                    $(this).select_menu("select-menu", $default_text);
                }
            })
        }
    })

})(jQuery);