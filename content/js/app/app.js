
function App() { 
  
}

/**
 * Wrapper for Ajax function
 */
App.post = function(url, params, success, failure) {
  $.ajax({
    url: url,
    type: 'POST',
    dataType: 'json',
    data: params,
    success: success,
    failure: failure
  });
}

App.uniqid = function(size) {
  function getRandomNumber(range) {
    return Math.floor(Math.random() * range);
  }
  
  function getRandomChar() {
    var chars = "0123456789abcdefghijklmnopqurstuvwxyzABCDEFGHIJKLMNOPQURSTUVWXYZ";
    return chars.substr( getRandomNumber(62), 1 );
  }
  
  var str = "";
  
  for(var i = 0; i < size; i++) {
    str += getRandomChar();
  }
  
  return str
}

App.Modal = function() {
  
}

App.Modal.open = function(content_div_id, timeout) {
  console.log(content_div_id);
  
  var overlay = $("<div id='lean_overlay'></div>");

  $("body").append(overlay);

  $("#lean_overlay").click(function() { 
    App.Modal.close(content_div_id);                    
  });
  
  App.Modal.center(content_div_id);

  $('#lean_overlay').css({
    'display' : 'block', 
    opacity : 0
  });

  $('#lean_overlay').fadeTo(200, 0.5);
  
  $(content_div_id).addClass('active_modal');

  $(content_div_id).fadeTo(200,1);
}

App.Modal.center = function(modal_id) {
  var modal_height = $(modal_id).outerHeight();
  var modal_width = $(modal_id).outerWidth();
  
  $(modal_id).css({ 
    'display' : 'block',
    'position' : 'fixed',
    'opacity' : 0,
    'z-index': 11000,
    'left' : 50 + '%',
    'margin-left' : -(modal_width/2) + "px",
    'top' : 50 + "px"
  });
}

App.Modal.close = function(modal_id) {
  if(!modal_id) {
    modal_id = $(".active_modal").attr('id');
  }
  
  modal_id = modal_id.replace("#", "");
  
  console.log(modal_id);
  
  $("#lean_overlay").hide();

  $("#" + modal_id).css({
    'display' : 'none'
  });
  
  $("#" + modal_id).removeClass('active_modal');
  
  $("#" + modal_id).remove();
}

App.askFor = function(message, title, callback) {
  var div = $("<div>");
  var id = App.uniqid(10);
  
  $(div).attr('id', id);
  $(div).addClass('modal');
  
  $(div).append(
    $("<h2>").html(message).attr('class', 'ask_message')
  );
    
  $(div).append(
    $("<label>").html(title).attr('class', 'ask_title')
  );
    
  $(div).append(
    $("<input>").attr('type', 'text').attr('class', 'ask_input')
  );
    
  $(div).append(
    $("<button>").attr('class', 'ask_button')
		 .text('Submit')
		 .button()
		 .click(function() {
      var response = $("#" + id + " input.ask_input").val();
      
      if(callback(response, id)) {
	App.Modal.close(id);
      }
    })
  );
    
  $(div).css('display', 'none');
  
  console.log(div);
    
  $("body").append(div);
    
  App.Modal.open("#" + id);
}