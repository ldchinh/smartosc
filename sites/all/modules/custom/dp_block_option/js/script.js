jQuery(document).ready(function($){
  $("[data-animate-type]").each(function(){
    var $this = $(this);
    if(("ontouchstart" in window || window.DocumentTouch && document instanceof DocumentTouch) != true){
        var animate_class = $this.data('animate-type');
        $this.appear(function(){
            $this.addClass(animate_class);
            $this.addClass('appear-animation-visible');
        },{accX: 0,accY: 0,one:false});
    }else{
        $this.addClass('appear-animation-visible');
    }
  });
})