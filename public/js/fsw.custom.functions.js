/**
 * Created by swissbib on 16.10.14.
 */


var CustomFunctions = {

    zoraAuthorDelete: function (e) {

        e.preventDefault();


        //das will nicht klappen...
        //$(e.target).parent().prevAll().find('.hidden.idZoraAuthor').size());

        var idZoraAuthorNumber =  $(e.target).parent().prevAll().filter(function (e) {

            //console.log(this.className);
            return this.className == 'hidden idZoraAuthor';

            //}).val();
        }).get(0).innerHTML;
        //console.log(idZoraAuthorNumber);


        $.post('/personen/editZoraAuthor',{

                mode : 'delAuthor',
                zoraAutorId : idZoraAuthorNumber

            },function (response,type,xhr) {

                $('#zoraAuthors').empty().append(response);

                $('#addAdditionalZoraAuthor').on('click', function (e) {
                    CustomFunctions.addAdditionalZoraAuthor(e);

                });

                $('.addSendZoraAuthor').on('click', function (e) {

                    CustomFunctions.addSendZoraAuthor(e);
                });

                $('.zoraAuthorDeleteButton').on('click', function (e) {
                    CustomFunctions.zoraAuthorDelete(e);
                });


            }
        );


    },

    addAdditionalZoraAuthor: function () {
        //console.log('in additional zora author');

        //console.log("in add Zora Author");



        var zoraAuthorTemplate = function() {
            /*
             <div class="span6">
             <div id="addGroupZoraAuthorDynamic" class="control-group">
             <label id="addLabelZoraAuthorDynamic" class="control-label" for="addTextZoraAuthorNameDynamic">zora_name</label>
             <div id="addDivZoraAuthorNameDynamic" class="controls">
             <textarea id="addTextareaZoraAuthorNameDynamic" rows="1" name="addTextareaNameZoraAuthorNameDynamic"></textarea>
             </div>
             </div>
             </div>

             <div class="span6">
             <div id="addGroupZoraAuthorCustomDynamic" class="control-group">
             <label id="addLabelZoraAuthorCustomDynamic" class="control-label" for="addTextZoraAuthorCustomNameDynamic">zora_name_customized</label>
             <div id="addDivZoraAuthorNameDynamic" class="controls">
             <textarea id="addTextareaZoraAuthorNameDynamic" rows="1" name="addTextareaNameZoraAuthorNameDynamic"></textarea>
             </div>
             </div>
             </div>
             */
        };


        //$("#personExtended").empty().append(FSWAdmin.Editor.heredoc(myTemplate));
        //$('#PersonCore\\[personExtended\\]\\[0\\]\\[pers_id\\]').val($('#PersonCore\\[pers_id\\]').val());
        //$("#addZoraAuthorRowSpace").append(FSWAdmin.Editor.heredoc(zoraAuthorTemplate()));
        $("#addZoraAuthorRowSpace").empty().append($(
            '<div class="span4">' +
            '<div id="addGroupZoraAuthorDynamic" class="control-group">' +
            '<label id="addLabelZoraAuthorDynamic" class="control-label" for="addTextZoraAuthorNameDynamic">zora_name</label>' +
            '<div id="addDivZoraAuthorNameDynamic" class="controls">' +
            '<textarea id="addTextareaZoraAuthorNameDynamic" rows="1" name="addTextareaNameZoraAuthorNameDynamic"></textarea>' +
            '</div>' +
            '</div> ' +
            '</div> ' +

            '<div class="span4"> ' +
            '<div id="addGroupZoraAuthorCustomDynamic" class="control-group"> ' +
            '<label id="addLabelZoraAuthorCustomDynamic" class="control-label" for="addTextZoraAuthorCustomNameDynamic">zora_name_customized</label> ' +
            '<div id="addDivZoraAuthorCustomNameDynamic" class="controls"> ' +
            '<textarea id="addTextareaZoraAuthorCustomNameDynamic" rows="1" name="addTextareaNameZoraAuthorNameDynamic"></textarea> ' +
            '</div> ' +
            '</div> ' +
            '</div>' +
            '<div class="span2" style="margin-right: 10px;">' +
            '<a href="#" ' +
            'class="ajaxButton addSendZoraAuthor">send</a> ' +
            '</div>'


        ));
        //$('#PersonCore\\[personExtended\\]\\[0\\]\\[pers_id\\]').val($('#PersonCore\\[pers_id\\]').val());

        //Warum klappt das hier ohne on??
        $('.addSendZoraAuthor').click(function (e) {
            CustomFunctions.addSendZoraAuthor(e);
        });



    },

    addSendZoraAuthor: function(e) {
        /*
         alert ('name: ' + $('#addTextareaZoraAuthorNameDynamic').val() + '\n' +
         'customized: ' + $('#addTextareaZoraAuthorCustomNameDynamic').val() + '\n' +
         'idExtended: '   + window.persExtendedIdFSW + '\n' +
         'idperson: ' + window.persIdHS
         );
         */

        $.post('/personen/editZoraAuthor', {

                'mode': 'addAuthor',
                'persExtendedIdFSW': window.persExtendedIdFSW,
                'persIdHS': window.persIdHS,
                'zoraAuthorName': $('#addTextareaZoraAuthorNameDynamic').val(),
                'zoraAuthorNameCustomized': $('#addTextareaZoraAuthorCustomNameDynamic').val()

            }, function (response, type, xhr) {


                $('#zoraAuthors').empty().append(response);

                $('#addAdditionalZoraAuthor').on('click', function (e) {
                    CustomFunctions.addAdditionalZoraAuthor(e);

                });

                $('.addSendZoraAuthor').on('click', function (e) {

                    CustomFunctions.addSendZoraAuthor(e);
                });

                $('.zoraAuthorDeleteButton').on('click', function (e) {
                    CustomFunctions.zoraAuthorDelete(e);
                });




            }
        )
    },


    zoraAuthorUpdate: function (e) {

        //alert ('einmal in update');
        e.preventDefault();

        var updatedProperties = {};


        //das will nicht klappen...
        //$(e.target).parent().prevAll().find('.hidden.idZoraAuthor').size());


        //alert($('.hidden .idZoraAuthor').get(0).innerHTML);

        //alert($('.hidden .idZoraAuthor').size());



        var idZoraAuthorNumber =  $(e.target).parent().prevAll().each(function (e) {


            //console.log(this.className);
            switch (this.className) {
                case 'hidden idZoraAuthor':
                    //alert ('in id\n' + this.innerHTML );

                    updatedProperties.id = this.innerHTML;
                    break;
                case 'span4 nameZoraAuthor':
                    alert ($('textarea',this).get(0).innerHTML );
                    updatedProperties.authorName = this.innerHTML;
                    break;
                case 'span4 customizedNameZoraAuthor':
                    //alert ($('textarea',this).get(0).innerHTML );
                    updatedProperties.customizedName = this.innerHTML;
                    break;
            }

        });


        //var test = '#PersonCore[zoraAuthors][' + updatedProperties['id']     + '][zora_name]';
        //alert($('PersonCore[zoraAuthors][' + updatedProperties['id']     + '][zora_name]').size());
        //alert(test);
        //alert($(test).val());

        /*
        for (p in updatedProperties) {
            alert(p + ":  " + updatedProperties[p]);
        }
        */
        /*

        $.post('/personen/editZoraAuthor',{

                mode : 'delAuthor',
                zoraAutorId : idZoraAuthorNumber

                'mode': 'updAuthor',
                'persExtendedIdFSW': window.persExtendedIdFSW,
                'persIdHS': window.persIdHS,
                'zoraAuthorName': $('#addTextareaZoraAuthorNameDynamic').val(),
                'zoraAuthorNameCustomized': $('#addTextareaZoraAuthorCustomNameDynamic').val()


            },function (response,type,xhr) {

                $('#zoraAuthors').empty().append(response);

                $('#addAdditionalZoraAuthor').on('click', function (e) {
                    CustomFunctions.addAdditionalZoraAuthor(e);

                });

                $('.addSendZoraAuthor').on('click', function (e) {

                    CustomFunctions.addSendZoraAuthor(e);
                });

                $('.zoraAuthorDeleteButton').on('click', function (e) {
                    CustomFunctions.zoraAuthorDelete(e);
                });


            }
        );

        */

    },


    initializeZoraAuthorActions: function () {

        //alert('in initialze actions');

        $('.zoraAuthorUpdateButton').click(function (e) {

            CustomFunctions.zoraAuthorUpdate(e);
        });

        $('.addSendZoraAuthor').click(function (e) {


            CustomFunctions.addSendZoraAuthor(e);
        });

        $('#addAdditionalZoraAuthor').click(function(e) {

            CustomFunctions.addAdditionalZoraAuthor(e);

        });

    }




};


var Tools =   {
    log : function (msg) {

        /*
         var log = document.getElementById('debugLog')

         if (!log) {
         log = document.createElement("div");
         log.id = 'debugLog';
         log.innerHTML = '<h5>Debug Log</h5>';

         //document.body.appendChild(log);
         //add to something
         }

         var pre = document.createElement("pre");
         var text = document.createTextNode(msg);
         pre.appendChild(text);

         log.appendChild(pre);

         */

        //JQuery

        var log = $('#debugLog');
        //var log = $('debugLog'); //so wir es nicht gefunden, nur zum test
        if (log.length == 0) {

            log = $('<div id="debugLog"<h5>Debug Log</h5></div>');
            log.appendTo(document.body);
        }
        log.append($("<pre/>").text(msg));


    }
};

