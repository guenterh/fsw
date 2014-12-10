/**
 * Created by swissbib on 13.11.14.
 */


var Personen= {
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
        //CustomFunctions.initializeZoraAuthorActions();
        //this.initExtendedAttributes();

        $('.updateCoverLink').click(function(event){

            event.preventDefault();

            //var oaiIdentifier = $(event.target).attr("data-currentOaiIdentfier");
            var oaiIdentifier = $(this).attr("data-currentOaiIdentfier");
            var pers_id = $('#PersonCore\\[personExtended\\]\\[0\\]\\[pers_id\\]').val();


            $("<div id='fswDialogBox'>").dialog({
                open: function(){
                    $(this).load('/static/zf2/public/index.php/personen/editCoverLink',
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


                            $(this).load('/static/zf2/public/index.php/personen/editCoverLink', $('#Coverlink',this).serializeArray());

                        }
                    },
                    {
                        text: "Abbrechen",
                        click: function() {
                            $( this ).dialog( "close" );
                            window.location = '/static/zf2/public/index.php/personen/edit/' + pers_id + '?completeView=true';
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

        $('#addAdditionalZoraAuthor').click(function (event) {

            event.preventDefault();
            //persExtendedIdFSW
            var pers_id = $('#PersonCore\\[personExtended\\]\\[0\\]\\[pers_id\\]').val();

            $("<div id='fswDialogBox'>").dialog({
                open: function(){
                    $(this).load('/static/zf2/public/index.php/personen/addZoraAuthor/' + persExtendedIdFSW, function () {

                            $( ".datePicker").datepicker({dateFormat: 'yy-mm-dd'});
                        }
                    ) ;

                    $('#fswDialogBox').css('background-color','#d9d9d9');
                },
                buttons: [
                    {
                        text: "Sichern",
                        click: function() {

                            $(this).load('/static/zf2/public/index.php/personen/addZoraAuthor',
                                $('#ZoraAuthor', this).serializeArray()
                            );

                        }
                    },
                    {
                        text: "Abbrechen",
                        click: function() {
                            $( this ).dialog( "close" );
                            window.location = '/static/zf2/public/index.php/personen/edit/' + pers_id + '?completeView=true';

                        }
                    }

                ],


                close: function (event, ui) {
                    $(this).dialog('destroy').remove();
                },
                title: 'Erfassen Beziehung als ZoraAutor',
                width: '1000px',
                modal: true

            }).dialog( "widget")
                .find( ".ui-dialog-titlebar-close" )
                .hide();




        });


        $(".zoraAuthorDeleteButton").click(function(e) {
            e.preventDefault();

            var currentId =  $(this).attr('data-id-zoraauthor');
            var pers_id = $('#PersonCore\\[personExtended\\]\\[0\\]\\[pers_id\\]').val();


            $('<div id="okEscDialog" title="Loeschen einer Beziehung ZoraAuthir Dokumente"><p>' +
            'Wollen Sie die Beziehung eines Zoraautoren loeschen? (alle mit dem Autor verknüpfte Dokumente werden ebenfalls gelöscht' +
            '</p></div>')
                .dialog({
                    buttons: [
                        {
                            text: "OK",
                            click: function() {

                                $.ajax({
                                    url: '/static/zf2/public/index.php/personen/deleteZoraAuthor',
                                    dataType: 'json',
                                    //async false ist wichtig da ansonsten success function als callback aufgerufen wird.
                                    //Dies bewirkt dann, dass ich den return Value nicht mehr setzen kann
                                    async: false,
                                    data: {
                                        'id': currentId
                                    },
                                    success: function(response) {
                                        $('#okEscDialog').append($('<div class="fswmessage">erfolgreich gelöscht!</div>'));

                                    }
                                });
                                //$( this ).dialog( "close" );
                            }
                        },
                        {
                            text: "Abbrechen",
                            click: function() {
                                $( this ).dialog( "close" );
                                window.location = '/static/zf2/public/index.php/personen/edit/' + pers_id + '?completeView=true';
                            }
                        }

                    ],
                    open: function(){

                        $('#okEscDialog').css('background-color','#d9d9d9');
                    },
                    close: function (event, ui) {
                        $(this).dialog('destroy').remove();
                    }

                }).dialog( "widget")
                .find( ".ui-dialog-titlebar-close" )
                .hide();
        });


        $('.zoraAuthorUpdateButton').click(function (event) {

            event.preventDefault();

            var currentId =  $(this).attr('data-id-zoraauthor');
            var pers_id = $('#PersonCore\\[personExtended\\]\\[0\\]\\[pers_id\\]').val();

            $("<div id='fswDialogBox'>").dialog({
                open: function(){
                    $(this).load('/static/zf2/public/index.php/personen/editZoraAuthor/' + currentId, function () {

                            $( ".datePicker").datepicker({dateFormat: 'yy-mm-dd'});
                        }
                    ) ;

                    $('#fswDialogBox').css('background-color','#d9d9d9');
                },
                buttons: [
                    {
                        text: "Sichern",
                        click: function() {

                            $(this).load('/static/zf2/public/index.php/personen/editZoraAuthor',
                                $('#ZoraAuthor', this).serializeArray()
                            );

                        }
                    },
                    {
                        text: "Abbrechen",
                        click: function() {
                            $( this ).dialog( "close" );
                            window.location = '/static/zf2/public/index.php/personen/edit/' + pers_id + '?completeView=true';

                        }
                    }

                ],


                close: function (event, ui) {
                    $(this).dialog('destroy').remove();
                },
                title: 'Editieren der Beziehung als ZoraAutor',
                width: '1000px',
                modal: true

            }).dialog( "widget")
                .find( ".ui-dialog-titlebar-close" )
                .hide();




        });



        $('#updateProfilURLPersonExtended').click(function (event){
            event.preventDefault();

            //geht nicht - warum?
            //alert($('div#persExtendedIdFSWGanzUnique',$('div#personExtended')).val());
            //alert (persExtendedIdFSW);

            var pers_id = $('#PersonCore\\[personExtended\\]\\[0\\]\\[pers_id\\]').val();

                //PersonCore[personExtended][0][pers_id]


            $("<div id='fswDialogBox'>").dialog({
                open: function(){
                    $(this).load('/static/zf2/public/index.php/personen/editProfilURL/' + persExtendedIdFSW);

                    $('#fswDialogBox').css('background-color','#d9d9d9');
                },
                buttons: [
                    {
                        text: "Sichern",
                        click: function() {

                            //$(this).load('/kolloquien/editVeranstaltung/' + veranstaltungID, $('#Veranstaltung', this).serializeArray() );
                            $(this).load('/static/zf2/public/index.php/personen/editProfilURL/' + persExtendedIdFSW ,
                                $('#FSWPersonExtended', this).serializeArray()
                            );

                        }
                    },
                    {
                        text: "AbbrechenEditProfilURL",
                        click: function() {
                            $( this ).dialog( "close" );
                            window.location = '/static/zf2/public/index.php/personen/edit/' + pers_id + '?completeView=true';
                            //$.get('/personen/edit/' + pers_id + '?completeView=true')
                        }
                    }

                ],


                close: function (event, ui) {
                    $(this).dialog('destroy').remove();
                },
                title: 'Profil URL einer FSW Person',
                width: '1000px',
                modal: true

            }).dialog( "widget")
                .find( ".ui-dialog-titlebar-close" )
                .hide();




        });

        $('#LoeschenBeziehungPersonRolleExtended').click(function (event){
            event.preventDefault();

            var relation_id = $(this).attr("data-currentRole");
            $.post('/static/zf2/public/index.php/personen/deleteBeziehungPersonRolle',
                {
                    relationID: relation_id
                }

            );

        })

    },

    onContentUpdated: function () {
        //alert ('Personen.onContentUpdated');
        //FSWAdmin.PersonenUpdated = true;
        this.initEditor();
    },

    onSearchListUpdated: function () {

    }

};
