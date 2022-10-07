

// Online Banking 1.10.2 by JP Larson, Copyright 2020 Fiserv. All rights reserved.
(function () {
    jQuery.fn.onlineBanking = function (options) {
        var settings = jQuery.extend(true, {
            defaultAccountType: "personal",
            classObject: jQuery(this),
            focusClass: "focus",
            loadingClass: "loading",
            select: '[name*=loginTo]',
            routingNumber: "199999996",
            retail: {
                server: "idemo.secureinternetbank.com",
                profileNumber: null,
                version: "5.4-SecureNow",
                class: "personal",
                active: false,
                custom: function () {
                    return console.log(_obj.onlineBanking.retail.version + " has been selected for Retail Online. Additional code within the custom parameter may be needed.");
                },
                args: {
                    formId: "pbi-form",
                    passwordId: "pbi-password",
                    usernameId: "pbi-username"
                }
            },
            business: {
                server: "idemo.secureinternetbank.com",
                profileNumber: null,
                version: "6.0",
                class: "business",
                active: false,
                custom: function () {
                    return console.log(_obj.onlineBanking.retail.version + " has been selected for Business Online. Additional code within the custom parameter may be needed.");
                },
                args: {
                    formId: "ebc-form",
                    passwordId: "ebc-password",
                    usernameId: "ebc-username"
                }
            },
            other: {
                class: "other",
                active: false,
                custom: function () {
                    return console.log("Other has been activated for Online Banking. Additional code within the custom parameter may be needed.");
                }
            },
            validateForm: {
                submitObject: jQuery('[type=submit]'),
                class: {
                    valid: "valid",
                    invalid: "invalid",
                    required: "required",
                    form: "validate-form"
                },
                focus: {
                    active: true,
                    scroll: true,
                    position: 0.3
                },
                listeners: "click blur input change",
                focusPosition: "30%",
                defaultErrorMessage: "Please fill out this field.",
                validateDelay: 0,
                success: function () {
                    return true;
                },
                error: function () {
                    return false;
                }
            },
            success: function () { },
            error: function (obj, msg, form) {
                const spinnerDuration = 750;
                form.addClass(obj.onlineBanking.errorFallback.class);
                const timer = setTimeout(function () {
                    obj.removeClass(obj.onlineBanking.loadingClass);
                }, spinnerDuration);
                const timer2 = setTimeout(function () {
                    form.removeClass(obj.onlineBanking.errorFallback.messageClass);
                }, obj.onlineBanking.errorFallback.messageDuration + spinnerDuration);
                return;
            },
            errorFallback: {
                duration: 2.592e+9, // Milliseconds
                class: "error",
                messageClass: "message",
                messageDuration: 3000 // Milliseconds
            }
        }, options),
            _obj = this,
            currentDate = new Date().getTime(),
            onlineBankingFallback = localStorage.onlineBankingFallback ? JSON.parse(localStorage.onlineBankingFallback) : {},
            errorFallback = function (form) {
                const expiration = new Date(currentDate + _obj.onlineBanking.errorFallback.duration).getTime();
                onlineBankingFallback[form] = expiration;
                localStorage.onlineBankingFallback = JSON.stringify(onlineBankingFallback);
            },
            ob = {
                retail: {
                    "default": function () {
                        login.find("form." + _obj.onlineBanking.retail.class).on('submit', function () {
                            if (_obj.onlineBanking.profileNumber) {
                                this.action = "https://" + _obj.onlineBanking.retail.server + "/pbi_pbi1151/login/" + _obj.onlineBanking.routingNumber + "/" + _obj.onlineBanking.profileNumber;
                            } else {
                                this.action = "https://" + _obj.onlineBanking.retail.server + "/pbi_pbi1151/login/" + _obj.onlineBanking.routingNumber;
                            }
                        });
                        return true;
                    },
                    "5.4-SecureNow": function () {
                        const formID = _obj.onlineBanking.retail.args.formId;
                        const form = jQuery("#" + formID);
                        const errorMessage = "RO 5.4-SecureNow Errored.";
                        const fallbackFile = "https://" + _obj.onlineBanking.retail.server + "/PBI_PBI1151/js/remoteLoginSecure";
                        if (onlineBankingFallback[formID] && onlineBankingFallback[formID] > currentDate) return _obj.onlineBanking.error(_obj, errorMessage, form);
                        jQuery.ajax({
                            url: fallbackFile,
                            dataType: "script",
                            success: function (result) {
                                const submitCallback = function () {
                                    console.log("RO 5.4-SecureNow Submitted");
                                }
                                const errorCallback = function () {
                                    _obj.onlineBanking.error(_obj, errorMessage, form);
                                    const timer = setTimeout(function () {
                                        form.addClass(_obj.onlineBanking.errorFallback.messageClass);
                                    }, 750);
                                    errorFallback(formID);
                                }
                                const args = {
                                    errorCallback: errorCallback,
                                    submitCallback: submitCallback,
                                    applicationPath: "https://" + _obj.onlineBanking.retail.server + "/PBI_PBI1151",
                                    formId: _obj.onlineBanking.retail.args.formId,
                                    passwordId: _obj.onlineBanking.retail.args.passwordId,
                                    routingTransit: _obj.onlineBanking.routingNumber,
                                    profileNumber: _obj.onlineBanking.retail.profileNumber,
                                    usernameId: _obj.onlineBanking.retail.args.usernameId
                                };

                                new PBI.RemoteLogin(args);
                            }
                        });
                        return true;
                    },
                    "5.4-SecureNow-Load": function () {
                        const formID = _obj.onlineBanking.retail.args.formId;
                        const form = jQuery("#" + formID);
                        const errorMessage = "RO 5.4-SecureNow Errored.";
                        const loadFile = "https://" + _obj.onlineBanking.retail.server + "/PBI_PBI1151/js/remoteLoginLoad";
                        if (onlineBankingFallback[formID] && onlineBankingFallback[formID] > currentDate) return _obj.onlineBanking.error(_obj, errorMessage, form);
                        jQuery.ajax({
                            url: loadFile,
                            dataType: "script",
                            success: function (result) {
                                const submitCallback = function () {
                                    console.log("RO 5.4-SecureNow Submitted");
                                }
                                const errorCallback = function () {
                                    _obj.onlineBanking.error(_obj, errorMessage, form);
                                    const timer = setTimeout(function () {
                                        form.addClass(_obj.onlineBanking.errorFallback.messageClass);
                                    }, 750);
                                    errorFallback(formID);
                                }
                                const args = {
                                    errorCallback: errorCallback,
                                    submitCallback: submitCallback,
                                    applicationPath: "https://" + _obj.onlineBanking.retail.server + "/PBI_PBI1151",
                                    formId: _obj.onlineBanking.retail.args.formId,
                                    passwordId: _obj.onlineBanking.retail.args.passwordId,
                                    routingTransit: _obj.onlineBanking.routingNumber,
                                    profileNumber: _obj.onlineBanking.retail.profileNumber,
                                    usernameId: _obj.onlineBanking.retail.args.usernameId
                                };

                                new PBI.RemoteLogin(args);
                            }
                        });
                        return true;
                    },
                    "Cloud": function () {
                        const formID = _obj.onlineBanking.retail.args.formId;
                        const form = jQuery("#" + formID);
                        const errorMessage = "RO 5.4-SecureNow Errored.";
                        const fallbackFile = "https://retailonline.fiservapps.com/js/remoteLogin.js";
                        if (onlineBankingFallback[formID] && onlineBankingFallback[formID] > currentDate) return _obj.onlineBanking.error(_obj, errorMessage, form);

                        jQuery.ajax({
                            url: fallbackFile,
                            dataType: "script",
                            success: function (result) {
                                const submitCallback = function () {
                                    console.log("RO Cloud Submitted");
                                }
                                const errorCallback = function () {
                                    _obj.onlineBanking.error(_obj, errorMessage, form);
                                    const timer = setTimeout(function () {
                                        form.addClass(_obj.onlineBanking.errorFallback.messageClass);
                                    }, 750);
                                    errorFallback(formID);
                                }
                                const args = {
                                    errorCallback: errorCallback,
                                    submitCallback: submitCallback,
                                    applicationPath: "https://retailonline.fiservapps.com/",
                                    formId: _obj.onlineBanking.retail.args.formId,
                                    passwordId: _obj.onlineBanking.retail.args.passwordId,
                                    routingTransit: _obj.onlineBanking.routingNumber,
                                    profileNumber: _obj.onlineBanking.retail.profileNumber,
                                    usernameId: _obj.onlineBanking.retail.args.usernameId
                                };

                                new PBI.RemoteLogin(args);
                            }
                        });
                        return true;
                    },
                    "Cloud-Load": function () {
                        const formID = _obj.onlineBanking.retail.args.formId;
                        const form = jQuery("#" + formID);
                        const errorMessage = "RO 5.4-SecureNow Errored.";
                        const loadFile = "https://retailonline.fiservapps.com/js/remoteLoginLoad.js";
                        if (onlineBankingFallback[formID] && onlineBankingFallback[formID] > currentDate) return _obj.onlineBanking.error(_obj, errorMessage, form);

                        jQuery.ajax({
                            url: loadFile,
                            dataType: "script",
                            success: function (result) {
                                const submitCallback = function () {
                                    console.log("RO Cloud Submitted");
                                }
                                const errorCallback = function () {
                                    _obj.onlineBanking.error(_obj, errorMessage, form);
                                    const timer = setTimeout(function () {
                                        form.addClass(_obj.onlineBanking.errorFallback.messageClass);
                                    }, 750);
                                    errorFallback(formID);
                                }
                                const args = {
                                    errorCallback: errorCallback,
                                    submitCallback: submitCallback,
                                    applicationPath: "https://retailonline.fiservapps.com/",
                                    formId: _obj.onlineBanking.retail.args.formId,
                                    passwordId: _obj.onlineBanking.retail.args.passwordId,
                                    routingTransit: _obj.onlineBanking.routingNumber,
                                    profileNumber: _obj.onlineBanking.retail.profileNumber,
                                    usernameId: _obj.onlineBanking.retail.args.usernameId
                                };

                                new PBI.RemoteLogin(args);
                            }
                        });
                        return true;
                    },
                    "custom": function () {
                        return _obj.onlineBanking.retail.custom();
                    }
                },
                business: {
                    "default": function () {
                        login.find("form." + _obj.onlineBanking.business.class).on('submit', function () {
                            var form = jQuery(this),
                                AccessID = form.find('[name=AccessID]').get(0),
                                nmUID = form.find('[name=nmUID]').get(0),
                                nmRTN = form.find('[name=nmRTN]').get(0);
                            if (typeof nmUID !== "undefined" && typeof nmRTN !== "undefined") {
                                nmUID.value = AccessID.value;
                                nmRTN.value = _obj.onlineBanking.routingNumber;
                                form.get(0).action = "https://" + _obj.onlineBanking.business.server + "/ebc_ebc1961/ebc1961.ashx?WCI=Process&WCE=RemoteLogon&IRL=T&MFA=2&RT=" + _obj.onlineBanking.routingNumber;
                            } else {
                                console.log("nmUID or nmRTN does not exist.");
                                return false;
                            }
                        });
                        return true;
                    },
                    "6.0": function () {
                        const formID = _obj.onlineBanking.business.args.formId;
                        const form = jQuery("#" + formID);
                        const errorMessage = "BO 6.0 Errored.";
                        const loadFile = "https://" + _obj.onlineBanking.business.server + "/EBC_EBC1151/js/remoteLoginLoad.js";
                        const fallbackFile = "https://" + _obj.onlineBanking.business.server + "/EBC_EBC1151/js/RemoteLogon";
                        if (onlineBankingFallback[formID] && onlineBankingFallback[formID] > currentDate) return _obj.onlineBanking.error(_obj, errorMessage, form);
                        jQuery.ajax({
                            url: fallbackFile,
                            dataType: "script",
                            success: function () {
                                const submitCallback = function () {
                                    console.log("BO 6.0 Submitted");
                                }
                                const errorCallback = function () {
                                    _obj.onlineBanking.error(_obj, errorMessage, form);
                                    form.addClass(_obj.onlineBanking.errorFallback.messageClass);
                                    errorFallback(formID);
                                }
                                const args = {
                                    errorCallback: errorCallback,
                                    submitCallback: submitCallback,
                                    applicationPath: "https://" + _obj.onlineBanking.business.server + "/EBC_EBC1151",
                                    formId: _obj.onlineBanking.business.args.formId,
                                    passwordId: _obj.onlineBanking.business.args.passwordId,
                                    routingTransit: _obj.onlineBanking.routingNumber,
                                    profileNumber: _obj.onlineBanking.business.profileNumber,
                                    usernameId: _obj.onlineBanking.business.args.usernameId
                                };
                                new EBC.RemoteLogin(args);
                            }
                        });
                        return true;
                    },
                    "6.0-Load": function () {
                        const formID = _obj.onlineBanking.business.args.formId;
                        const form = jQuery("#" + formID);
                        const errorMessage = "BO 6.0 Errored.";
                        const loadFile = "https://" + _obj.onlineBanking.business.server + "/EBC_EBC1151/js/remoteLoginLoad";
                        if (onlineBankingFallback[formID] && onlineBankingFallback[formID] > currentDate) return _obj.onlineBanking.error(_obj, errorMessage, form);
                        jQuery.ajax({
                            url: loadFile,
                            dataType: "script",
                            success: function () {
                                const submitCallback = function () {
                                    console.log("BO 6.0 Submitted");
                                }
                                const errorCallback = function () {
                                    _obj.onlineBanking.error(_obj, errorMessage, form);
                                    form.addClass(_obj.onlineBanking.errorFallback.messageClass);
                                    errorFallback(formID);
                                }
                                const args = {
                                    errorCallback: errorCallback,
                                    submitCallback: submitCallback,
                                    applicationPath: "https://" + _obj.onlineBanking.business.server + "/EBC_EBC1151",
                                    formId: _obj.onlineBanking.business.args.formId,
                                    passwordId: _obj.onlineBanking.business.args.passwordId,
                                    routingTransit: _obj.onlineBanking.routingNumber,
                                    profileNumber: _obj.onlineBanking.business.profileNumber,
                                    usernameId: _obj.onlineBanking.business.args.usernameId
                                };
                                new EBC.RemoteLogin(args);
                            }
                        });
                        return true;
                    },
                    "custom": function () {
                        return _obj.onlineBanking.business.custom();
                    }
                }
            },
            OnSelectionChange = function (login, select) {
                if (select.length > 0) {
                    var selectValue = function () {
                        if (selectType(select) == "radio") {
                            for (i = 0; i < select.length; i++) {
                                if (select.eq(i).get(0).checked) {
                                    return select.eq(i).get(0).value;
                                }
                            }
                        } else if (selectType(select) == "select") {
                            if (select.val()) {
                                return select.val();
                            }
                            return select.find('option:not(:disabled)').eq(0).val();
                        }

                    };
                    _obj.onlineBanking.classObject.removeClass(_obj.onlineBanking.retail.class).removeClass(_obj.onlineBanking.business.class).removeClass(_obj.onlineBanking.other.class).addClass(selectValue());
                    login.find('form input, form select, form textarea, form button').each(function () {
                        this.disabled = true;
                    });
                    login.find('.' + selectValue()).each(function () {
                        jQuery(this).find('input, select, textarea, button').each(function () {
                            this.disabled = false;
                        });
                    });
                }
                return true;
            },
            selectType = function (select) {
                if (select.length > 0) {
                    if (select.get(0).nodeName == "INPUT" && select.get(0).type == "radio") {
                        return "radio";
                    } else if (select.get(0).nodeName == "SELECT") {
                        return "select";
                    }
                }
                return null;
            },
            setDefault = function (select) {
                if (_obj.onlineBanking.defaultAccountType) {
                    if (selectType(select) == "radio") {
                        login.find('[value=' + _obj.onlineBanking.defaultAccountType + ']').get(0).checked = true;
                        login.find('[value=' + _obj.onlineBanking.defaultAccountType + ']').change();
                    } else if (selectType(select) == "select") {
                        login.find('[value=' + _obj.onlineBanking.defaultAccountType + ']').siblings().removeAttr('selected');
                        login.find('[value=' + _obj.onlineBanking.defaultAccountType + ']').attr('selected', 'true');
                        select.eq(0).change();
                    }
                }
            },
            inputFocus = function (obj) {
                var thisClass = _obj.onlineBanking.focusClass + "-" + obj.get(0).name,
                    debounce;
                _obj.onlineBanking.classObject.addClass(thisClass);
                obj.parent().addClass(_obj.onlineBanking.focusClass);
                obj.on('blur', function () {
                    clearTimeout(debounce);
                    debounce = setTimeout(function () {
                        _obj.onlineBanking.classObject.removeClass(thisClass);
                        obj.parent().removeClass(_obj.onlineBanking.focusClass);
                    }, 100);
                });
                return obj;
            },
            login,
            init = function (obj) {
                for (var i = 0, n = obj.length; i < n; i++) {
                    login = obj.eq(i);
                    var select = login.find(_obj.onlineBanking.select);
                    select.on('change', function () {
                        OnSelectionChange(login, jQuery(this));
                    });
                    login.find('input, select, textarea').on('focus', function () {
                        return inputFocus(jQuery(this));
                    });
                    login.find('[type=submit]').on('click', function () {
                        OnSelectionChange(login, select);
                    });
                    if (select.length > 0) {
                        setDefault(select);
                    }

                    for (var key in ob) {
                        if (_obj.onlineBanking.hasOwnProperty(key)) {
                            if (_obj.onlineBanking[key].active) {
                                if (typeof ob[key][_obj.onlineBanking[key].version] === "function") {
                                    ob[key][_obj.onlineBanking[key].version]();
                                } else {
                                    ob[key]["default"]();
                                }
                            }
                        }
                    }

                    if (typeof _obj.onlineBanking.other.custom === "function" && _obj.onlineBanking.other.active) {
                        _obj.onlineBanking.other.custom();
                    }
                    if (typeof jQuery.fn.validateForm == "function" && _obj.onlineBanking.validateForm) {
                        const validateSettings = _obj.onlineBanking.validateForm;
                        validateSettings.success = function () {
                            _obj.addClass(_obj.onlineBanking.loadingClass);
                            jQuery(window).on('unload pagehide', function (e) {
                                _obj.removeClass(_obj.onlineBanking.loadingClass);
                            });
                        }
                        _obj.validateForm(validateSettings);
                    }
                    _obj.removeClass(_obj.onlineBanking.loadingClass);
                    _obj.onlineBanking.success();
                }
                jQuery('html').addClass('fiserv-online-banking');
            };
        _obj.onlineBanking = settings;
        init(this);
        return this;
    }
}(jQuery));
//Field History 2.0.1
(function () {
    jQuery.fn.fieldHistory = function (options) {
        var settings = jQuery.extend({
            form: jQuery(this).closest('form'), // This is the form used to detect submission, if submit is used as a savetrigger.
            storageItem: "saved", // This is prepended to the name of the field and used as the local storage key.
            saveTrigger: "submit" // The event in which triggers the value being saved.
        }, options),
            storageItem = function (thisObj) {
                return thisObj.get(0).name ? settings.storageItem + "-" + thisObj.get(0).name : settings.storageItem + "-" + thisObj.get(0).id;
            },
            preference = function (thisObj) {
                return localStorage.getItem(storageItem(thisObj));
            },
            type = function (thisObj) {
                return thisObj.get(0).type;
            },
            checkThis = function (thisObj) {
                if (thisObj.val() == preference(thisObj)) {
                    thisObj.trigger('change').trigger('click');
                    thisObj.get(0).checked = true;
                    return true;
                } else {
                    thisObj.get(0).checked = false;
                    return false;
                }
            },
            savePreference = function (thisObj) {
                localStorage.setItem(storageItem(thisObj), thisObj.val());
            },
            deletePreference = function (thisObj) {
                localStorage.removeItem(storageItem(thisObj));
            },
            setInput = function (thisObj) {
                switch (type(thisObj)) {
                    case "radio":
                        checkThis(thisObj);
                        break;
                    case "checkbox":
                        checkThis(thisObj);
                        break;
                    default:
                        thisObj.val(preference(thisObj));
                        thisObj.trigger('change').trigger('click');
                }
            },
            saveIterate = function (thisObj) {
                if (thisObj.closest('form') && thisObj.closest('form').find('[type=password]').length <= 0) {
                    console.log('save');
                    switch (type(thisObj)) {
                        case "radio":
                            if (thisObj.is(':checked')) {
                                savePreference(thisObj);
                            }
                            break;
                        case "checkbox":
                            if (thisObj.is(':checked')) {
                                savePreference(thisObj);
                            } else {
                                deletePreference(thisObj);
                            }
                            break;
                        default:
                            if (thisObj.get(0).validity.valid) {
                                savePreference(thisObj);
                            } else {
                                deletePreference(thisObj);
                            }
                    }
                }
                return true;
            },
            init = function (obj) {
                for (var i = 0, n = obj.length; i < n; i++) {
                    var thisObj = obj.eq(i);
                    if (preference(thisObj)) {
                        setInput(thisObj);
                    }
                }
                switch (settings.saveTrigger) {
                    case "submit":
                        settings.form.on('submit', function () {
                            for (var i = 0, n = obj.length; i < n; i++) {
                                saveIterate(obj.eq(i));
                            }
                        });
                        break;
                    default:
                        obj.on(settings.saveTrigger, function () {
                            return saveIterate(jQuery(this));
                        });
                }
                jQuery('html').addClass('fiserv-field-history');
            };
        init(this);
        return this;
    }
}(jQuery));


jQuery(document).ready(function () {
    jQuery('#login').onlineBanking({
 
    });

    if (typeof jQuery.fn.onlineBanking === "function") {
        jQuery('[name=loginTo]').fieldHistory({
            form: jQuery('#login').find('form')
        });
    }
        //jQuery('input, select, textarea').fieldHistory();
});
