 
(function($) {
 $(".js-example-tags").select2({
   tags: true
  });

   $(function() {
      //Here you add the bottom pixels you need. I added 200px.
      $('.select2-selection__rendered').css({top:'200px',position:'relative'});
   });
   })(jQuery);