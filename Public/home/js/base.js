function initializePage(){
  bindOnResize();
  
}

/*---------------method---------------*/
//
function bindOnResize(){
  var resize=function(){
    var height=$(window).height();
    var width=$(window).width();
    $('.full-height').height(height);
    $('html').css('font-size', width/375*10+'px');
  }
  resize();
  $(window).resize(function(event) {
    resize();
  });
}