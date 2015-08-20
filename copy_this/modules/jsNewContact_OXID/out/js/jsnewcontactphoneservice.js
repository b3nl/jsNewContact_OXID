/**
 * ./modules/jsNewContact_OXID/out/js/jsnewcontactphoneservice.js
 * @author     Juliana Schuster <juliana.schuster@pixolith.de>
 * @category   modules
 * @package    jsNewContact_OXID
 * @subpackage out_js
 * @version    SVN: $Id$
 */

/**
 * Javascript file
 * @author     Juliana Schuster <juliana.schuster@pixolith.de>
 * @category   modules
 * @package    jsNewContact_OXID
 * @subpackage out_js
 * @version    SVN: $Id$
 */

$(function () {
    var dialog 	= null;
    var form 	= null;
    var stages 	= null;
    var xhr 	= null;

    var messages = $(document.querySelector("span.ajax_callback_messages"));
    messages =
    {
        spam  : messages.find("[data-on-ajax='spam_detected']"),
        good  : messages.find("[data-on-ajax='success_detected']"),
	error : messages.find("[data-on-ajax='communication_error']")
    };

    form = $("#dialog-form");

    dialog = form.dialog({
        autoOpen: false,
        height: 370,
        width: 565,
        modal: true,
        buttons: {
            Senden: function () {
                form.submit();
            },

            Schließen: function () {
                dialog.dialog("close");
            }
        }
    });

    stages = dialog.find("[js][data-stage]");
    console.log(stages);

    form.on("submit", function __on_submit(e) {
        if (document.Kontakt["editval[oxuser__oxfon]"].value == "") {
            document.Kontakt["editval[oxuser__oxfon]"].focus();
            return false;
        }
        if (document.Kontakt["editval[oxuser_oxfnameandlname]"].value == "") {
            document.Kontakt["editval[oxuser_oxfnameandlname]"].focus();
            return false;
        }

        document.getElementById("dialog-form").style.height = "158px";

        e.preventDefault();
        e.stopPropagation();

        var url = form.attr("action");
        var data = {};

        form.find("input").each(function (i, el) {
            var $el = $(el);
            data[$el.attr("name")] = $el.val();
        });

        Object.keys(messages).forEach(function (v) {
            messages[v].addClass("hidden");
        });

	stages.css("display", "none");
	form.find("[data-stage='send']").css("display", "block");

	form.parent().find("button").each(function (_, button) {
	    $(button).button("option", "disabled", true);
	});

        xhr = $.ajax({
            method: "POST",
            url: url,
            data: data
        })
            .done(function (r) {
                //dialog.dialog("close");
                
		var result = JSON.parse(r);

                if (result.success) {
                    messages.good.removeClass("hidden");
                }
                else {
                    if (result.spam) {
                        messages.spam.removeClass("hidden");
                    }
                }
            })

            .fail(function (r) {
		messages.error.removeClass("hidden");
            })

	    .always(function (r) {
		form.parent().find("button").each(function (_, button) {
		    $(button).button("option", "disabled", false);
		});

		$(form.parent().find("button")[0]).button("option", "disabled", true);

		stages.css("display", "none");
                form.find("[data-stage='exit']").css("display", "block");
	    });

        return false;
    });

    $(".ui-dialog-titlebar").removeClass("ui-corner-all");

    $("#jsPhone").button().on("click", function () {
	xhr && xhr.abort() && (xhr = null);

	form.parent().find("button").each(function (_, button) {
            $(button).button("option", "disabled", false);
        });

	stages.css("display", "none");
        form.find("[data-stage='prepare']").css("display", "block");	

        dialog.dialog("open");
    });
});