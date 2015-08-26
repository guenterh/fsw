/**
 * Created by swissbib on 26.08.15.
 */


$(document).ready(function() {

    $("div.dynamicCaption").hide();
    $("div.containerMehr > a.internal").addClass("dynamicCaption");

    $("a.dynamicCaption").click(function () {

        var abstractVisible$ = $(this);
        var abstractVisibleSiblings$ = $(abstractVisible$).siblings();


        $("a.dynamicCaption").not(this).each(function(){

            $(this).html("mehr");
        });

        if (abstractVisible$.html() == "mehr") {
            abstractVisible$.html("weniger");
        } else {
            abstractVisible$.html("mehr");
        }


        $(  abstractVisibleSiblings$).each(function(){
            if( this.tagName == "DIV"){
                if ($(this).is(":visible")) {

                    $(this).toggle("slow");


                }else {

                    $("div.abstractText").hide();
                    $(this).show("slow");


                    $.get(
                        '/static/zf2/public/index.php/presentation/qarb/abstractForWork',
                        function(response) {
                            $( "div.dynamicCaption" ).append(response);
                        }
                    );


                }

            }
        });

    });

});

