//0.0.4 Alpha
let ajaxLoader = {
    config: {
        debug: true,
        data: '.content-wrapper',
        dialog: '.content-loader',
        controller: 'link-{name}',
        mainPageGetName: 'page'
    },
    refreshDialog: function ($this) {
        let config = this._generateConfig($this);

        if (config.dialog.object === null) {
            return false;
        }

        $dialog = config.dialog.object;
        $dialog.load(config.dialog.controller.urlFull);
        $('.dataTable').DataTable();

        this.__debug('refreshDialog', config);
    },
    reloadMainPage: function (element = null, postData = {}) {
        let config = this._generateConfig(element);

        if (config.mainURL.url === null) {
            return false;
        }

        $(ajaxLoader.config.data).load(config.mainURL.urlFull + config.data._GETString, postData, function () {
            $('table.dataTable').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.22/i18n/Polish.json"
                },
                stateSave: true
            });
        });

        this.__debug('loadPage', config);
    },
    sendForm: function ($this) {
        let config = this._generateConfig($this);

        $.ajax({
            url: config.form.url,
            type: config.form.request_method,
            data: config.form.data,
        }).done(function (data) {
            $(ajaxLoader.config.data).append(data);
            ajaxLoader.reloadMainPage($this);
        });

        this.__debug('sendForm', config);
    },
    _generateUniqueId: (function () {
        let i = 1;

        return function () {
            return i++;
        }
    })(),
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
    _isJSON: function (string) {
        try {
            JSON.parse(string);
        } catch (e) {
            return false;
        }

        return true;
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
    _generateDialogbox: function () {
        const dialogId = 'dialog-' + this._generateUniqueId();

        $('<div/>', {
            id: dialogId
        }).appendTo(ajaxLoader.config.data).ready(function () {
            $('#' + dialogId).dialog({
                autoOpen: false,
                width: 600,
                height: 500,
                moveToTop: true,
                close: function () {
                    $(this).dialog('destroy').remove();
                }
            });
            $('#' + dialogId).css({
                overflow: 'auto'
            });
        });

        return dialogId;
    },
    _generateControllerURL: function (name) {
        if (name === null) {
            return null;
        }

        return this.config.controller.replace('{name}', name);
    },
    _generateConfig: function (element) {
        let url = $(element).attr('data-dialog'),
            mainControllerName = $('body').attr('mainPage');

        if (mainControllerName === undefined) {
            mainControllerName = this._getGetData(ajaxLoader.config.mainPageGetName);
        }

        let config = {
            url: url,
            mainURL: this._generateControllerData(mainControllerName),
            type: null,
            controllerData: this._generateControllerData(url),
            ajaxLoaderConfig: this.config,
            dialog: {
                object: null,
                id: null,
                title: null,
                controller: null
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
            }
        }

        const $dialog = $(element).closest('.ui-dialog-content');

        if ($dialog.length > 0) {
            config.dialog.id = $dialog.attr('id');
            config.dialog.title = $('#' + config.dialog.id).parent().find('.ui-dialog-title').eq(0).text();
            config.dialog.object = $dialog;
            config.dialog.controllerName = $('#' + config.dialog.id).parent().attr('data-dialog-url');
            config.dialog.controller = this._generateControllerData(config.dialog.controllerName);
            config.url = $dialog.attr('data-dialog-url');
            config.controllerData = this._generateControllerData(config.url);
        }

        if ($(element).is('form')) {
            config.form = {
                controllerName: $(element).attr("action"),
                requestMethod: $(element).attr("method"),
                data: $(element).serialize()
            }

            config.form.url = this._generateControllerURL(config.form.controllerName);
        }

        return config;
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
    }
}


$(document).ready(function () {
    $(document).on('click', 'a[data-ajax]', function () {
        let config = ajaxLoader._generateConfig(this);
        config.type = 'ajax';
        config.url = $(this).attr('data-ajax');
        config.controllerData = ajaxLoader._generateControllerData(config.url);
        const $self = this;

        $.ajax({
            url: config.controllerData.urlFull,
            type: 'POST',
            data: config.controllerData.data,
        }).done(function (data) {
            if (ajaxLoader._isJSON(data) || jQuery.type(data) === 'object') {
                if (jQuery.type(data) !== 'object') {
                    data = JSON.parse(data);
                }

                config.responseJSON = data;

                switch (data.type) {
                    case 'OK':
                        toastr.success(data.message);
                        break;
                    case 'ERROR':
                    case 'ERR':
                        toastr.error(data.message);
                        break;
                    default:
                        toastr.info(data.message);
                        break;
                }
            } else {
                config.responseText = data;
            }

            ajaxLoader.refreshDialog($self);
            ajaxLoader.reloadMainPage($self);
        }).fail(function (request, status, error) {
            config.responseError = {
                request,
                status,
                error
            }
        });


        ajaxLoader.__debug('click -> a[data-ajax]', config);
    });

    $(document).on('click', 'a[data-dialog]', function (event) {
        event.stopImmediatePropagation();

        let config = ajaxLoader._generateConfig(this);
        config.dialog.id = null;
        config.dialog.title = $(this).attr('data-dialog-title');
        config.type = 'dialog';
        config.title = $(this).attr('data-dialog-title');

        if (typeof $(this).attr('dialog-id') !== 'undefined') {
            config.dialog.id = $(this).attr('dialog-id');
        } else {
            config.dialog.id = ajaxLoader._generateDialogbox();
        }

        $('#' + config.dialog.id).dialog({
            open: function () {
                $(this).parent().attr('data-dialog-url', config.controllerData.urlFull);
                $(this).load(config.controllerData.urlFull);
            },
            title: config.title,
        });

        ajaxLoader.__debug('click -> a[data-dialog]', config);
    });

    $(document).on('click', 'a[data-dialog-refresh]', function (event) {
        event.stopImmediatePropagation();

        ajaxLoader.refreshDialog(this);
    });

    $(document).on('submit', '.ui-dialog-content form', function (event) {
        event.preventDefault();
        event.stopImmediatePropagation();

        ajaxLoader.sendForm(this);
        ajaxLoader.refreshDialog(this);
    });
});