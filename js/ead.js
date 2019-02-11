jQuery(window).load( function($) {
  var toc = jQuery('.ead-toc');
  var content = toc.next();
  var tocheader = toc.find('.toc-header');

  var resizeFunc = function() {
                var tocposx = toc.position().left;
                var contentposx = content.position().left;
                if (contentposx != tocposx) {
                        // toc is next to content
                        var contentheight = content.height();
                        toc.find('.toc-content').css({'max-height': contentheight+'px'});
                }
                else {
                        toc.find('.toc-content').css({'max-height': ''});
                }
        };
        resizeFunc();
        jQuery(window).on('resize', resizeFunc);

  var tochwidth = tocheader.width();
  var contentwidth = content.width();
  var toggleToc = function(e) {
    if (toc.hasClass('aside')) {
                        tocheader.animate({width: tochwidth + 'px'}, function() {
                                 tocheader.css('width', '');
                                 jQuery('#closetoc').one("click", toggleToc);
                        });
                        content.animate({width: contentwidth + 'px'}, function() {
                                content.css('width', '');
                        });
      setTimeout(function() {
        toc.removeClass('aside').addClass('expanding');
        setTimeout(function() {
          toc.removeClass('expanding');
        }, 500);
      }, 100);
    }
    else if (jQuery(this).is('#closetoc')) {
      var tocposx = toc.position().left;
      var contentposx = content.position().left;
                        toc.addClass('aside');
      if (contentposx != tocposx) {
                                tochwidth = tocheader.width();
                                contentwidth = content.width();
                                setTimeout(function() {
                                  var contentheight = content.height();
                                        tocheader.animate({width: contentheight + 'px'}, function() {
                                                 tocheader.one("click", toggleToc);
                                        });
                                        content.animate({width: "95%"});
                                }, 100);
                        }
                        else {
                          setTimeout(function() {
                            tocheader.one("click", toggleToc);
                          }, 400);
                        }
    }
    e.preventDefault();
  };
  jQuery('#closetoc').one("click", toggleToc);

  jQuery('.ead-whole A[href]').each(function(i, e) {
    var hash = jQuery(e).attr('href');
    if (hash.length > 1 && hash.lastIndexOf('#', 0) === 0) { // attr starts with #
      jQuery(e).click(function(event) {
        var $scrollBox = content.find('#divMain');
        var $thisAtTop = $scrollBox.find(hash + ', [id="' + hash.substring(1) + '"]');
        if ($thisAtTop.size() > 0) {
          $scrollBox.scrollTop(0); // reset scrolltop
          var coffset = content.offset();
          var tatoffset = $thisAtTop.offset();
          var currentScrollTop = $scrollBox.scrollTop();
          var newScrollTop = tatoffset.top - coffset.top - 40;
          $scrollBox.scrollTop(newScrollTop);
          event.preventDefault();
        }
      });
    }
  });
});
