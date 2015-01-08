
var FSWAdmin = {


    //PersonenUpdated : false,

    onLoaded: function () {

        if (this.hasUrlPart('/medien/')
            /*||
            this.hasUrlPart('/forschung/') ||  this.hasUrlPart('/forschungAdmin/') */ ) {
            Medien.init();
        } else if (this.hasUrlPart('/personen/')) {

            Personen.init();
        } else if (this.hasUrlPart('/kolloquien/')) {

            Kolloquien.init();
        } else if (this.hasUrlPart('/lehrveranstaltung/')) {

            Lehrveranstaltung.init();
        } /* else if (this.hasUrlPart('/personenaktivitaet/') ) {

            Personenaktivitaet.init();

        } */
    },

    hasUrlPart: function (part) {
        return document.location.pathname.indexOf(part) !== -1;
    },


    loadInContent: function (url, handler) {
        //alert('in FSWAdmin.loadInContent');
        $('#content').load(url, handler);
        Sidebar.updateList();
    }




};



$(function() {
	FSWAdmin.onLoaded();

});