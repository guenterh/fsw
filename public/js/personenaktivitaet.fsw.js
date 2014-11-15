/**
 * Created by swissbib on 13.11.14.
 */


var  Personenaktivitaet = {

    init: function () {
        //alert ('Personen.init()');
        this.initSidebar();
        this.initEditor();
    },

    initSidebar: function () {
        //alert (this.constructor);
        //alert('Personen.initSidebar');
        Sidebar.init($.proxy(this.onSearchListUpdated, this), $.proxy(this.onContentUpdated, this));
    },
    initEditor: function () {
        //alert ('Personen.initEditor()');
        Editor.init($.proxy(this.onContentUpdated, this));

        $('.updateCoverLink').click(function(event){

            event.preventDefault();

            var currentIndex = $(event.target).attr("data-currentIndex");

            //name=zoradocs[0][oai_identifier]
            var oaiIdentifier = $('input[name="zoradocs\\[' +  currentIndex + '\\][oai_identifier\\]"]',$('div#zoradocs')).val();


            $("<div id='fswDialogBox'>").dialog({
                open: function(){
                    $(this).load('/personenaktivitaet/editCoverLink',
                        {
                            oai_identifier: oaiIdentifier,
                            modus: 'show'
                        }
                    );

                    $('#fswDialogBox').css('background-color','#d9d9d9');
                },
                buttons: [
                    {
                        text: "Sichern",
                        click: function() {


                            //ar idLink = $('#id', $('form#Coverlink')).val();

                            $(this).load('/personenaktivitaet/editCoverLink', $('#Coverlink',this).serializeArray());

                        }
                    },
                    {
                        text: "Abbrechen",
                        click: function() {
                            $( this ).dialog( "close" );
                        }
                    }

                ],




                close: function (event, ui) {
                    $(this).dialog('destroy').remove();
                },
                title: 'Update Cover Zoradoc',
                width: '1000px',
                modal: true

            }).dialog( "widget")
                .find( ".ui-dialog-titlebar-close" )
                .hide();

        });


    },
    onContentUpdated: function () {
        //alert ('Personen.onContentUpdated');
        //FSWAdmin.PersonenUpdated = true;
        this.initEditor();
    },

    onSearchListUpdated: function () {

    }



}
