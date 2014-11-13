/**
 * Created by swissbib on 13.11.14.
 */


var Editor =  {


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
};
