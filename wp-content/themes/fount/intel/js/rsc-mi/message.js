var oMessage = {

    init : function(){

    },

    builtMessagePopup : function(id, email, report_id){

        tinymce.init({
            selector: "textarea#message",
            toolbar1: "cut copy paste | undo redo | bold italic",
            toolbar2: "alignleft aligncenter alignright alignjustify | numlist outdent indent",
            menubar: false,
            width : 280,
            height : 110
        });

        //   $('#send_message').resetForm();
        $('#reviewer-email').val(email);
        $('#report_id').val(report_id);
        $('#send-message-modal').modal('show');

    },


    hideMessagePopup : function(){
        $('#send-message-modal').modal('hide');
    },

    sendMessage : function (){
        //var a = tinyMCE.activeEditor.getContent({format : 'raw'})

        var message = tinyMCE.get('message').getContent();

        var url = SCRIPT_PATH + "?action=sendMessageEmail";

        var fields = {'subject':$('#subject').val(), 'message': message, 'email':$('#reviewer-email').val(), 'reportId':$('#report_id').val()};

        $.post(url, fields,  function(response){
            if(response.success){
                $('#send-message-modal').modal('hide');
            }else{
                console.log(response.error);
                //Todo: Display some error
            }
        }, 'json');

    }


};