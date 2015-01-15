/**
 * Created by swissbib on 13.11.14.
 */


var  Lehrveranstaltung = {

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

        $('.updatePersonLVButton').click(function (event) {

            event.preventDefault();


            var currentIndex = $(event.target).attr("data-currentIndex");

            var personenId = $('#lehrveranstaltung\\[personenLehrveranstaltung\\]\\['  + currentIndex  + '\\]\\[fper_personen_pers_id\\]').val();
            var relationId = $('#lehrveranstaltung\\[personenLehrveranstaltung\\]\\['  + currentIndex  + '\\]\\[id\\]').val();
            var veranstaltungId = $('#lehrveranstaltung\\[personenLehrveranstaltung\\]\\['  + currentIndex  + '\\]\\[ffsw_lehrveranstaltungen_id\\]').val();

            $("<div id='fswDialogBox'>").dialog({
                open: function(){
                    $(this).load('/static/zf2/public/index.php/lehrveranstaltung/editPerson',
                        {
                            fper_personen_pers_id: personenId,
                            id: relationId,
                            ffsw_lehrveranstaltungen_id: veranstaltungId,
                            mode: 'show'
                        });

                    $('#fswDialogBox').css('background-color','#d9d9d9');
                },
                buttons: [
                    {
                        text: "Sichern",
                        click: function() {

                            //$(this).load('/kolloquien/editVeranstaltung/' + veranstaltungID, $('#Veranstaltung', this).serializeArray() );
                            $(this).load('/static/zf2/public/index.php/lehrveranstaltung/editPerson',
                                $('#personenLehrveranstaltung', this).serializeArray()
                            );

                        }
                    },
                    {
                        text: "Abbrechen",
                        click: function() {
                            $( this ).dialog( "close" );
                            window.location = '/static/zf2/public/index.php/lehrveranstaltung/edit/' + veranstaltungId + '?completeView=true';
                        }
                    }

                ],


                close: function (event, ui) {
                    $(this).dialog('destroy').remove();
                },
                title: 'Attribute durchführende Person Lehrveranstaltung',
                width: '1000px',
                modal: true

            }).dialog( "widget")
                .find( ".ui-dialog-titlebar-close" )
                .hide();


        });

        $('.deletePersonLVButton').click(function (event) {
            event.preventDefault();

            var currentIndex = $(event.target).attr("data-currentIndex");
            var relationId = $('#lehrveranstaltung\\[personenLehrveranstaltung\\]\\['  + currentIndex  + '\\]\\[id\\]').val();
            //var currentLV = $('#lehrveranstaltung\\[id\\]',  $('form#lehrveranstaltung')).val();

            var lvid = $('#lehrveranstaltung\\[id\\]').val();



            $('<div id="okEscDialog" title="Loeschen einer Person mit Bezug zu einer Lehrveranstaltung">' +
            '<p>Wollen Sie die Person</p>' +
            '<p>loeschen?</p>' +
            '</div>')
                .dialog({
                    buttons: [
                        {
                            text: "OK",
                            click: function() {
                                $.ajax({
                                    url: '/static/zf2/public/index.php/lehrveranstaltung/deletePerson/' + relationId,
                                    dataType: 'json',
                                    //async false ist wichtig da ansonsten success function als callback aufgerufen wird.
                                    //Dies bewirkt dann, dass ich den return Value nicht mehr setzen kann
                                    async: false,
                                    success: function(response) {

                                        window.location = '/static/zf2/public/index.php/lehrveranstaltung/edit/' + lvid + '?completeView=true';

                                    }
                                });
                                $( this ).dialog( "close" );

                            }
                        },
                        {
                            text: "Abbrechen",
                            click: function() {
                                $( this ).dialog( "close" );
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


        $('#addPersonLVButton').click(function (event) {

            event.preventDefault();
            var currentLV = $('#lehrveranstaltung\\[id\\]',  $('form#lehrveranstaltung')).val();


            $("<div id='fswDialogBox'>").dialog({
                open: function(){
                    $(this).load('/static/zf2/public/index.php/lehrveranstaltung/editPerson',
                        {
                            fper_personen_pers_id: 0,
                            id: 0,
                            ffsw_lehrveranstaltungen_id: currentLV

                        });

                    $('#fswDialogBox').css('background-color','#d9d9d9');
                },
                buttons: [
                    {
                        text: "Sichern",
                        click: function() {

                            //$(this).load('/kolloquien/editVeranstaltung/' + veranstaltungID, $('#Veranstaltung', this).serializeArray() );
                            $(this).load('/static/zf2/public/index.php/lehrveranstaltung/editPerson',
                                $('#personenLehrveranstaltung', this).serializeArray()
                            );

                        }
                    },
                    {
                        text: "Abbrechen",
                        click: function() {
                            $( this ).dialog( "close" );
                            window.location = '/static/zf2/public/index.php/lehrveranstaltung/edit/' + currentLV + '?completeView=true';

                        }
                    }

                ],


                close: function (event, ui) {
                    $(this).dialog('destroy').remove();
                },
                title: 'Attribute einer zusätzlichen Person fuer eine Lehrveranstaltung',
                width: '1000px',
                modal: true

            }).dialog( "widget")
                .find( ".ui-dialog-titlebar-close" )
                .hide();




        });

        $('#addLehrveranstaltungButton').click(function(event){

            event.preventDefault();
            //console.log("in add Lehrveranstaltung")
            var newLehrId = 0;

            $("<div id='fswDialogBox'>").dialog({
                open: function(){
                    $(this).load('/static/zf2/public/index.php/lehrveranstaltung/editLvModal' );

                    $('#fswDialogBox').css('background-color','#d9d9d9');
                },
                buttons: [
                    {
                        text: "Sichern",
                        click: function() {
                            if (newLehrId >0) {
                                alert ("Veranstaltung wurde bereits eingefügt. Kein insert mehr möglich");
                                return;
                            }
                            //$(this).load('/kolloquien/editVeranstaltung/' + veranstaltungID, $('#Veranstaltung', this).serializeArray() );
                            $(this).load('/static/zf2/public/index.php/lehrveranstaltung/editLvModal',
                                $('#lehrveranstaltung', this).serializeArray(),function (){
                                    newLehrId = $('#lehrveranstaltung\\[id\\]',this).val();
                                }
                            );

                        }
                    },
                    {
                        text: "Abbrechen",
                        click: function() {

                            $( this ).dialog( "close" );
                            if (newLehrId > 0) {
                                window.location = '/static/zf2/public/index.php/lehrveranstaltung/edit/' + newLehrId + '?completeView=true';
                            } else {
                                window.location = '/static/zf2/public/index.php/lehrveranstaltung/';
                            }

                        }
                    }

                ],


                close: function (event, ui) {
                    $(this).dialog('destroy').remove();
                },
                title: 'Eingabe einer neuen Lehrveranstaltung',
                width: '1000px',
                modal: true

            }).dialog( "widget")
                .find( ".ui-dialog-titlebar-close" )
                .hide();


        });


        $('#updateLehrveranstaltungButton').click(function(event){

            event.preventDefault();
            //console.log("in update Lehrveranstaltung");

            var currentLVId = $('#lehrveranstaltung\\[id\\]',$('form#lehrveranstaltung')).val();

            $("<div id='fswDialogBox'>").dialog({
                open: function(){
                    $(this).load('/static/zf2/public/index.php/lehrveranstaltung/editLvModal/' + currentLVId);

                    $('#fswDialogBox').css('background-color','#d9d9d9');
                },
                buttons: [
                    {
                        text: "Sichern",
                        click: function() {

                            //$(this).load('/kolloquien/editVeranstaltung/' + veranstaltungID, $('#Veranstaltung', this).serializeArray() );
                            $(this).load('/static/zf2/public/index.php/lehrveranstaltung/editLvModal/' + currentLVId ,
                                $('#lehrveranstaltung', this).serializeArray()
                            );

                        }
                    },
                    {
                        text: "Abbrechen",
                        click: function() {
                            $( this ).dialog( "close" );
                            window.location = '/static/zf2/public/index.php/lehrveranstaltung/edit/' + currentLVId + '?completeView=true';

                        }
                    }

                ],


                close: function (event, ui) {
                    $(this).dialog('destroy').remove();
                },
                title: 'Attribute durchführende Person Lehrveranstaltung',
                width: '1000px',
                modal: true

            }).dialog( "widget")
                .find( ".ui-dialog-titlebar-close" )
                .hide();




        });


        $('#deleteLehrveranstaltungButton').click(function(event){

            event.preventDefault();
            //console.log("in delete Lehrveranstaltung");

            var formLV = $('form#lehrveranstaltung');
            var currentLVId = $('#lehrveranstaltung\\[id\\]',formLV).val();
            var currentLVTitel = $('#lehrveranstaltung\\[titel\\]',formLV).val();


            $('<div id="okEscDialog" title="Loeschen einer Lehrveranstaltung">' +
            '<p>Wollen Sie die LehrVeranstaltung mit dem Titel</p>' +
            '<p>' + currentLVTitel + '</p>' +
            '<p>loeschen?</p>' +
            '</div>')
                .dialog({
                    buttons: [
                        {
                            text: "OK",
                            click: function() {

                                //alert ('in ok');
                                $.ajax({
                                    url: '/static/zf2/public/index.php/lehrveranstaltung/deleteLehrveranstaltung',
                                    dataType: 'json',
                                    //async false ist wichtig da ansonsten success function als callback aufgerufen wird.
                                    //Dies bewirkt dann, dass ich den return Value nicht mehr setzen kann
                                    async: false,
                                    data: {
                                        'id': currentLVId
                                    },
                                    success: function(response) {
                                        window.location = '/static/zf2/public/index.php/lehrveranstaltung/';

                                    }
                                });
                                $( this ).dialog( "close" );

                            }
                        },
                        {
                            text: "Abbrechen",
                            click: function() {
                                $( this ).dialog( "close" );
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



    },
    onContentUpdated: function () {
        //alert ('Personen.onContentUpdated');
        //FSWAdmin.PersonenUpdated = true;
        this.initEditor();
    },

    onSearchListUpdated: function () {

    }



};
