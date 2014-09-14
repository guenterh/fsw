var FSWAdmin;


FSWAdmin = {

    onLoaded: function () {

        if (this.hasUrlPart('/medien') || this.hasUrlPart('/personen') || this.hasUrlPart('/kolloquien') ||
            this.hasUrlPart('/forschung') || this.hasUrlPart('/personenaktivitaet')) {

            this.Medien.init();
        }
        /*
         if( this.hasUrlPart('/group') ) {
         this.Group.init();
         }
         if( this.hasUrlPart('/view') ) {
         this.View.init();
         }
         */
    },

    hasUrlPart: function (part) {
        return document.location.pathname.indexOf(part) !== -1;
    },


    loadInContent: function (url, handler) {
        //alert(handler);
        $('#content').load(url, handler);
        this.Sidebar.updateList();
    },


    Medien: {
        init: function () {
            this.initSidebar();
            this.initEditor();
        },

        initSidebar: function () {
            FSWAdmin.Sidebar.init($.proxy(this.onSearchListUpdated, this), $.proxy(this.onContentUpdated, this));
        },

        initEditor: function () {
            FSWAdmin.Editor.init($.proxy(this.onContentUpdated, this));
        },

        onContentUpdated: function () {
            this.initEditor();
        },

        onSearchListUpdated: function () {

        }

    },


    Editor: {
        


        testButton: function () {

            //alert ("in test button angekommen");
        },

        init: function (contentLoadedHandler) {
            this.initForm(contentLoadedHandler);
            this.initTabs();
            //this.initButtons(this.testButton);
            this.initButtons(contentLoadedHandler);
            this.initExtendedAttributes();
            this.initAdditionalZoraAuthor();

        },

        initForm: function (handler) {
            // Enable ajax form
            $('#content > form').ajaxForm({
                target: '#content',
                success: function () {
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

            $('.zoraAuthorDeleteButton').click(function (e) {

                //das will nicht klappen...
                //$(e.target).parent().prevAll().find('.hidden.idZoraAuthor').size());
                var idZoraAuthorNumber =  $(e.target).parent().prevAll().filter(function (e) {

                    //console.log(this.className);
                    return this.className == 'hidden idZoraAuthor';

                //}).val();
                }).get(0).innerHTML;
                console.log(idZoraAuthorNumber);


                $.post('/personen/editZoraAuthor',{

                        mode : 'delAuthor',
                        zoraAutorId : idZoraAuthorNumber

                    },function (response,type,xhr) {

                        $('#zoraAuthors').empty().append(response);

                        //$('<div>dies ist nur ein test</div>').appendTo('#zoraAuthors');


                        //alert(response);

                        //window.location = 'http://localhost:30000/medien';
                        //document.write(response);

                    }
                );

                /*

                $.getJSON('/personen/machwas',{},function (data,status,xhr) {
                       $.each(data, function (key, value) {
                            console.log(key);
                        });
                    }
               );

               */
            });


        },


        initAdditionalZoraAuthor: function () {
            $('#addAdditionalZoraAuthor').click(function(e) {



                console.log("in add Zora Author");



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
                        '<div id="addDivZoraAuthorNameDynamic" class="controls"> ' +
                            '<textarea id="addTextareaZoraAuthorNameDynamic" rows="1" name="addTextareaNameZoraAuthorNameDynamic"></textarea> ' +
                        '</div> ' +
                    '</div> ' +
                    '</div>' +
                    '<div class="span2" style="margin-right: 10px;">' +
                    '<a href="#" ' +
                    'class="ajaxButton addSendZoraAuthor">send</a> ' +
                    '</div>'


                ));
                //$('#PersonCore\\[personExtended\\]\\[0\\]\\[pers_id\\]').val($('#PersonCore\\[pers_id\\]').val());




            });


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
	},

    Tools:  {
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
    }




};



$(function() {
	FSWAdmin.onLoaded();

});