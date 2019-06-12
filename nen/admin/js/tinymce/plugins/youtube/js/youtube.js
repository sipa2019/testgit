tinyMCEPopup.requireLangPack();

var YoutubeDialog = {
    init: function () {
        var f = document.forms[0];

        // Get the selected contents as text and place it in the input
        f.youtubeURL.value = tinyMCEPopup.editor.selection.getContent({ format: 'text' });
    },

    insert: function () {
        // Insert the contents from the input into the document
        var url = document.forms[0].youtubeURL.value;
        if (url === null) { tinyMCEPopup.close(); return; }

//        var code, regexRes;
//        regexRes = url.match("[\\?&]v=([^&#]*)");
//        code = (regexRes === null) ? url : regexRes[1];
//        if (code === "") { tinyMCEPopup.close(); return; }
        var code, regexRes, regexResNew;
        regexRes = url.match("[\\?&]v=([^&#]*)");
        regexResNew = url.match("[be]./([^&#]*)");
        code = (regexRes === null && regexResNew == null) ? url : (regexRes != null) ? regexRes[1] : regexResNew[1];

        tinyMCEPopup.editor.execCommand('mceInsertContent', false, 
		'<center><iframe width="489" height="360" src="http://www.youtube.com/embed/' + code + '" frameborder="0" allowfullscreen></iframe></center>');
//        tinyMCEPopup.editor.execCommand('mceInsertContent', false, '<img src="http://img.youtube.com/vi/' + code + '/0.jpg" class="mceItem" alt="' + code + '"/>');
        tinyMCEPopup.close();
    }
};

tinyMCEPopup.onInit.add(YoutubeDialog.init, YoutubeDialog);





