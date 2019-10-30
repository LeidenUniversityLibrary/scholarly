(function ($, Drupal) {
  Drupal.behaviors.myModuleBehavior = {
    attach: function (context, settings) {
      $(document).ready(function() {
        //$('a.cbp-placeholder').next().slideToggle();
        $('a.cbp-placeholder').click(function(event) {
          event.preventDefault();
          $(this).next().css('height', 'auto').slideToggle();
          $(this).toggleClass('toggled');
        });

        var shouldCollapse = false;
        $('a.cbp-placeholder').each(function () {
          if (!shouldCollapse) {
            shouldCollapse = ($(this).next().find('LI.leaf').size() > 5);
          }
        });
        if (shouldCollapse) {
          $('a.cbp-placeholder').each(function () {
            shouldCollapse = ($(this).next().find('LI.leaf.active').size() === 0);
            if (shouldCollapse) {
              $(this).next().css('height', 'auto').slideToggle(0.0);
              $(this).toggleClass('toggled');
            }
          });
        }

        $(".cbp-hrsub").each(function () {

          //$(this).prev();
          // open up the content needed - toggle the slide- if visible, slide up, if not slidedown.
          //$(this).slideToggle(500, function () {
            // execute this after slideToggle is done
            // change text of header based on visibility of content div

            // change text based on condition
            if ($(this).is(":visible")) {
              $(this).addClass("visible").removeClass("hidden");
            }
            else {
              $(this).addClass("hidden").removeClass("visible");
            }
          //});
        });


      });
    }
  };
})(jQuery, Drupal);


