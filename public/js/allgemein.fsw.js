/**
 * Created by swissbib on 13.11.14.
 */


var Allgemein= {
    init: function () {
        //alert ('Allgemein.init()');
        this.initSidebar();
        this.initEditor();
    },

    initSidebar: function () {

        //alert (this.constructor);
        //alert('Allgemein.initSidebar');
        Sidebar.init($.proxy(this.onSearchListUpdated, this), $.proxy(this.onContentUpdated, this));
    },

    initEditor: function () {
        //alert ('Allgemein.initEditor()');
        Editor.init($.proxy(this.onContentUpdated, this));
    },

    onContentUpdated: function () {
        //alert ('Allgemein.onContentUpdate');
        this.initEditor();
    },

    onSearchListUpdated: function () {

    }

}
