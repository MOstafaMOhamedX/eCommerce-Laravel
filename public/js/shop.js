$(function() {
    $('.material-card > .mc-btn-action').click(function () {
        var card = $(this).parent('.material-card');
        var icon = $(this).children('i');
        icon.addClass('fa-spin-fast');

        if (card.hasClass('mc-active')) {
            card.removeClass('mc-active');

            window.setTimeout(function() {
                icon
                    .removeClass('fa-arrow-left')
                    .removeClass('fa-spin-fast')
                    .addClass('fa-bars');

            }, 800);
        } else {
            card.addClass('mc-active');

            window.setTimeout(function() {
                icon
                    .removeClass('fa-bars')
                    .removeClass('fa-spin-fast')
                    .addClass('fa-arrow-left');

            }, 800);
        }
    });
});


//Show Hide based on selection form Returns
$(document).ready(function(){

    $("select").change(function(){
        if($(this).val() == 'All'){
         $(this).parent().addClass('is--all');
        } else{
         $(this).parent().removeClass('is--all');
        }
    }).change();
      
    $('.filter-bar').click(function() {
       $(this).toggleClass('is--toggled');
       $('.filters').toggleClass('is--open');
    });
      
    var elem = $('.filters__options');
      
    elem.scroll(function() {
       if(elem.scrollLeft() > 0) {
          $('.filters').addClass('is--scrolled');
       } else {
          $('.filters').removeClass('is--scrolled');
       }
    });
      
    });