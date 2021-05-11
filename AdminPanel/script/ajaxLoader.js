//0.0.7 Alpha
let ajaxLoader = {
    config: {
        debug: true,
        data: '.content-wrapper',
        dialog: '.content-loader',
        controller: 'link-{name}',
        mainPageGetName: 'page'
    },
    configList: {},
    spinner: function (type) {
        if (type === 'show' || type === 'start') {
            $('.loader').show();
        } else if (type === 'hide') {
            $('.loader').hide();
        }
    },
    defineLayout: function (config) {
        switch (config.layout) {
            case 'dialogbox':
                config = ajaxLoader._generateDialogbox(config);
                $('#' + config.dialog.id).dialog({
                    open: function () {
                        $(this).html(config.responseData).ready(function () {
                            config = ajaxLoader._loadDialogboxConfig(config);
                        });
                    },
                    title: config.dialog.config.title,
                });

                this.configList['dialogbox#' + config.dialog.id] = config;
                ajaxLoader.spinner('hide');
                break;
            case 'toast':
            default:
                if (typeof config.responseData === 'object') {
                    switch (config.responseData.type) {
                        case 'OK':
                            toastr.success(config.responseData.message);
                            break;
                        case 'ERROR':
                        case 'ERR':
                            toastr.error(config.responseData.message);
                            break;
                        default:
                            toastr.info(config.responseData.message);
                            break;
                    }
                }
                ajaxLoader.spinner('hide');
                break;
        }

        if (config.dialog.config.reload
            && config.dialog.object !== null
            && config.dialog.controller.urlFull !== null
        ) {
            ajaxLoader.spinner('start');
            config.dialog.object.load(config.dialog.controller.urlFull, {}, function () {
                ajaxLoader.spinner('hide');
            });
        }

        if (config.pageReload
            && config.mainURL.url !== null
        ) {
            ajaxLoader.spinner('start');
            $(ajaxLoader.config.data).load(config.mainURL.urlFull + config.data._GETString, {}, function () {
                $('table.dataTable').DataTable({
                    "language": {
                        "url": "https://cdn.datatables.net/plug-ins/1.10.22/i18n/Polish.json"
                    },
                    stateSave: true
                });
                ajaxLoader.spinner('hide');
            });
        }
    },
    _loadDialogboxConfig: function (config) {
        let $dialog = $('#' + config.dialog.id);
        config.dialog.object = $dialog;

        if ($dialog === null) {
            return config;
        }


        if (this._isJSON(config.dialog.config.button)) {
            let buttons = {};

            $.each(config.dialog.config.button, function (i, button) {
                let buttonData = {};
                buttonData.text = button.text;
                buttonData.click = function () {
                };
                buttons[i] = buttonData;
            });

            $dialog.find('.ui-dialog-content').dialog('option', 'buttons', buttons);

            const $buttonContainer = $dialog.parent().find('.ui-dialog-buttonpane');

            $.each(config.dialog.config.button, function (i, button) {
                let $buttonHandle = $buttonContainer.find(".ui-button").eq(i);
                if (typeof button.dataAjax !== 'undefined') {
                    $buttonHandle.wrap('<a href="#" data-ajax="' + button.dataAjax + '"></a>');
                }
            });
        }

        if (config.dialog.config.width !== null) {
            $dialog.parent().width(config.dialog.config.width);
        }

        if (config.dialog.config.height !== null) {
            $dialog.parent().height(config.dialog.config.height);
        }

        let win = $(window);
        $dialog.parent().css({
            position: 'absolute',
            left: (win.width() - $dialog.outerWidth()) / 2,
            top: (win.height() - $dialog.outerHeight()) / 2,
            'zIndex': 10000
        });

        config.dialog.controller = config.controllerData;

        return config;
    },
    _generateControllerData: function (data) {
        let array = [];
        let controllerName = null;
        let config = {
            controller: null,
            url: null,
            data: null,
            full: data
        }

        if (typeof data === 'string') {
            array = data.split('/');
            controllerName = array.shift();
        }

        config.controller = controllerName;
        config.url = this._generateControllerURL(controllerName);
        config.urlFull = this._generateControllerURL(config.full);
        config.data = Object.assign({}, array);

        return config;
    },
    _getViewConfig: function (config) {
        if (typeof config.responseData === 'object') {
            config.dialog.config = config.responseData.ajaxLoaderConfig.dialogbox;
            config.layout = config.responseData.ajaxLoaderConfig.layout;
            config.pageReload = config.responseData.ajaxLoaderConfig.pageReload === true;
            config.dialog.config.button = JSON.parse(config.responseData.ajaxLoaderConfig.dialogbox.button);

            return config;
        }

        config.dialog.config = JSON.parse(atob(config.responseData.match("viewConfig_dialogbox = \"(.*)\";")[1]));
        config.layout = config.responseData.match("viewConfig_layout = \"(.*)\";")[1];
        config.pageReload = config.responseData.match("viewConfig_pageReload = \"(.*)\";")[1] === true;
        config.dialog.config.button = JSON.parse(config.dialog.config.button);

        return config;
    },
    _generateControllerURL: function (name) {
        if (name === null || name === undefined) {
            return null;
        }

        return this.config.controller.replace('{name}', name);
    },
    _ajax: function (config) {
        if (config.controllerData.urlFull === null) {
            ajaxLoader.spinner('hide');
            return null;
        }

        ajaxLoader.spinner('start');

        $.ajax({
            url: config.controllerData.urlFull,
            type: 'POST',
            data: config.controllerData.data
        }).done(function (data, textStatus, jqXHR) {
            config.responseData = data;
            config.responseTextStatus = textStatus;
            config.responseXHR = jqXHR;
            config = ajaxLoader._getViewConfig(config);
            ajaxLoader.defineLayout(config);
        }).fail(function (xhr) {
            config.responseError = xhr;
            ajaxLoader.spinner('hide');
        });
    },
    _getGetData: function (name = null) {
        let parts = window.location.search.substr(1).split("&");
        let $_GET = {};

        if (parts[0] === '') {
            return $_GET;
        }

        for (let i = 0; i < parts.length; i++) {
            let temp = parts[i].split("=");
            $_GET[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
        }

        if (name === null) {
            return $_GET;
        } else {
            return eval('$_GET.' + name);
        }
    },
    _generateConfig: function (element) {
        let mainControllerName = $('body').attr('mainPage');

        if (mainControllerName === undefined) {
            mainControllerName = this._getGetData(ajaxLoader.config.mainPageGetName);
        }

        let config = {
            url: $(element).attr('ajax'),
            mainURL: this._generateControllerData(mainControllerName),
            controllerData: this._generateControllerData($(element).attr('ajax')),
            ajaxLoaderConfig: this.config,
            layout: null,
            pageReload: false,
            dialog: {
                object: null,
                id: null,
                title: null,
                controller: {
                    controller: null,
                    data: {},
                    full: null,
                    url:  null,
                    urlFull: null
                },
                config: null
            },
            data: {
                _GET: this._getGetData(null),
                _GETString: window.location.search,
            },
            form: {
                controllerName: null,
                requestMethod: null,
                data: null,
                url: null
            },
            configList: this.configList
        }

        const $dialog = $(element).closest('.ui-dialog-content');

        if ($dialog.length > 0) {
            const dialogConfig = ajaxLoader.configList['dialogbox#' + $dialog.attr('id')];
            config.dialog = dialogConfig.dialog;
        }

        if ($(element).is('form')) {
            config.form = {
                controllerName: $(element).attr("action"),
                requestMethod: $(element).attr("method"),
                data: $(element).serialize(),
                url: this._generateControllerURL($(element).attr("action"))
            }
            config.controllerData = this._generateControllerData(config.form.controllerName);
        }

        return config;
    },
    _generateDialogbox: function (config) {
        config.dialog.id = 'dialog-' + this.__uniqueId();
        config.dialog.title = '';

        $('<div/>', {
            id: config.dialog.id
        }).appendTo(ajaxLoader.config.dialog).ready(function () {
            $('#' + config.dialog.id).dialog({
                autoOpen: false,
                moveToTop: true,
                maxHeight: 600,
                close: function () {
                    $(this).dialog('destroy').remove();
                    delete ajaxLoader.configList['dialogbox#' + $(this).attr('id')];
                }
            });
            $('#' + config.dialog.id).css({
                overflow: 'auto'
            });
        });

        config.dialog.object = $('#' + config.dialog.id);

        return config;
    },
    _isJSON: function (string) {
        try {
            JSON.parse(string);
        } catch (e) {
            return false;
        }

        return true;
    },
    __debug: function (name, data) {
        if (this.config.debug === false) {
            return false;
        }

        console.debug({
            type: name,
            date: new Date(),
            config: data
        })
    },
    __uniqueId: (function () {
        let i = 1;

        return function () {
            return i++;
        }
    })()
}


jQuery(function () {
    $(document).on('click', '[ajax]', function () {
        let config = ajaxLoader._generateConfig(this);
        ajaxLoader.spinner('show');

        ajaxLoader._ajax(config);

        ajaxLoader.__debug('ajax', config);
    });

    $(document).on('submit', 'form[action]', function (event) {
        event.preventDefault();
        event.stopImmediatePropagation();

        let config = ajaxLoader._generateConfig(this);

        ajaxLoader._ajax(config);

        $(this).trigger("reset");
    });
});