//-----------------------------------------------------------------------------------
// Mods:    Konn Danley 
// Company: Bitseed
// File;    ui_functions.js 
// Date:    05/15/2016
// 
// Purpose: This is where the javascript cusomot functionss are located.  This file 
//          currently contains two functions:
//
//          1. A callback function thatfor restarting bitcoin, and shutting down the 
//             device. The call function performs AJAX calls to  jquery-ajax.php where 
//             the system  actions are taken. 
//          2. An anonymous function that provides the javascript responsible for
//             keeping the tooltip text within the disply.
//

function bitcoinControl(e) {
    var domvalue = $(e).attr('id');
    var r=false;
      switch (domvalue) {  
          case "bitcoin_restart":
              r = confirm("Are you sure you want to restart bitcoin?");
              break;
          case "update-software":
              r = confirm("Are you sure you want to update the bitcoin software?");
              break;
          case "device_shutdown":
              r = confirm("Are you sure you want to shutdown the device?"); 	
              break;
          case "bitcoin_restart_conf":
              r = confirm("Are you sure you want to restart bitcoin?");
              break;
       }
       if (r == false) {
           return;
       }
       var request = $.ajax({
           url: "php/jquery-ajax.php",
           type: "GET",
           dataType: "html",
           data: {
               id: domvalue
           },
       });

       request.done(function(msg) {
           $("#device_status").html(msg);
       });

       request.fail(function(jqXHR, textStatus) {
           alert( "Request failed: " + textStatus );
       });
};

// Tooltips - $( function() {}) is the same as $(document).ready() 

$( function()
{
    var targets = $( '[rel~=tooltip]' ),
        target  = false,
        tooltip = false,
        title   = false;
 
    targets.bind( 'mouseenter', function()
    {
        target  = $( this );
        tip     = target.attr( 'title' );
        tooltip = $( '<div id="tooltip"></div>' );
 
        if( !tip || tip == '' )
            return false;
 
        target.removeAttr( 'title' );
        tooltip.css( 'opacity', 0 )
               .html( tip )
               .appendTo( 'body' );
 
        var init_tooltip = function()
        {
            if( $( window ).width() < tooltip.outerWidth() * 1.5 )
                tooltip.css( 'max-width', $( window ).width() / 2 );
            else
                tooltip.css( 'max-width', 340 );
 
            var pos_left = target.offset().left + ( target.outerWidth() / 2 ) - ( tooltip.outerWidth() / 2 ),
                pos_top  = target.offset().top - tooltip.outerHeight() - 20;
 
            if( pos_left < 0 )
            {
                pos_left = target.offset().left + target.outerWidth() / 2 - 20;
                tooltip.addClass( 'left' );
            }
            else
                tooltip.removeClass( 'left' );
 
            if( pos_left + tooltip.outerWidth() > $( window ).width() )
            {
                pos_left = target.offset().left - tooltip.outerWidth() + target.outerWidth() / 2 + 20;
                tooltip.addClass( 'right' );
            }
            else
                tooltip.removeClass( 'right' );
 
            if( pos_top < 0 )
            {
                var pos_top  = target.offset().top + target.outerHeight();
                tooltip.addClass( 'top' );
            }
            else
                tooltip.removeClass( 'top' );
 
            tooltip.css( { left: pos_left, top: pos_top } )
                   .animate( { top: '+=10', opacity: 1 }, 50 );
        };
 
        init_tooltip();
        $( window ).resize( init_tooltip );
 
        var remove_tooltip = function()
        {
            tooltip.animate( { top: '-=10', opacity: 0 }, 50, function()
            {
                $( this ).remove();
            });
 
            target.attr( 'title', tip );
        };
 
        target.bind( 'mouseleave', remove_tooltip );
        tooltip.bind( 'click', remove_tooltip );
    });
});


