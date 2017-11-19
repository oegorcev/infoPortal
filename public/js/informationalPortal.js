function callAjax(s) {

    var url = s;

    var myAjax = new Ajax.Request
    (
        url,
        {
            method: "POST",
            postBody: "data=" + s,
            dataType: 'json',
            data: {data: s},
            onSuccess: renderResults
        }
    );

}

function renderResults(response) {

    var renderDiv = document.getElementById('Login_form');
    renderDiv.innerHTML = response.responseText;
}

// function callAjax(s){
//
//     var url = "/user-list/index";
//
//     var myAjax = new Ajax.Request
//     (
//         url,
//         {
//             method: "POST",
//             postBody:"data=" + s,
//             dataType: 'json',
//             data: {data:s},
//             onSuccess: renderResults
//         }
//     );
//
// }
//
// function renderResults(response){
//
//     var renderDiv = document.getElementById('table-users');
//     renderDiv.innerHTML = response.responseText;
//
// }