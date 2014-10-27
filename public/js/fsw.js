
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


                var veranstaltungID =  ($(e.target).attr('veranstaltungID'));
                //$("<iframe scrolling='yes' class='fswDialogBox' width='1000' height='1000'  src='/kolloquien/editPersonenVeranstaltung/15'  >").dialog({
                $("<div id='fswDialogBox'>").dialog({
                    open: function(){
                        $(this).load('/kolloquien/editPersonenVeranstaltung/' + veranstaltungID );

                        $('#fswDialogBox').css('background-color','#d9d9d9');
                    },
                    close: function (event, ui) {
                        $(this).dialog('destroy').remove();
                    },
                    title: 'Vortragende der ausgewählten Veranstaltung',
                    width: '1000px',
                    modal: true

                });

            });

            $("#addKolloqiumButton").click(function(e) {
                e.preventDefault();


                //$("<iframe scrolling='yes' class='fswDialogBox' width='1000' height='1000'  src='/kolloquien/editPersonenVeranstaltung/15'  >").dialog({
                $("<div id='fswDialogBox'>").dialog({
                    open: function(){
                        $(this).load('/kolloquien/addKolloquium' );

                        $('#fswDialogBox').css('background-color','#d9d9d9');
                    },

                    beforeClose: function( event, ui ) {
                        //alert($('textarea#Kolloqium\\[id_kolloquium\\]',event.target).val());
                        //alert($('textarea#Kolloqium\\[titel\\]',event.target).val());

                        return true;
                    },
                    close: function (event, ui) {
                        $(this).dialog('destroy').remove();
                    },
                    title: 'Erfassen eines neuen Kolloquiums',
                    width: '1000px',
                    modal: true

                });

            });

            $("#updateKolloqiumButton").click(function(e) {
                e.preventDefault();


            });

            $("#deleteKolloqiumButton").click(function(e) {
                e.preventDefault();
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