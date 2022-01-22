jQuery(document).ready(function($){


    /**
    * function to save JSON to file from browser
    * adapted from http://bgrins.github.io/devtools-snippets/#console-save
    * @param {Object} data -- json object to save
    * @param {String} file -- file name to save to 
    */
     function saveJSON(data, filename){

        if(!data) {
            console.error('No data')
            return;
        }
    
        if(!filename) filename = 'console.json'
    
        if(typeof data === "object"){
            data = JSON.stringify(data, undefined, 4)
        }
    
        var blob = new Blob([data], {type: 'text/json'}),
            e    = document.createEvent('MouseEvents'),
            a    = document.createElement('a')
    
        a.download = filename
        a.href = window.URL.createObjectURL(blob)
        a.dataset.downloadurl =  ['text/json', a.download, a.href].join(':')
        e.initMouseEvent('click', true, false, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null)
        a.dispatchEvent(e)
    }

    $("#get_session").on('click' , function (e) {
        e.preventDefault();
        const get_sesison_value  = $("#get_session_input").val();

        $.ajax({
            url: ajaxurl,
            method: 'POST',
            data: { 
                action : 'thawani_response_get_session',
                session : get_sesison_value
            },
            success: function (response) { 
               saveJSON(response , 'thawani-get-response.json');
            },
            error: function (error) { 
                console.error(error);
            }
        })
    }); 

});