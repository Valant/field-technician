/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */
var app = {
    db: false,
    task_id: false,
    uploaded: 0,
    needToUpload: 0,
    //apiUrl: 'http://api.field-technician.loc/',
    apiUrl: 'http://api.afa.valant.com.ua/',
    user_id: 0,
    user_code: '',
    user_data: {},
    task_data: [],
    usedParts: {},
    attachmentToDelete: [],
    part_to_delete: 0,
    image_to_remove: false,
    access_token: false,
    // Application Constructor
    initialize: function () {
        this.bindEvents();
    },
    // Bind Event Listeners
    //
    // Bind any events that are required on startup. Common events are:
    // 'load', 'deviceready', 'offline', and 'online'.
    bindEvents: function () {
        document.addEventListener('deviceready', this.onDeviceReady, false);
        //this.onDeviceReady();
    },
    // deviceready Event Handler
    //
    // The scope of 'this' is the event. In order to call the 'receivedEvent'
    // function, we must explicitly call 'app.receivedEvent(...);'
    onDeviceReady: function () {
        app.receivedEvent('deviceready');
    },
    // Update DOM on a Received Event
    receivedEvent: function (id) {
        if ('deviceready' == id) {
            StatusBar.overlaysWebView(false);
            this.prepareDB();
        }
        mobile_prompt = navigator.notification.prompt;
        if ('android' != cordova.platformId && undefined != window.plugins.iosNumpad)
        {
            mobile_prompt = window.plugins.iosNumpad.prompt;
        }

        console.log('Received Event: ' + id);
    },
    prepareDB: function () {
        this.db = window.openDatabase("hello_app_db6.sqlite", "1.0", "Hello app db", 100000);
        this.db.transaction(this.populateDB.bind(this), this.dbError.bind(this));

        if (window.localStorage.getItem('tech_id') && window.localStorage.getItem('access_token')) {
            this.showLoader('Load user data');
            app.user_id = window.localStorage.getItem('tech_id');
            jQuery.getJSON(app.apiUrl + 'user/' + window.localStorage.getItem('user_id'),
                {'access-token': window.localStorage.getItem('access_token')},
                function (data) {
                    if (data) {
                        if (typeof data.id != 'undefined') {
                            app.user_data = data;
                            app.access_token = data.auth_key;
                            app.loadTask();
                        } else {
                            app.logout();
                        }
                    }
                }.bind(this)
            );
        }
    },
    populateDB: function (tx) {

        //console.log('POPULATE DB');
        //tx.executeSql('CREATE TABLE IF NOT EXISTS taskData(task_id INTEGER, type VARCHAR(50), data TEXT)');
        //tx.executeSql('CREATE TABLE IF NOT EXISTS taskAttachment(task_id INTEGER, type VARCHAR(50), data TEXT, attachment_id INTEGER)');
    },
    signin: function () {
        //console.log('User login: ' + $('#login').val());
        //console.log('User password: ' + $('#password').val());
        this.showLoader('Authorize')
        jQuery.post(app.apiUrl + '/user/login', {
            'LoginForm[username]': $('#login').val(),
            'LoginForm[password]': $('#password').val()
        }, function (data) {
            if (data.id) {
                console.log('user login [OK]')
                app.user_data = data;
                window.localStorage.setItem('tech_id',data.technition_id);
                window.localStorage.setItem('user_id',data.id);
                window.localStorage.setItem('user_code',data.usercode);
                window.localStorage.setItem('access_token',data.auth_key);
                $('#signin .errors').text('');
                app.user_id = data.technition_id;
                app.user_code = data.usercode;
                app.access_token = data.auth_key;
                app.loadTask();
            } else {
                console.warn(data.message.password[0]);
                $('#signin .errors').text(data.message.password[0]);
                $.mobile.loading('hide');
            }
        });
    },
    loadTask: function () {
        app.showLoader('Load tasks');
        jQuery.getJSON(app.apiUrl + '/ticket/list', {
            'access-token':app.access_token
        }, this.drawTask);

        jQuery.getJSON(app.apiUrl+'/resolution/',{'per-page':200,'access-token':window.localStorage.getItem('access_token')},
            function(data){
                if(data){
                    $('select#resolution_code').empty();
                    $.each(data,function(key, el){
                        $('select#resolution_code').append('<option value="'+el.Resolution_Id+'">'+el.Description+'</option>')
                    });
            }
        });
    },
    saveGoBackNotes:function(){
        if($('#resolution_notes').val() && $('#resolution_code').val())
        {
            app.showLoader('Saving task status');
            jQuery.ajax({
            type: 'POST',
            url: app.apiUrl+'/ticketnotes/create?access-token='+app.access_token,
            data:{
                Service_Ticket_Id:app.task_data[app.task_id].Service_Ticket_Id,
                UserCode: app.user_code,
                Edit_UserCode: app.user_code,
                Entered_Date: moment().format('MMM DD YYYY HH:mm:ss A'),
                Edit_Date: moment().format('MMM DD YYYY HH:mm:ss A'),
                Notes: $('#resolution_notes').val()
            }
        }).always(function (dataResponse) {

                jQuery.ajax({
                    type: 'PUT',
                    url: app.apiUrl + 'ticket/' + app.task_id + '?access-token=' + app.access_token,
                    data: {
                        Resolution_Id: parseInt($('#resolution_code').val())
                    }
                }).always(function (data) {
                    $('#resolution_notes').val('');                         // clearing goback/resolved
                    $('#resolution_code option').attr('selected',false);    // resolution notes
                    $('#resolution_code').selectmenu( 'refresh', true );    // values
                    $('#task' + data.Service_Ticket_Id).remove();
                    $.mobile.loading('hide');
                    $.mobile.navigate('#tasks');
                });

        });
        } else{
            navigator.notification.alert(
                'Required fields are empty',                    // message
                false,                                          // callback
                'Please select resolution status and add notes',// title
                'OK'                                            // buttonName
            );
        }
    },
    drawTask: function (data) {
        if($('#tasks #tasks_content table')) {
            $('#tasks #tasks_content table').table();
        }
        $('#tasks #tasks_content table tbody').empty();
        $.each(data, function (index, value) {
            console.info(value)
            app.task_data[value.Service_Ticket_Id] = value;
            $('<tr id="task'+value.Service_Ticket_Id+'">' +
            '<td>' + value.Ticket_Number + '</td>' +
            '<td><a href="javascript: app.showTaskDetail(' + value.Service_Ticket_Id + ');" data-rel="external">' + value.ProblemDescription + '</a></td>' +
            '<td>' + value.Customer_Name + '</td>' +
            '<td>' + value.City + '</td>' +
            '<td>' + value.Ticket_Status + '</td>' +
            '<td><button data-icon="info" onclick="app.showTaskDetail(' + value.Service_Ticket_Id + ')">Details</button></td>' +
            '</tr>').appendTo('#tasks #tasks_content table tbody').closest('table#table-custom-2').table('refresh').trigger('create');
        });
        $('#tasks #tasks_content table').table('refresh');
        $.mobile.loading('hide');
        $.mobile.navigate('#tasks');
        navigator.notification && navigator.notification.vibrate(1000);
    },
    addMaterial: function () {
        navigator.notification.confirm(
            'Add Material',
            function (button) {
                if (1 == button) {
                    this.scanBarCode();
                }
                else if (2 == button) {

                    mobile_prompt(
                        'Please enter material code',  // message
                        function (results) {
                            if (2 != results.buttonIndex)
                                this.searchPart(results.input1)
                        }.bind(this)
                    );
                }
            }.bind(this),
            'Add material',
            ['Scan barcode', 'Enter code'] // buttonLabels
        );
    },
    searchPart: function (materialCode) {
        this.showLoader('Searching part')
        var self = this
        jQuery.getJSON(app.apiUrl + 'part/search', {
            code: materialCode,
            'access-token':app.access_token
        }, function (data) {
            if ('error' == data.status) {
                $.mobile.loading('hide');
                navigator.notification.alert(
                    'Part search',  // message
                    false,         // callback
                    'Part was not founded',            // title
                    'OK'                  // buttonName
                );
            } else {
                mobile_prompt(
                    'Please enter quantity',  // message
                    function (results) {
                        if(parseInt(results.input1)!=NaN){
                            quantity = parseInt(results.input1);
                        }else{
                            navigator.notification.alert(
                                'Please enter only numbers',  // message
                                false,         // callback
                                'Is not  number',            // title
                                'OK'                  // buttonName
                            );
                        }
                        if (app.usedParts[data.Part_Id]) {
                            if (quantity)
                                app.usedParts[data.Part_Id] += quantity;
                            else
                                app.usedParts[data.Part_Id]++;
                            $('#part' + data.Part_Id + ' .ui-li-count').text(app.usedParts[data.Part_Id]);
                        } else {
                            $('<li data-icon="delete" id="part' + data.Part_Id + '">' +
                            '<a onclick="app.removePart(' + data.Part_Id + ')">'
                            + data.Part_Code + ' ' + data.Detail + ' ' + data.Description +
                            '<span class="ui-li-count">'+(quantity?quantity:1)+'</span>' +
                            '</a></li>').appendTo('#parts');
                            app.usedParts[data.Part_Id] = quantity?quantity:1;
                        }
                        $('#parts').listview('refresh');
                        $.mobile.loading('hide');
                        $.mobile.silentScroll($('#parts').offset().top);
                        self.uploadTaskData();
                    }.bind(this)
                    ,                  // callback to invoke
                    'Quantity',            // title
                    ['Ok','Exit'],             // buttonLabels
                    '1'                 // defaultText
                );


            }
        }.bind(this));
    },
    scanBarCode: function () {
        var scanner = cordova.require('com.phonegap.plugins.barcodescanner.barcodescanner'); // ver.0.6.0
        try {
            scanner.scan(
                function (result) {
                    if (!result.cancelled) {
                        var quantity = null
                        this.searchPart(result.text);

                    }
                }.bind(this),
                function (error) {
                    navigator.notification.alert(
                        'Scanning',  // message
                        false,         // callback
                        'Scanning failed',            // title
                        'OK'                  // buttonName
                    );
                }
            );

        } catch (e) {
            console.log(e);
        }
    },
    uploadPhoto: function (imageURI, id) {

        var options = new FileUploadOptions();
        options.fileKey = 'path';
        options.fileName = imageURI.substr(imageURI.lastIndexOf('/') + 1);
        options.mimeType = 'image/jpeg';
        options.chunkedMode = false;

        var params = {};
        params.task_id = app.task_id;
        params.name = options.fileName;
        params['access-token'] = app.access_token;
        options.params = params;
        console.log('options', options, imageURI );

        this.createProgressBar(id, options.fileName);

        var ft = new FileTransfer();
        var self = this;
        ft.onprogress = function (progressEvent) {
            if (progressEvent.lengthComputable) {
                var perc = Math.floor(progressEvent.loaded / progressEvent.total * 100);
                self.setProgressBarValue('slider_' + id, perc);
            }
        };
        ft.upload(imageURI, encodeURI(app.apiUrl + 'taskattachment/upload?access-token='+app.access_token), this.uploadPhotoWin.bind(this), this.uploadPhotoFail.bind(this), options);
    },
    createProgressBar: function (id, text) {
        var cont = $('<div>');
        $('<p>').appendTo(cont).text(text);
        $('<input>').appendTo(cont).attr({
            'name': 'slider_' + id,
            'id': 'slider_' + id,
            'data-highlight': 'true',
            'min': '0',
            'max': '100',
            'value': '50',
            'type': 'range'
        }).slider({
            create: function (event, ui) {
                $(this).parent().find('input').hide();
                $(this).parent().find('input').css('margin-left', '-9999px'); // Fix for some FF versions
                $(this).parent().find('.ui-slider-track').css('margin', '0 15px 0 15px');
                $(this).parent().find('.ui-slider-handle').hide();
            }
        }).slider('refresh');
        cont.appendTo('#progressBars');
    },
    uploadPhotoWin: function (r) {
        var data = JSON.parse(r.response);
        console.log(JSON.parse(r.response));
        console.log('Code = ' + r.responseCode);
        console.log('Response = ' + r.response);
        console.log('Sent = ' + r.bytesSent);
        //this.db.transaction(function (tx) {
        //    tx.executeSql('INSERT INTO taskAttachment (task_id, type, data, attachment_id) VALUES (?, ?, ?, ?)', [data.task_id, 'photos', data.path, data.id]);
        //});
        this.checkUploadFinish();
    },
    uploadPhotoFail: function (error) {
        navigator.notification.alert(
            'Upload error',  // message
            false,         // callback
            'An error has occurred: Code = ' + error.code,            // title
            'OK'                  // buttonName
        );
        //alert('An error has occurred: Code = ' + error.code);
        console.log(error);
        console.log('upload error source ' + error.source);
        console.log('upload error target ' + error.target);
        this.checkUploadFinish();
    },
    checkUploadFinish: function () {
        console.info('checkUploadFinish ',this.uploaded);
        if (this.uploaded == this.needToUpload) {
            console.info('this.uploaded == this.needToUpload ',this.uploaded);
            $.mobile.navigate('#tasks');
        }
        this.uploaded++;

    },
    choiseFile: function () {
        navigator.camera.getPicture(this.onSuccessMakePhoto, this.onFailMakePhoto,
            {
                quality: 50,
                destinationType: navigator.camera.DestinationType.FILE_URI,
                sourceType: navigator.camera.PictureSourceType.PHOTOLIBRARY
            }
        );
    },
    makePhoto: function () {
        navigator.camera.getPicture(this.onSuccessMakePhoto, this.onFailMakePhoto, {
            quality: 50,
            destinationType: navigator.camera.DestinationType.FILE_URI,
            encodingType: navigator.camera.EncodingType.JPEG,
            sourceType: navigator.camera.PictureSourceType.CAMERA,
            saveToPhotoAlbum: true,
            allowEdit:true
        });
    },
    onSuccessChoiseFile: function (imageURI) {
        console.info('choise', imageURI);
        $('#files').append('<div class="newImage">' +
        '<img class="photoPreview"  src="' + imageURI + '"/>' +
        '<button data-icon="delete" data-iconpos="notext" onclick="app.removeImage(this);"></button>' +
        '</div>');
        $('#files').trigger('create');
    },
    onSuccessMakePhoto: function (imageURI) {
        console.info('make', imageURI);

        console.info('success make photo', imageURI)
        //new Parse.File('myfile.txt', { base64: imageURI });
        $('#files').append('<div class="newImage"><img class="photoPreview"  src="' + imageURI + '"/>' +
        '<button data-icon="delete" data-iconpos="notext" onclick="app.removeImage(this);"></button>' +
        '</div>');
        $('#files').trigger('create');

    },
    onFailMakePhoto: function (message) {
        //alert('Failed because: ' + message);
    },
    uploadTaskData: function () {
        this.db && this.db.transaction(this.saveTaskData.bind(this), this.dbError.bind(this));
    },
    saveAndExit: function () {
        console.info('saveAndExit')
        this.saveTaskData();
        console.info('aftersaveTaskData')

        this.checkUploadFinish();
        console.info('aftercheckUploadFinish')

    },
    saveTaskData: function () {
        console.info('savetaskdata')
        var self = this;

        var filesList = [];

        $('#photos > div > img:not([data-on-server])').each(function () {
            filesList.push($(this).attr('src'));
        });
        $('#files > div > img:not([data-on-server])').each(function () {
            filesList.push($(this).attr('src'));
        });

        if (app.attachmentToDelete) {
            for (var i in app.attachmentToDelete) {
                jQuery.ajax({
                    type: 'DELETE',
                    url: app.apiUrl + 'taskattachment/' + app.attachmentToDelete[i] + '?access-token=' + app.access_token
                }).always(function(data){
                    console.info('delete done')
                    delete app.attachmentToDelete[i];
                })


            }
        }

        if (this.usedParts) {
            $.when(jQuery.ajax({
                    type: 'GET',
                    url: app.apiUrl + 'taskpart/empty',
                    data: {'access-token': app.access_token,'Service_Ticket_Id': app.task_id}
                })
            ).done(function () {
                    for (var part_id in app.usedParts) {
                        jQuery.ajax({
                            type: 'POST',
                            url: app.apiUrl + 'taskpart/create?access-token=' + app.access_token,
                            data: {
                                Service_Tech_ID: app.user_id,
                                Service_Ticket_Id: app.task_id,
                                Part_Id: part_id,
                                Quantity: app.usedParts[part_id]
                            }
                        });
                    }
                }.bind(this)
            );
        }
        this.setProgressBarValue(0);
        $('#progressBars').empty();

        this.needToUpload = filesList.length;
        console.info('app.needToUpload',app.needToUpload)

        if (this.needToUpload) {
            console.info('beforenavigate')
            $.mobile.navigate("#progress");
            $.each(filesList, function (key, val) {
                self.uploadPhoto(val, key);
            });
            this.uploaded = 0;
        }

    },
    showTaskDetail: function (task_id, data) {
        this.showLoader('Loading task data')
        this.clearTask();
        var task = app.task_data[task_id];
        app.usedParts = [];
        app.attachmentToDelete = [];
        console.log(task);
        app.task_id = task_id;
        this.db && this.db.transaction(this.getTaskData, this.dbError);

        $.when(jQuery.getJSON(app.apiUrl + '/ticket/find', {
            'id': app.task_id,
            'access-token':app.access_token
        }, this.drawTaskDetails.bind(this))).done(function (res) {
            $.mobile.loading('hide');
            if(res.length)
            {$.mobile.navigate('#taskDetails');}
        })

    },
    dbError: function (err) {
        alert(err.code + '\n' + err.message);
    },
    getTaskData: function (tx) {

        jQuery.getJSON(app.apiUrl + '/taskattachment/search', {task_id: app.task_id,'access-token':app.access_token}, function (data) {
            if(data){
                for(var i in data){
                    $('#photos').append(
                        '<div class="newImage" data-attachment-id="' + data[i].id + '" >' +
                            '<img class="photoPreview" ' +
                                'data-on-server="true" ' +
                                'src="' + app.apiUrl + '/uploads/' + data[i].task_id + '/' + data[i].path + '"/>' +
                            '<button data-icon="delete" data-iconpos="notext" onclick="app.removeImage(this);"></button>' +
                        '</div>');
                    $('#photos').trigger('create');
                }
            }

        });

        jQuery.getJSON(app.apiUrl + '/taskpart/search', {
            'Service_Ticket_Id': app.task_id,
            'expand': 'part',
            'access-token': app.access_token
        }, function (data) {
            if (data) {
                for (var i in data) {
                    app.usedParts[data[i].part.Part_Id] = data[i].Quantity;
                    $('#parts').append('<li data-icon="delete" id="part' + data[i].part.Part_Id + '">' +
                    '<a onclick="app.removePart(' + data[i].part.Part_Id + ')">'
                    + data[i].part.Part_Code + ' ' + data[i].part.Detail + ' ' + data[i].part.Description +
                    '<span class="ui-li-count">' + data[i].Quantity + '</span>' +
                    '</a>' +
                    '</li>');
                }
                $('#parts').listview('refresh');
            }
        }.bind(this));

        jQuery.getJSON(app.apiUrl+'ticket/getdispatch',{
            task_id: app.task_id,
            'access-token':app.access_token
        },function(data){
            app.task_data[data.Service_Ticket_Id]['Dispatch_Id'] = data.Dispatch_Id;
            if(moment(data.Dispatch_Time, 'MMM DD YYYY HH:mm:ss0A').unix() > 0){

                $('#status_dispatch').addClass('ui-disabled');

                if(moment(data.Arrival_Time, 'MMM DD YYYY HH:mm:ss0A').unix() > 0){
                    $('#status_arrived').addClass('ui-disabled');
                    if(moment(data.Departure_Time, 'MMM DD YYYY HH:mm:ss0A').unix() > 0){
                        $('#status_depart').addClass('ui-disabled');
                    }else{
                        $('#status_depart,button[id^="task_btn_"]').removeClass('ui-disabled');
                    }
                }else{
                    console.log('remove class for arrival');
                    $('#status_arrived').removeClass('ui-disabled');
                }
            }else{
                $('#status_dispatch').removeClass('ui-disabled');
            }

        }.bind(this));

    },
    drawTaskDetails: function (data) {
        console.info('drawTaskDetails', data);
        data = data.shift();

        if (undefined!=data) {
        console.info('drawTaskDetails shift', data);
        //this.task_data[this.task_id] = data; // here was error with rewriting task custom params
        $.extend(this.task_data[this.task_id], data);
        var task = data;

            $('#taskName').text(task.ProblemDescription + ' - ' + task.Customer_Name);

            $('<h4>Customer</h4>').appendTo('#taskDescription');
            $('<p><pre>' + task.business_name + '</pre></p>').appendTo('#taskDescription');
            $('<p><pre>' + task.Customer_Name + '</pre></p>').appendTo('#taskDescription');
            $('<p><pre>' + task.address_1 + '</pre></p>').appendTo('#taskDescription');
            $('<p><pre>' + task.ge1_description + '</pre></p>').appendTo('#taskDescription');
            $('<p><pre>' + task.ge2_short + '</pre></p>').appendTo('#taskDescription');
            $('<p><pre>' + task.ge3_description + '</pre></p>').appendTo('#taskDescription');

            $('<h4>Site</h4>').appendTo('#taskDescription');
            $('<p><pre>' + task.customer_number + '</pre></p>').appendTo('#taskDescription');
            $('<p><pre>' + task.Customer_Site_Address + '</pre></p>').appendTo('#taskDescription');
            $('<p><pre>' + task.Customer_Site_Ge1_Description + '</pre></p>').appendTo('#taskDescription');
            $('<p><pre>' + task.Customer_Site_Ge2_Short + '</pre></p>').appendTo('#taskDescription');
            $('<p><pre>' + task.Customer_Site_Ge3_Description + '</pre></p>').appendTo('#taskDescription');

            $('<h4>System Information</h4>').appendTo('#taskDescription');
            $('<p><pre>System Account: ' + task.alarm_account + '</pre></p>').appendTo('#taskDescription');
            $('<p><pre>System Type: ' + task.System_Description + '</pre></p>').appendTo('#taskDescription');
            $('<p><pre>Panel Type: ' + task.System_Panel_Description + '</pre></p>').appendTo('#taskDescription');
            $('<p><pre>Site Phone: ' + task.phone_1 + '</pre></p>').appendTo('#taskDescription');
            $('<p><pre>Cross Street: ' + task.cross_street + '</pre></p>').appendTo('#taskDescription');
            $('<p><pre>System Comments: ' + task.system_comments + '</pre></p>').appendTo('#taskDescription');

            $('<h4>Ticket Information</h4>').appendTo('#taskDescription');
            $('<p><pre>Ticket number: ' + task.Ticket_Number + '</pre></p>').appendTo('#taskDescription');
            $('<p><pre>Status: ' + task.ticket_status + '</pre></p>').appendTo('#taskDescription');
            $('<p><pre>Created on: ' + task.Creation_Date + '</pre></p>').appendTo('#taskDescription');
            $('<p><pre>Created by: ' + task.entered_by + '</pre></p>').appendTo('#taskDescription');
            $('<p><pre>Contact: ' + task.Requested_By + '</pre></p>').appendTo('#taskDescription');
            $('<p><pre>Phone: ' + task.requested_by_phone + '</pre></p>').appendTo('#taskDescription');
            $('<p><pre>Problem: ' + task.ProblemDescription + '</pre></p>').appendTo('#taskDescription');
            $('<p><pre>Customer Comment : </pre>' + task.CustomerComments + '</p>').appendTo('#taskDescription');
        } else {

            navigator.notification.alert(
                'There is no data for this task',  // message
                function(res){
                    $.mobile.navigate('#tasks');
                },         // callback
                'Task loading error',            // title
                'OK'                  // buttonName
            );
        }
    },
    clearTask: function () {
        $('#taskName, #taskDescription, #photos, #files, #parts').empty();

        $('#status_dispatch,#status_arrived,#status_depart,button[id^="task_btn_"]').addClass('ui-disabled');
    },
    setProgressBarValue: function (id, value) {
        $('#' + id).val(value);
        $('#' + id).slider('refresh');
    },
    saveTaskStatus: function (taskStatusData) {
        this.showLoader('Saving task status');
        jQuery.ajax({
            type: 'PUT',
            url: app.apiUrl + 'dispatch/' + app.task_data[app.task_id].Dispatch_Id + ',' + app.task_id + '?access-token=' + app.access_token,
            data: taskStatusData.data
        }).always(function (dataResponse) {
            console.log(dataResponse);
        });

        jQuery.ajax({
            type: 'POST',
            url: app.apiUrl + 'taskhistory/create?access-token=' + app.access_token,
            data: {
                task_id: app.task_id,
                tech_id: app.user_id,
                status: taskStatusData.status
            }
        }).always(function (dataResponse) {
            $.mobile.loading('hide');
            if (typeof dataResponse.id != 'undefined') {
                if ('dispatch' == dataResponse.status) {
                    this.showLoader('Saving task status');
                    $('#status_dispatch,#status_depart,button[id^="task_btn_"]').addClass('ui-disabled');
                    $('#status_arrived').removeClass('ui-disabled');
                    jQuery.ajax({
                        type: 'PUT',
                        url: app.apiUrl + 'ticket/' + app.task_id + '?access-token=' + app.access_token,
                        data: {
                            Ticket_Status: 'IP'
                        }
                    }).always(function (data) {
                        //$('#task' + data.Service_Ticket_Id).remove();
                        $.mobile.loading('hide');
                    });
                }else
                if ('arrived' == dataResponse.status) {
                    this.showLoader('Saving task status');

                    $('#status_dispatch, #status_arrived').addClass('ui-disabled');
                    $('#status_depart,button[id^="task_btn_"]').removeClass('ui-disabled');

                    jQuery.ajax({
                        type: 'PUT',
                        url: app.apiUrl + 'ticket/' + app.task_id + '?access-token=' + app.access_token,
                        data: {
                            Ticket_Status: 'IP'
                        }
                    }).always(function (data) {
                        $.mobile.loading('hide');
                    });
                }else
                if ('depart' == dataResponse.status) {
                    $('#status_dispatch,#status_arrived,#status_depart,button[id^="task_btn_"]').addClass('ui-disabled');
                    this.showLoader('Saving task status');

                    navigator.notification.confirm('Select depart type', function (button) {
                        var status = false;
                        if (1 == button) {
                            status = 'GB';
                        } else if (2 == button) {
                            status = 'RS';
                        }
                        if (status) {
                            navigator.notification.confirm('Do you need to add material?',
                                function (button) {
                                    if (1 == button) {
                                        $('#status_depart,button[id^="task_btn_"]').removeClass('ui-disabled');
                                        $.mobile.loading('hide');
                                    } else
                                    if (2 == button) {
                                        app.showLoader('Saving task status');
                                        var data = taskStatusData.data;
                                        data.Ticket_Status = status;
                                        jQuery.ajax({
                                            type: 'PUT',
                                            url: app.apiUrl + 'ticket/' + app.task_id + '?access-token=' + app.access_token,
                                            data: data
                                        }).always(function (data) {
                                            $('#task' + data.Service_Ticket_Id).remove();
                                            $.mobile.loading('hide');
                                            $.mobile.navigate('#gobacknotes');
                                        });
                                    }
                                },
                                'Add material',
                                ['Yes', 'No']
                            );
                        }

                    }, 'Depart type', ['Go back', 'Resolved'])
                }
            } else {
                navigator.notification.alert(
                    'Time was saved',  // message
                    false,         // callback
                    'Time',            // title
                    'OK'                  // buttonName
                );
            }
        }.bind(this));
    },
    launchMASMobile: function(){
        if('android'==cordova.platformId)
            window.plugins.launcher.launch({packageName:'com.mas.masmobile'},function(data){console.log(data)},function(data){console.log(data)});
        else
            window.plugins.launcher.launch({packageName:'com.mas.masmobile'},function(data){console.log(data)},function(data){console.log(data)});
    },
    setTaskStatus: function (status) {
        var canSetStatus = false;
        var data = {};
        switch (status) {
            case 'dispatch':
                navigator.notification.confirm(
                    'Ready to go to ' + app.task_data[app.task_id].address_1, // message
                    function (button) {
                        if (1 == button) {
                            canSetStatus = true;
                            // reset time to 0 in unixtime (for debug)
                            //data.Dispatch_Time = 'Jan 1 1970 2:00:00 AM';
                            //data.Arrival_Time = 'Jan 1 1970 2:00:00 AM';
                            //data.Departure_Time = 'Jan 1 1970 2:00:00 AM';
                            data.Dispatch_Time = moment().format('MMM DD YYYY HH:mm:ss A');
                            data.Arrival_Time = 'Jan 1 1970 2:00:00 AM';// reset to 0 in unixtime
                            data.Departure_Time = 'Jan 1 1970 2:00:00 AM';// reset to 0 in unixtime
                            data.Ticket_Status = 'IP';
                            this.saveTaskStatus({status: status, data: data, taskId: app.task_id});
                        } else {
                            $.mobile.navigate('#tasks');
                        }
                    }.bind(this),            // callback to invoke with index of button pressed
                    'Dispatch?',           // title
                    ['Yes', 'No'] // buttonLabels
                );
                break;
            case 'arrived':
                navigator.notification.confirm(
                    'Arrived to ' + app.task_data[app.task_id].address_1, // message
                    function (button) {
                        if (button == 1) {
                            canSetStatus = true;
                            data.Arrival_Time = moment().format('MMM DD YYYY HH:mm:ss A');
                            data.Departure_Time = 'Jan 1 1970 2:00:00 AM';// reset to 0 in unixtime
                            this.saveTaskStatus({status:status,data:data, taskId:app.task_id});
                            navigator.notification.confirm(
                                'Place system on test?', // message
                                function (button) {
                                    if (1 == button) {
                                        this.launchMASMobile();
                                    }
                                },            // callback to invoke with index of button pressed
                                'MASMobile',           // title
                                ['Yes', 'No'] // buttonLabels
                            );
                            //app.saveTaskStatus(data);
                        }
                    }.bind(this),
                    'Arrived?',
                    ['Yes', 'No']
                );
                break;
            case 'depart':
                navigator.notification.confirm(
                    'Departure from ' + app.task_data[app.task_id].address_1, // message
                    function (button) {
                        if (1 == button) {
                            //canSetStatus = true;
                            data.Departure_Time = moment().format('MMM DD YYYY HH:mm:ss A');
                            this.saveTaskStatus({status:status,data:data, taskId:app.task_id});
                        }
                    }.bind(this),
                    'Departure?',
                    ['Yes', 'No']
                );
                break;
        }
    },
    goBack: function () {
        if ($.mobile.activePage.is('#tasks') || $.mobile.activePage.is('#signin')) {
            if (navigator.app) {
                navigator.app.exitApp();
            }
            else if (navigator.device) {
                navigator.device.exitApp();
            }else{
                window.localStorage.clear();
                $.mobile.navigate('#signin');
            }
        }
        else {
            $.mobile.back();
            return false;
        }
    },
    removePart: function (part_id) {
        app.part_to_delete = part_id;
        navigator.notification.confirm(
            'Remove part from list', // message
            function(index){
                if(1 == index){
                    delete app.usedParts[app.part_to_delete];
                    $('#part' + app.part_to_delete).remove();
                }
            },            // callback to invoke with index of button pressed
            'Part removing',           // title
            ['Yes','No']         // buttonLabels
        );

    },
    removeImage: function(obj){
        app.image_to_remove = obj;
        navigator.notification.confirm(
            'Remove photo from task', // message
            function(index){
                if(1 == index){
                    var obj = app.image_to_remove;
                    var cont = $(obj).closest('div');
                    if(cont.data('attachment-id')){
                        app.attachmentToDelete.push(cont.data('attachment-id'));
                    }
                    cont.remove();
                }
            },            // callback to invoke with index of button pressed
            'Photo removing',           // title
            ['Yes','No']         // buttonLabels
        );


    },
    settings: function(){
        $('#username').val(app.user_data.username);
        $('#email').val(app.user_data.email);
        $('#newpassword').val('');
        $.mobile.navigate('#profile');
    },
    saveProfile:function(){
        var data = {};
        if($('#username').val()){
            data.username = $('#username').val();
        }
        if($('#email').val()){
            data.email = $('#email').val();
        }
        if($('#newpassword').val()){
            data.password_hash = $('#newpassword').val();
        }
        jQuery.ajax({
            type: 'PUT',
            url: app.apiUrl + 'user/'+app.user_data.id+'?access-token='+app.access_token,
            data: data
        }).always(function (data) {
            app.user_data = data;
            $.mobile.navigate('#tasks');
            navigator.notification.alert(
                'Profile was saved',  // message
                false,         // callback
                'Profile',            // title
                'OK'                  // buttonName
            );
        });
    },
    logout: function(){
        window.localStorage.clear();
        $('#login').val('');
        $('#password').val('');
        $('#tasks #tasks_content table tbody').empty();
        $('#table-custom-2').table('refresh');
        $.mobile.navigate('#signin');
    },
    showLoader: function(message){
        $.mobile.loading( 'show', {
            text: message,
            textVisible: true,
            textOnly: false,
            inline: true,
            theme: 'b',
            html: ''
        });
    }
};
