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
        alert('wo bin ich denn jetzt?');
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
            //alert ('jetzt Medien init Editor');
            FSWAdmin.Editor.init($.proxy(this.onContentUpdated, this));
        },

        onContentUpdated: function () {
            //alert ('on content update');
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
            this.initEditZoraAuthorSend();

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
                CustomFunctions.zoraAuthorDelete(e);
            });


        },


        initEditZoraAuthorSend: function () {

            $('.zoraAuthorUpdateButton > a.ajaxButton').click(function (e) {

                var updatedProperties = {};
                //das will nicht klappen...
                //$(e.target).parent().prevAll().find('.hidden.idZoraAuthor').size());
                var idZoraAuthorNumber =  $(e.target).parent().prevAll().each(function (e) {


                    //console.log(this.className);
                    switch (this.className) {
                        case 'hidden idZoraAuthor':
                            alert ('in id\n' + this.innerHTML );

                            updatedProperties.id = this.innerHTML;
                            break;
                        case 'span4 nameZoraAuthor':
                            alert ($('textarea',this).get(0).innerHTML );
                            updatedProperties.authorName = this.innerHTML;
                            break;
                        case 'span4 customizedNameZoraAuthor':
                            alert ($('textarea',this).get(0).innerHTML );
                            updatedProperties.customizedName = this.innerHTML;
                            break;
                    }



                    //}).val();
                });

                return false;

                //for (p in updatedProperties) {
                //    alert(updatedProperties[p]);
                //}

            });


        },

        initAdditionalZoraAuthorSend: function () {



            //console.log(window.persExtendedIdFSW);
            //console.log(window.persIdHS);

            $('.addSendZoraAuthor').click(function (e) {


                CustomFunctions.addSendZoraAuthor(e);
            });

        },

        initAdditionalZoraAuthor: function () {
            //console.log('in additional zora author');
            $('#addAdditionalZoraAuthor').click(function(e) {

                CustomFunctions.addAdditionalZoraAuthor(e);

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
	}




};



$(function() {
	FSWAdmin.onLoaded();

});