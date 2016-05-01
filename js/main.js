var countMessage = 0;
var currentMessageCount = 0;
var defaultTitle = 'Chatroulette';
var toggleTitle = false;
var newMessage = 0;
var currentNewMessage = 0;

var audioElementFb = document.createElement('audio');
audioElementFb.setAttribute('src', 'mp3/notif_fb.mp3');

var audioSendMessage = document.createElement('audio');
audioSendMessage.setAttribute('src', 'mp3/notif.mp3');
audioSendMessage.volume = 0.1;

$(document).ready(function(){

    scrollToBottom();
    saveName();
	setDelete();
    setInterval(updateChat, 1000);


    // Add message on Send button
    $('.submit-message').on('click',function(){
        var input = document.getElementById("file");
        file = input.files[0];
        if(file != undefined){
            uploadFile();
        }
        else{
            var text = $('.text').val();
            if(text!=''){
                save();
            }
        }
    });

    // Add message on Enter keypress
    $(document).keypress(function(e) {
        if(e.which == 13) {
            var text = $('.text').val();
        	if(text!=''){
        		save();
        	}
        }
    });


    // Delete all messages
    $('.reset').on('click',function(){
    	if (confirm('Are you sure you want to delete all messages ?')) {
    		$.ajax({
    		    url: 'inc/delete_all.php',
    		    dataType: 'html',
    		    success: function(data) {
    		        $('.list-message').remove();
    		    }
    		});
	    }
    });
});

function setDelete(){
	$('.message').on('mouseenter',function(){
		$(this).children('.delete').show();
	});
	$('.message').on('mouseleave',function(){
		$(this).children('.delete').hide();
	});

    // Delete message on click of x
    $('.delete').on('click',function(){
    	var spanId = $(this).attr('id');
    	messageId = spanId.replace('message-','');
        $('#message-' + messageId).parent().remove();
    	$.ajax({
    	    url: 'inc/delete.php',
    	    dataType: 'html',
    	    method: 'post',
    	    data: { 'id':messageId },
    	    success: function(data) {
                // success
    	    }
    	});
	    
    });
}


function saveName() {
    Cookies.remove('name');
    var person = prompt("Please enter your name");
    if (person == null || person=='') {
        person = 'Anonymous';
    }
    Cookies.set('name', person);
    $('.text').focus();
}

function scrollToBottom(){
    $(".chat-box").animate({ scrollTop: $(".chat-box")[0].scrollHeight}, 1000);
}

function uploadFile(){
  var input = document.getElementById("file");
  var name = Cookies.get('name');

  file = input.files[0];
  if(file != undefined){
    formData= new FormData();
    if(!!file.type.match(/image.*/)){
      formData.append("image", file);
      formData.append("name", name);

      $.ajax({
        url: "inc/upload.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(data){
            $('#file').val('');
            scrollToBottom();
        }
      });
    }else{
      alert('Not a valid image!');
    }
  }else{
    alert('Input something!');
  }
}

function save(){
    var text = $('.text').val();
    var name = Cookies.get('name');

    $.ajax({
        url: 'inc/save.php',
        dataType: 'html',
        method: 'post',
        data: { 'text':text,'name':name },
        success: function(data) {
            $('.text').val('');
            audioSendMessage.play();
            scrollToBottom();
        }
    });
}

function updateChat(){
    $.ajax({
        url: 'inc/updated.php',
        dataType: 'html',
        success: function(response) {
            $('.chat-box').html(response);
            setDelete();
        }
    });

    if (document.hasFocus()) {
        countMessage = getCount(false);
        currentMessageCount  = countMessage;
        document.title = defaultTitle;
    }
    else{
        currentMessageCount = countMessage;
        getCount(true);
    }
}

function getCount(away){
    count = countMessage;
    $.ajax({
        url: 'inc/count.php',
        dataType: 'html',
        async: false,
        success: function(response) {
            if(response>currentMessageCount && away==true){

                newMessage = response-currentMessageCount;
                name = getLastMessage();

                if(toggleTitle){
                    var newTitle = '(' + newMessage + ') ' + defaultTitle;
                    toggleTitle = false;
                }
                else{
                    var newTitle = '(' + newMessage + ') ' + name;
                    toggleTitle = true;
                }
                document.title = newTitle;

                // Play notification sound only if new message
                if(currentNewMessage!=newMessage){
                    audioElementFb.play();
                    currentNewMessage = newMessage;
                }
            }
            count = response;
        }
    });
    return count;
}

function getLastMessage(){
    var name = '';
    $.ajax({
        url: 'inc/last.php',
        dataType: 'html',
        async: false,
        success: function(response) {
            name = response;
        }
    });
    return name;
}