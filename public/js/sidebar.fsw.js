/**
 * Created by swissbib on 13.11.14.
 */



var Sidebar= {

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
