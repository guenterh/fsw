/**
 * Created by swissbib on 13.11.14.
 */


var Kolloquien = {
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

        $(document).ready(function () {
            /* assuming that text input datePicker would have id='datePicker' */
            $( ".datePicker").datepicker({ dateFormat: 'yy-mm-dd' });

        });

        Editor.init($.proxy(this.onContentUpdated, this));

        $(".showPersonenVeranstaltung").click(function(e) {
            e.preventDefault();


            var veranstaltungID =  ($(e.target).attr('data-veranstaltungID'));
            //$("<iframe scrolling='yes' class='fswDialogBox' width='1000' height='1000'  src='/kolloquien/editPersonenVeranstaltung/15'  >").dialog({
            $("<div id='fswDialogBox'>").dialog({
                open: function(){
                    $(this).load('/static/zf2/public/index.php/kolloquien/editPersonenVeranstaltung/' + veranstaltungID );

                    $('#fswDialogBox').css('background-color','#d9d9d9');
                },
                buttons: [
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
                title: 'Vortragende der ausgewählten Veranstaltung',
                width: '1000px',
                modal: true

            }).dialog( "widget")
                .find( ".ui-dialog-titlebar-close" )
                .hide();

        });

        $(".addPersonenVeranstaltung").click(function(e) {
            e.preventDefault();


            var veranstaltungID =  ($(e.target).attr('data-veranstaltungID'));



            $("<div id='fswDialogBox'>").dialog({
                open: function(){
                    $(this).load('/static/zf2/public/index.php/kolloquien/addPersonVeranstaltung/' + veranstaltungID );

                    $('#fswDialogBox').css('background-color','#d9d9d9');
                },
                buttons: [
                    {
                        text: "Sichern",
                        click: function() {

                            if ($('#vortragend\\[id\\]',this).val() == 0) {

                                $(this).load('/static/zf2/public/index.php/kolloquien/addPersonVeranstaltung', $('#Vortragend', this).serializeArray());
                            } else {
                                alert ('kein doppeltes Einfuegen')
                            }
                            //das fuktioniert nach dem Laden nicht mehr
                            //$('#idButtonSave',this).attr('disabled', 'disabled');

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
                title: 'Erfassen eines neuen Kolloquiums',
                width: '1000px',
                modal: true

            }).dialog( "widget")
                .find( ".ui-dialog-titlebar-close" )
                .hide();




        });

        $(".deleteVeranstaltungButton").click(function(event){

            var currentIndex = $(event.target).attr("data-currentIndex");
            var currentId = $('#Kolloqium\\[veranstaltung\\]\\[' + currentIndex  + '\\]\\[id\\]').val();
            var currentTitel =  $('#Kolloqium\\[veranstaltung\\]\\[' + currentIndex  + '\\]\\[veranstaltung_titel\\]').val();
            var id = $('#Kolloqium\\[id\\]').val();

            $('<div id="okEscDialog" title="Loeschen einer Veranstaltung">' +
            '<p>Wollen Sie die Veranstaltung mit dem Titel</p>' +
            '<p>' + currentTitel + '</p>' +
            '<p>loeschen?</p>' +
            '</div>')
                .dialog({
                    buttons: [
                        {
                            text: "OK",
                            click: function() {
                                $.ajax({
                                    url: '/static/zf2/public/index.php/kolloquien/deleteVeranstaltung',
                                    dataType: 'json',
                                    //async false ist wichtig da ansonsten success function als callback aufgerufen wird.
                                    //Dies bewirkt dann, dass ich den return Value nicht mehr setzen kann
                                    async: false,
                                    data: {
                                        'id': currentId
                                    },
                                    success: function(response) {
                                        window.location = '/static/zf2/public/index.php/kolloquien/edit/' + id + '?completeView=true';
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

        $('.updateVeranstaltungButton').click(function (event) {

            var currentIndex = $(event.target).attr("data-currentIndex");

            var veranstaltungID = $('#Kolloqium\\[veranstaltung\\]\\[' + currentIndex  + '\\]\\[id\\]').val();
            var id = $('#Kolloqium\\[id\\]').val();

            $("<div id='fswDialogBox'>").dialog({
                open: function(){
                    $(this).load('/static/zf2/public/index.php/kolloquien/editVeranstaltung/' + veranstaltungID, function () {
                            $( ".datePicker").datepicker({dateFormat: 'yy-mm-dd'});
                        }
                    );

                    $('#fswDialogBox').css('background-color','#d9d9d9');
                },
                buttons: [
                    {
                        text: "Sichern",
                        click: function() {

                            $(this).load('/static/zf2/public/index.php/kolloquien/editVeranstaltung/' + veranstaltungID, $('#Veranstaltung', this).serializeArray());

                        }
                    },
                    {
                        text: "Abbrechen",
                        click: function() {
                            $( this ).dialog( "close" );
                            window.location = '/static/zf2/public/index.php/kolloquien/edit/' + id + '?completeView=true';
                        }
                    }

                ],


                close: function (event, ui) {
                    $(this).dialog('destroy').remove();
                },
                title: 'Attribute einer Veranstaltung',
                width: '1000px',
                modal: true

            }).dialog( "widget")
                .find( ".ui-dialog-titlebar-close" )
                .hide();
        });

        $('#addVeranstaltungButton').click(function(event) {

            event.preventDefault();
            var id = $('#Kolloqium\\[id\\]').val();

            $("<div id='fswDialogBox'>").dialog({
                open: function(){

                    var id_kolloquium = $('#Kolloqium\\[id\\]').val();


                    $(this).load('/static/zf2/public/index.php/kolloquien/addVeranstaltung?id_kolloquium=' + id_kolloquium, function () {

                        $( ".datePicker").datepicker({dateFormat: 'yy-mm-dd'});
                    } );

                    $('#fswDialogBox').css('background-color','#d9d9d9');
                },
                buttons: [
                    {
                        text: "Sichern",
                        click: function() {

                            if ($('#Veranstaltungen\\[id\\]',this).val() == 0) {

                                $(this).load('/static/zf2/public/index.php/kolloquien/addVeranstaltung', $('#Veranstaltung', this).serializeArray());
                            } else {
                                alert ('kein doppeltes Einfuegen')
                            }
                            //das fuktioniert nach dem Laden nicht mehr
                            //$('#idButtonSave',this).attr('disabled', 'disabled');

                        },
                        id: "idButtonSave"
                        //disabled: 'disabled'

                    },
                    {
                        text: "Abbrechen",
                        click: function() {
                            $( this ).dialog( "close" );
                            window.location = '/static/zf2/public/index.php/kolloquien/edit/' + id + '?completeView=true';
                        }
                    }

                ],



                close: function (event, ui) {
                    $(this).dialog('destroy').remove();
                },
                title: 'Erfassen einer neuen Veranstaltung',
                width: '1000px',
                modal: true

            }).dialog( "widget")
                .find( ".ui-dialog-titlebar-close" )
                .hide();



        });

        $("#addKolloqiumButton").click(function(e) {
            e.preventDefault();

            //$("<iframe scrolling='yes' class='fswDialogBox' width='1000' height='1000'  src='/kolloquien/editPersonenVeranstaltung/15'  >").dialog({
            $("<div id='fswDialogBox'>").dialog({
                open: function(){
                    $(this).load('/static/zf2/public/index.php/kolloquien/addKolloquium' );

                    $('#fswDialogBox').css('background-color','#d9d9d9');
                },
                buttons: [
                    {
                        text: "Sichern",
                        click: function() {

                            var returnValue = true;
                            var myDialog = $('#fswDialogBox');
                            $('#Kolloqium\\[titel\\]', myDialog).siblings().remove();
                            $('#Kolloqium\\[id_kolloquium\\]', myDialog).siblings().remove();

                            var tempTitel = $('textarea#Kolloqium\\[titel\\]',myDialog).val();
                            var tempId_kolloquium = $('textarea#Kolloqium\\[id_kolloquium\\]',myDialog).val();

                            $.ajax({
                                url: '/static/zf2/public/index.php/kolloquien/testValidKolloquium',
                                dataType: 'json',
                                //async false ist wichtig da ansonsten success function als callback aufgerufen wird.
                                //Dies bewirkt dann, dass ich den return Value nicht mehr setzen kann
                                async: false,
                                data: {

                                    'titel': tempTitel,
                                    'id_kolloquium': tempId_kolloquium

                                },
                                success: function(response) {
                                    if (response.status === 'notok') {
                                        $.each( response.messages, function( key, val ) {
                                            $('#Kolloqium\\[' + key + '\\]', $('#fswDialogBox')).after('<ul class="error"><li>' + response.messages[key] + '</li></ul>');
                                        });
                                        returnValue = false;
                                    }
                                }
                            });

                            if (returnValue) {

                                $.ajax({
                                    url: '/static/zf2/public/index.php/kolloquien/addSaveKolloquium',
                                    dataType: 'json',
                                    //async false ist wichtig da ansonsten success function als callback aufgerufen wird.
                                    //Dies bewirkt dann, dass ich den return Value nicht mehr setzen kann
                                    //async: false,
                                    data: {

                                        'titel': tempTitel,
                                        'id_kolloquium': tempId_kolloquium

                                    },
                                    success: function(response) {


                                        $( myDialog ).dialog( "close" );
                                        window.location = '/static/zf2/public/index.php/kolloquien';
                                        //document.location = '/kolloquien/'
                                    }
                                });


                            }
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
                title: 'Erfassen eines neuen Kolloquiums',
                width: '1000px',
                modal: true

            }).dialog( "widget")
                .find( ".ui-dialog-titlebar-close" )
                .hide();

        });

        $("#updateKolloqiumButton").click(function(e) {
            e.preventDefault();
            var id = $('#Kolloqium\\[id\\]').val();


            $("<div id='fswDialogBox'>").dialog({
                open: function(){
                    $(this).load('/static/zf2/public/index.php/kolloquien/editKolloquiumAttr/' + id );

                    $('#fswDialogBox').css('background-color','#d9d9d9');
                },
                buttons: [
                    {
                        text: "Sichern",
                        click: function() {

                            $(this).load('/static/zf2/public/index.php/kolloquien/editKolloquiumAttr/' + id, $('#Kolloquium', this).serializeArray() );

                        }
                    },
                    {
                        text: "Abbrechen",
                        click: function() {
                            $( this ).dialog( "close" );
                            window.location = '/static/zf2/public/index.php/kolloquien/edit/' + id + '?completeView=true';
                        }
                    }

                ],


                close: function (event, ui) {
                    $(this).dialog('destroy').remove();
                },
                title: 'Attribute eines bestehenden Kolloquiums',
                width: '1000px',
                modal: true

            }).dialog( "widget")
                .find( ".ui-dialog-titlebar-close" )
                .hide();


        });

        $("#deleteKolloqiumButton").click(function(e) {
            e.preventDefault();

            $('<div id="okEscDialog" title="Loeschen eines Kolloquiums"><p>' +
            'Wollen Sie das Kolloqium (zusammen mit allen zugehörigen' +
            'Veranstaltungen und Personen loeschen?' +
            '</p></div>')
                .dialog({
                    buttons: [
                        {
                            text: "OK",
                            click: function() {

                                $.ajax({
                                    url: '/static/zf2/public/index.php/kolloquien/deleteKolloquium',
                                    dataType: 'json',
                                    //async false ist wichtig da ansonsten success function als callback aufgerufen wird.
                                    //Dies bewirkt dann, dass ich den return Value nicht mehr setzen kann
                                    async: false,
                                    data: {
                                        'id': $('#Kolloqium\\[id\\]').val()
                                    },
                                    success: function(response) {
                                        window.location = '/static/zf2/public/index.php/kolloquien/';
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

