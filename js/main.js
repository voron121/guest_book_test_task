function clearForm() {
    $('input[name=uname]').val("");
    $('input[name=uemail]').val("");
    $('textarea[name=umessage]').val("");
}

function showMessage(message, status) {
    cssClass = " alert-success";
    if ("error" === status) {
        cssClass = " alert-error";
    }
    message = '<div class="alert '+cssClass+'"> ' + message + ' </div>';
    $(".info_message").html(message);
}


function writePost() {
	uname    	= $('input[name=uname]').val();
    uemail   	= $('input[name=uemail]').val();
    umessage 	= $('textarea[name=umessage]').val();
    $.ajax({
        url: "ajax/ajax.php",
        type: "post",
        dataType: "json",
        data: { 
            "uname"     : uname,
            "uemail"    : uemail,
            "umessage"  : umessage
        },
        success : function(response) {
            showMessage(response.message, response.status);
            if ("success" === response.status) {
                clearForm();
            }
        }
    });  
}

$( document ).ready(function() {
    $(".edite_message").on("click", function() {
        edite_form = "edite_form_" + $(this).attr("id");
        $("#" + edite_form).show();
    });
});
 