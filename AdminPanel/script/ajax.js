function _ajaxReloadScript() {
    var head= document.getElementsByTagName('head')[0];
    var script= document.createElement('script');
    script.src= 'script/ajax.js';
    head.appendChild(script);
}

function ajaxLink(url, data = {}) {
    $.ajax({
        method: "POST",
        url: "link-" + url,
        data: data,
        dataType: 'html',
    }).always(function () {
        //loaded
    }).fail(function () {
        //error
    }).done(function (data) {
        //disable loaded
        if (data.indexOf("dialog") === 9) {
            $(document).find('.content-wrapper').append(data);
        } else {
            $(document).find('.content-wrapper').html(data);
        }
        _ajaxReloadScript();
    });
}

$("#ajaxForm").one('submit', function (event) {
    console.log('submit');
    event.preventDefault();

    let post_url = $(this).attr("action");
    let request_method = $(this).attr("method");
    let form_data = $(this).serialize();

    $.ajax({
        url: post_url,
        type: request_method,
        data: form_data,
    }).always(function () {
        //loaded script
    }).fail(function () {
        //error
    }).done(function (data) {
        //disable loaded script
        $(document).find('body').append(data);
    });
});