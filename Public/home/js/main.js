$(function(){
  initializePage();
  $('.carousel').bind('move', function(event){
    if(Math.abs(event.deltaX)<10){
      return;
    }
    if(event.deltaX>0){
      $(this).carousel('prev');
    }
    if(event.deltaX<0){
      $(this).carousel('next');
    }
  });



  $('.ui-abox >a').click(function(){
    $('body').removeClass('on-mask');
    $('.ui-abox').hide();
    return false;
  });

  $('.ui-role >a').click(function(){
    $('body').removeClass('on-mask');
    $('.ui-role').hide();
    return false;
  });
  
  
  

});

/*---------------method---------------*/
//