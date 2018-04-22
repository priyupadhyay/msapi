//Api Configurations
var api_url = "http://35.194.226.60:3000/api/v1/";
var access_token = "nothing";
var secret_key = "nothing";

//Get Data from API service
function getData(endpoint, returnRes) {
    $.get(api_url+endpoint, function (data, status) {
        returnRes(data);
    }); 
}

//Post Data to API service
function postData(endpoint, req, returnRes) {
    $.post(api_url+endpoint, req, function (data, status) {
        returnRes(data);
    });
}

//Update Data in API service
function putData(endpoint, req, returnRes) {
    $.put(api_url+endpoint, req, function (data, status) {
        returnRes(data);
    });
}

//Delete Data from API service
function deleteData(endpoint, returnRes) {
    $.delete(api_url+endpoint, function (data, status) {
        returnRes(data);
    });
}

//Highlight JSON Syntax
function syntaxHighlight(json) {
    if (typeof json != 'string') {
         json = JSON.stringify(json, undefined, 2);
    }
    json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
        var cls = 'number';
        if (/^"/.test(match)) {
            if (/:$/.test(match)) {
                cls = 'key';
            } else {
                cls = 'string';
            }
        } else if (/true|false/.test(match)) {
            cls = 'boolean';
        } else if (/null/.test(match)) {
            cls = 'null';
        }
        return '<span class="' + cls + '">' + match + '</span>';
    });
}
//Put and Delete Shortcuts
jQuery.each( [ "put", "delete" ], function( i, method ) {
  jQuery[ method ] = function( url, data, callback, type ) {
    if ( jQuery.isFunction( data ) ) {
      type = type || callback;
      callback = data;
      data = undefined;
    }
 
    return jQuery.ajax({
      url: url,
      type: method,
      dataType: type,
      data: data,
      success: callback
    });
  };
});