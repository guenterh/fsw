
var FSWAdmin = {


    //PersonenUpdated : false,

    onLoaded: function () {

        if (this.hasUrlPart('/medien/') ||
            this.hasUrlPart('/forschung/') || this.hasUrlPart('/personenaktivitaet/') || this.hasUrlPart('/forschungAdmin/')) {
            this.Allgemein.init();
        } else if (this.hasUrlPart('/personen/')) {

            this.Personen.init();
        } else if (this.hasUrlPart('/kolloquien/')) {

            this.Kolloquien.init();
        } else if (this.hasUrlPart('/lehrveranstaltung/')) {

            this.Lehrveranstaltung.init();
        }
    },

    hasUrlPart: function (part) {
        return document.location.pathname.indexOf(part) !== -1;
    },


    loadInContent: function (url, handler) {
        //alert('in FSWAdmin.loadInContent');
        $('#content').load(url, handler);
        this.Sidebar.updateList();
    },


    Allgemein: {
        init: function () {
            //alert ('Allgemein.init()');
            this.initSidebar();
            this.initEditor();
        },

        initSidebar: function () {

            //alert (this.constructor);
            //alert('Allgemein.initSidebar');
            FSWAdmin.Sidebar.init($.proxy(this.onSearchListUpdated, this), $.proxy(this.onContentUpdated, this));
        },

        initEditor: function () {
            //alert ('Allgemein.initEditor()');
            FSWAdmin.Editor.init($.proxy(this.onContentUpdated, this));
        },

        onContentUpdated: function () {
            //alert ('Allgemein.onContentUpdate');
            this.initEditor();
        },

        onSearchListUpdated: function () {

        }

    },

    Lehrveranstaltung : {

        init: function () {
            //alert ('Personen.init()');
            this.initSidebar();
            this.initEditor();
        },

        initSidebar: function () {
            //alert (this.constructor);
            //alert('Personen.initSidebar');
            FSWAdmin.Sidebar.init($.proxy(this.onSearchListUpdated, this), $.proxy(this.onContentUpdated, this));
        },
        initEditor: function () {
            //alert ('Personen.initEditor()');
            FSWAdmin.Editor.init($.proxy(this.onContentUpdated, this));

            $('.updatePersonLVButton').click(function (event) {

                event.preventDefault();


                var currentIndex = $(event.target).attr("data-currentIndex");

                var personenId = $('#lehrveranstaltung\\[personenLehrveranstaltung\\]\\['  + currentIndex  + '\\]\\[fper_personen_pers_id\\]').val();
                var relationId = $('#lehrveranstaltung\\[personenLehrveranstaltung\\]\\['  + currentIndex  + '\\]\\[id\\]').val();
                var veranstaltungId = $('#lehrveranstaltung\\[personenLehrveranstaltung\\]\\['  + currentIndex  + '\\]\\[ffsw_lehrveranstaltungen_id\\]').val();

                $("<div id='fswDialogBox'>").dialog({
                    open: function(){
                        $(this).load('/lehrveranstaltung/editPerson',
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
                                $(this).load('/lehrveranstaltung/editPerson',
                                    $('#personenLehrveranstaltung', this).serializeArray()
                                );

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
                                        url: '/lehrveranstaltung/deletePerson/' + relationId,
                                        dataType: 'json',
                                        //async false ist wichtig da ansonsten success function als callback aufgerufen wird.
                                        //Dies bewirkt dann, dass ich den return Value nicht mehr setzen kann
                                        async: false,
                                        success: function(response) {
                                            alert('Loeschen der Person erfolgreich, bitte die Lehrveranstaltung neu laden');
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
                        $(this).load('/lehrveranstaltung/editPerson',
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
                                $(this).load('/lehrveranstaltung/editPerson',
                                    $('#personenLehrveranstaltung', this).serializeArray()
                                );

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
                    title: 'Attribute einer zusätzlichen Person fuer eine Lehrveranstaltung',
                    width: '1000px',
                    modal: true

                }).dialog( "widget")
                    .find( ".ui-dialog-titlebar-close" )
                    .hide();




            });

            $('#addLehrveranstaltungButton').click(function(event){

                event.preventDefault();
                console.log("in add Lehrveranstaltung")


            });


            $('#updateLehrveranstaltungButton').click(function(event){

                event.preventDefault();
                //console.log("in update Lehrveranstaltung")

                var currentLVId = $('#lehrveranstaltung\\[id\\]',$('form#lehrveranstaltung')).val();

                $("<div id='fswDialogBox'>").dialog({
                    open: function(){
                        $(this).load('/lehrveranstaltung/editLvModal/' + currentLVId);

                        $('#fswDialogBox').css('background-color','#d9d9d9');
                    },
                    buttons: [
                        {
                            text: "Sichern",
                            click: function() {

                                //$(this).load('/kolloquien/editVeranstaltung/' + veranstaltungID, $('#Veranstaltung', this).serializeArray() );
                                $(this).load('/lehrveranstaltung/editLvModal',
                                    $('#lehrveranstaltung', this).serializeArray()
                                );

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
                    title: 'Attribute durchführende Person Lehrveranstaltung',
                    width: '1000px',
                    modal: true

                }).dialog( "widget")
                    .find( ".ui-dialog-titlebar-close" )
                    .hide();




            });


            $('#deleteLehrveranstaltungButton').click(function(event){

                event.preventDefault();
                console.log("in delete Lehrveranstaltung")




            });



        },
        onContentUpdated: function () {
            //alert ('Personen.onContentUpdated');
            //FSWAdmin.PersonenUpdated = true;
            this.initEditor();
        },

        onSearchListUpdated: function () {

        }



    },

    Personen: {
        init: function () {
            //alert ('Personen.init()');
            this.initSidebar();
            this.initEditor();
        },

        initSidebar: function () {
            //alert (this.constructor);
            //alert('Personen.initSidebar');
            FSWAdmin.Sidebar.init($.proxy(this.onSearchListUpdated, this), $.proxy(this.onContentUpdated, this));
        },

        initEditor: function () {
            //alert ('Personen.initEditor()');
            FSWAdmin.Editor.init($.proxy(this.onContentUpdated, this));
            CustomFunctions.initializeZoraAuthorActions();
            //this.initExtendedAttributes();

        },

        onContentUpdated: function () {
            //alert ('Personen.onContentUpdated');
            //FSWAdmin.PersonenUpdated = true;
            this.initEditor();
        },

        onSearchListUpdated: function () {

        },

        initExtendedAttributes: function () {
            $('#addextendedAttributes').click(function (e) {

                var myTemplate = function () {
                    /*
                     <fieldset>
                     <legend>extended attributes for FSW</legend>
                     <div class="row-fluid">
                     <div class="span6">
                     <div id="cgroup-PersonCore[personExtended][0][pers_id]" class="control-group">
                     <label id="label-PersonCore[personExtended][0][pers_id]" class="control-label" for="PersonCore[personExtended][0][pers_id]">pers_id</label>
                     <div id="controls-PersonCore[personExtended][0][pers_id]" class="controls">
                     <textarea id="PersonCore[personExtended][0][pers_id]" rows="1" name="PersonCore[personExtended][0][pers_id]"></textarea>
                     </div>
                     </div>
                     </div>

                     <div class="span6">
                     <div id="cgroup-PersonCore[personExtended][0][profilURL]" class="control-group">
                     <label id="label-PersonCore[personExtended][0][profilURL]" class="control-label" for="PersonCore[personExtended][0][profilURL]">profilURL</label>
                     <div id="controls-PersonCore[personExtended][0][profilURL]" class="controls">
                     <textarea id="PersonCore[personExtended][0][profilURL]" rows="1" name="PersonCore[personExtended][0][profilURL]"></textarea>
                     </div>
                     </div>
                     </div>
                     </div>

                     </fieldset>
                     */
                };


                $("#personExtended").empty().append(FSWAdmin.Editor.heredoc(myTemplate));
                $('#PersonCore\\[personExtended\\]\\[0\\]\\[pers_id\\]').val($('#PersonCore\\[pers_id\\]').val());


            });

            //$('.zoraAuthorDeleteButton').click(function (e) {
            //    CustomFunctions.zoraAuthorDelete(e);
            //});


        }


    },


    Kolloquien: {
        init: function () {
            //alert ('Personen.init()');
            this.initSidebar();
            this.initEditor();
        },

        initSidebar: function () {
            //alert (this.constructor);
            //alert('Personen.initSidebar');
            FSWAdmin.Sidebar.init($.proxy(this.onSearchListUpdated, this), $.proxy(this.onContentUpdated, this));
        },

        initEditor: function () {
            //alert ('Personen.initEditor()');
            FSWAdmin.Editor.init($.proxy(this.onContentUpdated, this));

            $(".showPersonenVeranstaltung").click(function(e) {
                e.preventDefault();


                var veranstaltungID =  ($(e.target).attr('data-veranstaltungID'));
                //$("<iframe scrolling='yes' class='fswDialogBox' width='1000' height='1000'  src='/kolloquien/editPersonenVeranstaltung/15'  >").dialog({
                $("<div id='fswDialogBox'>").dialog({
                    open: function(){
                        $(this).load('/kolloquien/editPersonenVeranstaltung/' + veranstaltungID );

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
                        $(this).load('/kolloquien/addPersonVeranstaltung/' + veranstaltungID );

                        $('#fswDialogBox').css('background-color','#d9d9d9');
                    },
                    buttons: [
                        {
                            text: "Sichern",
                            click: function() {

                                if ($('#vortragend\\[id\\]',this).val() == 0) {

                                    $(this).load('/kolloquien/addPersonVeranstaltung', $('#Vortragend', this).serializeArray());
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
                                        url: '/kolloquien/deleteVeranstaltung',
                                        dataType: 'json',
                                        //async false ist wichtig da ansonsten success function als callback aufgerufen wird.
                                        //Dies bewirkt dann, dass ich den return Value nicht mehr setzen kann
                                        async: false,
                                        data: {
                                            'id': currentId
                                        },
                                        success: function(response) {
                                            alert('Loeschen der Veranstaltung erfolgreich, bitte die Kolloquien neu laden');
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

                $("<div id='fswDialogBox'>").dialog({
                    open: function(){
                        $(this).load('/kolloquien/editVeranstaltung/' + veranstaltungID );

                        $('#fswDialogBox').css('background-color','#d9d9d9');
                    },
                    buttons: [
                        {
                            text: "Sichern",
                            click: function() {

                                $(this).load('/kolloquien/editVeranstaltung/' + veranstaltungID, $('#Veranstaltung', this).serializeArray() );

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
                    title: 'Attribute einer Veranstaltung',
                    width: '1000px',
                    modal: true

                }).dialog( "widget")
                    .find( ".ui-dialog-titlebar-close" )
                    .hide();
            });

            $('#addVeranstaltungButton').click(function(event) {

                event.preventDefault();


                $("<div id='fswDialogBox'>").dialog({
                    open: function(){

                        var id_kolloquium = $('#Kolloqium\\[id\\]').val();


                        $(this).load('/kolloquien/addVeranstaltung?id_kolloquium=' + id_kolloquium );

                        $('#fswDialogBox').css('background-color','#d9d9d9');
                    },
                    buttons: [
                        {
                            text: "Sichern",
                            click: function() {

                                if ($('#Veranstaltungen\\[id\\]',this).val() == 0) {

                                    $(this).load('/kolloquien/addVeranstaltung', $('#Veranstaltung', this).serializeArray());
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
                        $(this).load('/kolloquien/addKolloquium' );

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
                                    url: '/kolloquien/testValidKolloquium',
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
                                        url: '/kolloquien/addSaveKolloquium',
                                        dataType: 'json',
                                        //async false ist wichtig da ansonsten success function als callback aufgerufen wird.
                                        //Dies bewirkt dann, dass ich den return Value nicht mehr setzen kann
                                        //async: false,
                                        data: {

                                            'titel': tempTitel,
                                            'id_kolloquium': tempId_kolloquium

                                        },
                                        success: function(response) {

                                            alert ('Kolloquium erfolgreich gespeichert, bitte neu laden');
                                            $( myDialog ).dialog( "close" );
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
                        $(this).load('/kolloquien/editKolloquiumAttr/' + id );

                        $('#fswDialogBox').css('background-color','#d9d9d9');
                    },
                    buttons: [
                        {
                            text: "Sichern",
                            click: function() {

                                $(this).load('/kolloquien/editKolloquiumAttr/' + id, $('#Kolloquium', this).serializeArray() );

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
                                        url: '/kolloquien/deleteKolloquium',
                                        dataType: 'json',
                                        //async false ist wichtig da ansonsten success function als callback aufgerufen wird.
                                        //Dies bewirkt dann, dass ich den return Value nicht mehr setzen kann
                                        async: false,
                                        data: {
                                            'id': $('#Kolloqium\\[id\\]').val()
                                        },
                                        success: function(response) {
                                            alert('Loeschen erfolgreich, bitte die Kolloquien neu laden');
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



    },



    Editor: {


        init: function (contentLoadedHandler) {


            //hier habe ich ein Problem - wird mehrfach aufgerufen, warum???
            //alert ('in init doppelt');

            this.initForm(contentLoadedHandler);
            this.initTabs();
            //this.initButtons(this.testButton);
            this.initButtons(contentLoadedHandler);

            //this.initExtendedAttributes();

            //CustomFunctions.initializeZoraAuthorActions();

            //this.initAdditionalZoraAuthor();
            //this.initEditZoraAuthorSend();

        },

        initForm: function (handler) {
            // Enable ajax form
            $('#content > form').ajaxForm({
                target: '#content',
                success: function () {
                    //alert ('Editor.initForm');
                    //wird aufgerufen wenn ich zum Beipspiel auf Speicherm bei Meden drücke.


                    if (handler) {
                        handler();
                    }
                    FSWAdmin.Sidebar.updateList();
                }
            });
        },

        initTabs: function () {
            $('.formTabs a').click(function (e) {
                e.preventDefault();
                $(this).tab('show');
            });
        },


        heredoc: function (func) {
            // get function code as string
            var hd = func.toString();

            // remove { /* using a regular expression
            hd = hd.replace(/(^.*\{\s*\/\*\s*)/g, '');

            // remove */ } using a regular expression
            hd = hd.replace(/(\s*\*\/\s*\}.*)$/g, '');

            // return output
            return hd;
        },




		initButtons: function(handler) {


			$('a.ajaxButton').click(function(e){

				e.preventDefault();
				FSWAdmin.loadInContent($(this).attr('href'), handler);
			});
		}
	},






	Sidebar: {

		searchDelay: null,

		listUpdate: null,
		contentUpdate: null,


		init: function(listUpdatedHandler, contentLoadedHandler) {
			this.listUpdate		= listUpdatedHandler;
			this.contentUpdate	= contentLoadedHandler;

			this.initSearchBox();
			this.initList();
		},


		initList: function() {
			var that = this;

			$('#search-results-list a').click(function(event) {
				event.preventDefault();
				$('#content').load($(this).attr('href'), that.contentUpdate);
			});
		},

		onListUpdated: function() {
			$("#search-results-list").unmask();
			this.initList();

			if( this.listUpdate ) {
				this.listUpdate();
			}
		},


		updateList: function() {
			$("#search-results-list").mask("Loading...");
			$('#search-form').submit();
		},



		initSearchBox: function() {
			var that = this,
				form;

			$('#search-form').ajaxForm({
				target: '#search-results-list',
				success: $.proxy(this.onListUpdated, this)
			});

			$('#search-query').keyup(function(event){
				form = $(this).parents('form');

				clearTimeout(that.searchDelay);

				that.searchDelay = setTimeout(function(){
					that.updateList();
//					form.submit();
				}, 500);
			});
		}
	}

};



$(function() {
	FSWAdmin.onLoaded();

});