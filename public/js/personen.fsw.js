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
        CustomFunctions.initializeZoraAuthorActions();
        //this.initExtendedAttributes();

        $('#updateProfilURLPersonExtended').click(function (event){
            event.preventDefault();

            //geht nicht - warum?
            //alert($('div#persExtendedIdFSWGanzUnique',$('div#personExtended')).val());
            //alert (persExtendedIdFSW);


            $("<div id='fswDialogBox'>").dialog({
                open: function(){
                    $(this).load('/personen/editProfilURL/' + persExtendedIdFSW);

                    $('#fswDialogBox').css('background-color','#d9d9d9');
                },
                buttons: [
                    {
                        text: "Sichern",
                        click: function() {

                            //$(this).load('/kolloquien/editVeranstaltung/' + veranstaltungID, $('#Veranstaltung', this).serializeArray() );
                            $(this).load('/personen/editProfilURL/' + persExtendedIdFSW ,
                                $('#FSWPersonExtended', this).serializeArray()
                            );

                        }
                    },
                    {
                        text: "AbbrechenEditProfilURL",
                        click: function() {
                            $( this ).dialog( "close" );
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




        })


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


};
