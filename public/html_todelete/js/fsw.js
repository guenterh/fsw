/**
 * Created by JetBrains PhpStorm.
 * User: swissbib
 * Date: 3/14/11
 * Time: 3:26 PM
 * To change this template use File | Settings | File Templates.
 */





    $(document).ready(function(){

        $("div.abstractText").hide();
        $("div.containerMehr > a.internal").addClass("abstractCaption");

        $("a.abstractCaption").click(function(){
            //alert("hallo");
            //var abstractVisible$ = $(".abstract",this);
            var abstractVisible$ = $(this);
            //alert (abstractVisible$.size());
            var abstractVisibleSiblings$ = $(abstractVisible$).siblings();


            $("a.abstractCaption").not(this).each(function(){
                
                $(this).html("mehr");
            });

            if (abstractVisible$.html() == "mehr") {
                abstractVisible$.html("weniger");
            } else {
                abstractVisible$.html("mehr");
            }


            $(abstractVisibleSiblings$).each(function(){
               if( this.tagName == "DIV"){
                   if ($(this).is(":visible")) {

                       $(this).toggle("slow");

                   }else {
                     
                       $("div.abstractText").hide();
                       $(this).show("slow");
                   }

               }
            });


        });




        $("div.abstractTextChild").hide();

        $("a.abstractCaptionChild").click(function(){
            //var abstractVisible$ = $(".abstract",this);
            var abstractVisibleChild$ = $(this);
            //alert (abstractVisible$.size());
            var abstractVisibleChildSiblings$ = $(abstractVisibleChild$).siblings();


            $("a.abstractCaptionChild").not(this).each(function(){

                $(this).html("mehr zu Personen");
            });

            if (abstractVisibleChild$.html() == "mehr zu Personen") {
                abstractVisibleChild$.html("weniger");
            } else {
                abstractVisibleChild$.html("mehr zu Personen");
            }


            $("div.abstractTextChild").each(function(){

                $(this).hide("slow");

            });

            var aktuelleVortragende = $(this).parentsUntil("div.veranstaltungen","div.vortragende");

            $("div.abstractTextChild",aktuelleVortragende).each(function(){

                if ($(this).is(":visible")) {

                    $(this).hide("slow");

                }else {
                    $(this).show("slow");
                }

            });



        });



        //wir brauchen diese Funktion, damit aus einem iFrame heraus auf die Profilseite verlinkt werdem kann,
        //die Profilseite muss jedoch im Parentwindow und nicht innerhalb des iFrames gezeigt werden
        //spaeter noch machen: wenn auf die Profilseite nicht aus einem iFrame heraus gelinkt werden soll
        //im Moment wird dies fix in PresaentationItem.php getSource gemacht
        $("a.displayParent").click(function(){


            parent.location = $(this).attr("href");
            return false;


        })



    });
