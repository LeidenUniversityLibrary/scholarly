var cbpHorizontalMenu = (function($) {

	var a, b, c, d, e, f, g,h;

	function f() {
		b = $("#cbp-hrmenu > ul > li");
		g = $('#cbp-hrmenu > ul > li').children("a.cbp-placeholder");
		c = $("body");
		d = -1;

		g.bind("click", a);
		b.bind("click", function(h) {
			h.stopPropagation()
		})

	}
	function a(j) {
		if (d !== -1) {
			b.eq(d).removeClass("cbp-hropen")
		}
		i = $(j.currentTarget).parent("li");
		h = i.index();
		if (d === h) {
			i.removeClass("cbp-hropen");
			d = -1
		} else {
			i.addClass("cbp-hropen");
			d = h;
			c.unbind("click", e);
		}
		return false
	}
	function e(h) {
		b.eq(d).removeClass("cbp-hropen");
		d = -1
	}
	return {
		init : f
	}
})(jQuery);
