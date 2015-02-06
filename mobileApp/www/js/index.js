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

        console.log('Received Event: ' + id);
    },
    prepareDB: function () {
        this.db = window.openDatabase("hello_app_db6.sqlite", "1.0", "Hello app db", 100000);
        this.db.transaction(this.populateDB.bind(this), this.dbError.bind(this));

        if(window.localStorage.getItem('tech_id')&&window.localStorage.getItem('access_token')){
            app.showLoader("Load user data");
            this.user_id =  window.localStorage.getItem('tech_id');
            jQuery.getJSON(this.apiUrl+"user/"+window.localStorage.getItem('user_id'),
                {'access-token':window.localStorage.getItem('access_token')},
                function(data){
                if(data){
                   if(typeof data.id != 'undefined') {
                       app.user_data = data;
                       app.access_token = data.auth_key;
                       app.loadTask();
                   }else{
                       app.logout();
                   }
               }
            });
        }
    },
    populateDB: function (tx) {
        //console.log("POPULATE DB");
        //tx.executeSql('CREATE TABLE IF NOT EXISTS taskData(task_id INTEGER, type VARCHAR(50), data TEXT)');
        //tx.executeSql('CREATE TABLE IF NOT EXISTS taskAttachment(task_id INTEGER, type VARCHAR(50), data TEXT, attachment_id INTEGER)');
    },
    signin: function () {
        //console.log("User login: " + $("#login").val());
        //console.log("User password: " + $("#password").val());

        app.showLoader("Authorize")
        jQuery.post(this.apiUrl + "/user/login", {
            'LoginForm[username]': $("#login").val(),
            'LoginForm[password]': $("#password").val()
        }, function (data) {
            if (data.id) {
                console.log('user login [OK]')
                app.user_data = data;
                window.localStorage.setItem('tech_id',data.technition_id);
                window.localStorage.setItem('user_id',data.id);
                window.localStorage.setItem('user_code',data.usercode);
                window.localStorage.setItem('access_token',data.auth_key);
                $("#signin .errors").text("");
                app.user_id = data.technition_id;
                app.user_code = data.usercode;
                app.access_token = data.auth_key;
                app.loadTask();
            } else {
                console.warn(data.message.password[0]);
                $("#signin .errors").text(data.message.password[0]);
                $.mobile.loading( "hide" );
            }
        });
    },
    loadTask: function () {
        app.showLoader("Load tasks");
        $.getJSON(this.apiUrl + "/ticket/list", {
            'access-token':this.access_token
        }, this.drawTask.bind(this));

        jQuery.getJSON(this.apiUrl+"/resolution/",{'per-page':200,'access-token':window.localStorage.getItem('access_token')},
            function(data){
                console.log('loading resolution statuses for "go back notes"');
                if(data){
                    $.each(data,function(key, el){
                        $("select#resolution_code").append('<option value="'+key+'">'+el.Description+'</option>')
                    });
            }
        });
    },
    saveGoBackNotes:function(){
        jQuery.ajax({
            type: 'POST',
            url: app.apiUrl+'/ticketnotes/create?access-token='+app.access_token,
            data:{
                Service_Ticket_Id:this.task_data[this.task_id].Service_Ticket_Id,
                UserCode: app.user_code,
                Entered_Date: moment().format("MMM DD YYYY HH:mm:ss A"),
                Notes: $('#resolution_notes').val()+', Status: '+$('#resolution_code').val()
            }
        }).always(function (dataResponse) {
            $.mobile.navigate('#tasks');
            $('#resolution_notes').val('');
            $('#resolution_code').val('');
        });
    },
    drawTask: function (data) {
        if($("#tasks #tasks_content table")) {
            $("#tasks #tasks_content table").table();
        }
        $("#tasks #tasks_content table tbody").empty();
        $.each(data, function (index, value) {
            app.task_data[value.Service_Ticket_Id] = value;
            $('<tr id="task'+value.Service_Ticket_Id+'">' +
                                                          '<td>' + value.Ticket_Number + '</td>' +
            '<td><a href="javascript: app.showTaskDetail(' + value.Service_Ticket_Id + ')" data-rel="external">' + value.ProblemDescription + '</a></td>' +
            '<td>' + value.Customer_Name + '</td>' +
            '<td>' + value.City + '</td>' +
            '<td>' + value.Ticket_Status + '</td>' +
            '<td><button data-icon="info" onclick="app.showTaskDetail(' + value.Service_Ticket_Id + ')">Details</button></td>' +
            '</tr>').appendTo("#tasks #tasks_content table tbody").closest( "table#table-custom-2" ).table( "refresh" ).trigger( "create" );
        });
        $("#tasks #tasks_content table").table("refresh");
        $.mobile.loading( "hide" );
        $.mobile.navigate("#tasks");
        navigator.notification && navigator.notification.vibrate(1000);
    },
    scanBarCode: function () {
        try {
            window.plugins.barcodeScanner.scan(
                function (result) {
                    if (!result.cancelled) {
                        var quantity = null

                        app.showLoader("Searching part")

                        $.getJSON(app.apiUrl + "part/search", {
                            code: result.text,
                            'access-token':app.access_token
                        }, function (data) {
                            console.log(data);
                            if ("error" == data.status) {
                                $.mobile.loading( "hide" );
                                navigator.notification.alert(
                                    'Part search',  // message
                                    false,         // callback
                                    'Part was not founded',            // title
                                    'OK'                  // buttonName
                                );
                            } else {
                                navigator.notification.prompt(
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
                                            jQuery("#part" + data.Part_Id + " .ui-li-count").text(app.usedParts[data.Part_Id]);
                                        } else {
                                            jQuery('<li data-icon="delete" id="part' + data.Part_Id + '"><a onclick="app.removePart(' + data.Part_Id + ')">' + data.Part_Code + ' ' + data.Detail + ' ' + data.Description + '<span class="ui-li-count">'+(quantity?quantity:1)+'</span></a></li>').appendTo("#parts");
                                            app.usedParts[data.Part_Id] = quantity?quantity:1;
                                        }
                                        $('#parts').listview('refresh');
                                        $.mobile.loading( "hide" );
                                        $.mobile.silentScroll($("#parts").offset().top);
                                        app.uploadTaskData(false);
                                    }
                                    ,                  // callback to invoke
                                    'Quantity',            // title
                                    ['Ok','Exit'],             // buttonLabels
                                    '1'                 // defaultText
                                );


                            }
                        });
                    }
                },
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
    choiseFile: function () {
        navigator.camera.getPicture(this.onSuccessChoiseFile,
            function (message) {
                //alert('get picture failed');
            },
            {
                quality: 50,
                destinationType: navigator.camera.DestinationType.FILE_URI,
                sourceType: navigator.camera.PictureSourceType.PHOTOLIBRARY
            }
        );
    },
    onSuccessChoiseFile: function (imageURI) {
        jQuery("#files").append("<div class='newImage'><img class='photoPreview'  src='" + imageURI + "'/><button data-icon='delete' data-iconpos='notext' onclick='app.removeImage(this);'></button></div>");
        jQuery("#files").trigger("create");
    },
    uploadPhoto: function (imageURI, id) {

        var options = new FileUploadOptions();
        options.fileKey = "path";
        options.fileName = imageURI.substr(imageURI.lastIndexOf('/') + 1);
        options.mimeType = "image/jpeg";
        options.chunkedMode = false;

        var params = {};
        params.task_id = app.task_id;
        params.name = options.fileName;
        params['access-token'] = app.access_token;

        options.params = params;
        console.log("options");
        console.log(imageURI);
        console.log(options);

        this.createProgressBar(id, options.fileName);

        var ft = new FileTransfer();
        var self = this;
        ft.onprogress = function (progressEvent) {
            if (progressEvent.lengthComputable) {
                var perc = Math.floor(progressEvent.loaded / progressEvent.total * 100);
                self.setProgressBarValue("slider_" + id, perc);
            }
        };
        ft.upload(imageURI, encodeURI(this.apiUrl + "taskattachment/upload?access-token="+app.access_token), this.uploadPhotoWin.bind(this), this.uploadPhotoFail.bind(this), options);
    },
    createProgressBar: function (id, text) {
        var cont = $("<div>");
        $("<p>").appendTo(cont).text(text);
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
        }).slider("refresh");
        cont.appendTo('#progressBars');
    },
    uploadPhotoWin: function (r) {
        var data = JSON.parse(r.response);
        console.log(JSON.parse(r.response));
        console.log("Code = " + r.responseCode);
        console.log("Response = " + r.response);
        console.log("Sent = " + r.bytesSent);
        //this.db.transaction(function (tx) {
        //    tx.executeSql("INSERT INTO taskAttachment (task_id, type, data, attachment_id) VALUES (?, ?, ?, ?)", [data.task_id, 'photos', data.path, data.id]);
        //});
        this.checkUploadFinish();
    },
    uploadPhotoFail: function (error) {
        navigator.notification.alert(
            'Upload error',  // message
            false,         // callback
            "An error has occurred: Code = " + error.code,            // title
            'OK'                  // buttonName
        );
        //alert("An error has occurred: Code = " + error.code);
        console.log(error);
        console.log("upload error source " + error.source);
        console.log("upload error target " + error.target);
        this.checkUploadFinish()
    },
    checkUploadFinish: function () {
        this.uploaded++;
        if (this.uploaded == this.needToUpload) {
            $.mobile.navigate("#tasks");
        }
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
    onSuccessMakePhoto: function (imageURI) {
        //new Parse.File("myfile.txt", { base64: imageURI });
        jQuery("#files").append("<div class='newImage'><img class='photoPreview'  src='" + imageURI + "'/><button data-icon='delete' data-iconpos='notext' onclick='app.removeImage(this);'></button></div>");
        jQuery("#files").trigger("create");
    },
    onFailMakePhoto: function (message) {
        //alert('Failed because: ' + message);
    },
    uploadTaskData: function (isExit) {
        this.db && this.db.transaction(this.saveTaskData(isExit).bind(this), this.dbError.bind(this));
    },
    saveTaskData: function (isExit) {
        var self = this;

        var filesList = [];

        jQuery("#photos > div > img:not([data-on-server])").each(function () {
            filesList.push(jQuery(this).attr('src'));
        });
        jQuery("#files > div > img:not([data-on-server])").each(function () {
            filesList.push(jQuery(this).attr('src'));
        });

        if(this.attachmentToDelete){
            for(var i in this.attachmentToDelete){
                jQuery.ajax({
                    type:'DELETE',
                    url: this.apiUrl+'taskattachment/'+this.attachmentToDelete[i]+'?access-token='+app.access_token
                });
            }
        }

        if(this.usedParts){
            $.when(jQuery.ajax({
                type: 'GET',
                url: this.apiUrl+'taskpart/empty',
                data: {
                    'access-token': app.access_token,
                    Service_Ticket_Id: this.task_id
                }
            })).done(function(){
                for(var part_id in app.usedParts){
                    jQuery.ajax({
                        type: 'POST',
                        url: app.apiUrl+'taskpart/create?access-token='+app.access_token,
                        data:{
                            Service_Tech_ID: app.user_id,
                            Service_Ticket_Id: app.task_id,
                            Part_Id: part_id,
                            Quantity: app.usedParts[part_id]
                        }
                    });
                }
            });

        }

        this.setProgressBarValue(0);
        $("#progressBars").empty();
        this.needToUpload = filesList.length;
        if (this.needToUpload) {
            $.mobile.navigate("#progress");
            //this.needToUpload = filesList.length;
            this.uploaded = 0;
            $.each(filesList, function (key, val) {
                self.uploadPhoto(val, key);
            });
        } else {
            if(isExit)
            $.mobile.navigate("#tasks");
        }


    },
    showTaskDetail: function (task_id, data) {
        app.showLoader("Loading task data")
        this.clearTask();
        var task = this.task_data[task_id];
        this.usedParts = [];
        this.attachmentToDelete = [];
        console.log(task);
        this.task_id = task_id;
        this.db && this.db.transaction(this.getTaskData.bind(this), this.dbError.bind(this));

        $.when($.getJSON(this.apiUrl + "/ticket/find", {
            'id': this.task_id,
            'access-token':this.access_token
        }, this.drawTaskDetails.bind(this))).done(function () {
            $.mobile.loading( "hide" );
            $.mobile.navigate("#taskDetails");
        })

    },
    dbError: function (err) {
        alert(err.code + "\n" + err.message);
    },
    getTaskData: function (tx) {

        jQuery.getJSON(this.apiUrl + '/taskattachment/search', {task_id: this.task_id,'access-token':this.access_token}, function (data) {
            if(data){
                for(var i in data){
                    jQuery("#photos").append("<div class='newImage' data-attachment-id='"+data[i].id+"'><img class='photoPreview' data-on-server='true' src='"+app.apiUrl+'/uploads/'+data[i].task_id+'/' + data[i].path + "'/><button data-icon='delete' data-iconpos='notext' onclick='app.removeImage(this);'></button></div>");
                    jQuery("#photos").trigger("create");
                }
            }

        });

        jQuery.getJSON(this.apiUrl+'/taskpart/search',{Service_Ticket_Id: this.task_id, expand: 'part','access-token':this.access_token}, function (data) {
            console.log(data);
            if(data){
                for(var i in data){
                    app.usedParts[data[i].part.Part_Id] = data[i].Quantity;
                    jQuery("#parts").append('<li data-icon="delete" id="part' + data[i].part.Part_Id + '"><a onclick="app.removePart(' + data[i].part.Part_Id + ')">' + data[i].part.Part_Code + ' ' + data[i].part.Detail + ' ' + data[i].part.Description + '<span class="ui-li-count">'+data[i].Quantity+'</span></a></li>');
                }
                $('#parts').listview('refresh');
            }
        });

        jQuery.getJSON(this.apiUrl+'ticket/getdispatch',{
            task_id: this.task_id,
            'access-token':this.access_token
        },function(data){
            app.task_data[data.Service_Ticket_Id]['dispatch_id'] = data.Dispatch_Id;
            if(moment(data.Dispatch_Time, "MMM DD YYYY HH:mm:ss0A").unix() > 0){

                $("#status_dispatch").addClass('ui-disabled');

                if(moment(data.Arrival_Time, "MMM DD YYYY HH:mm:ss0A").unix() > 0){
                    $("#status_arrived").addClass('ui-disabled');
                    if(moment(data.Depart_Time, "MMM DD YYYY HH:mm:ss0A").unix() > 0){
                        $("#status_depart").addClass('ui-disabled');
                    }else{
                        $("#status_depart,button[id^='task_btn_']").removeClass('ui-disabled');
                    }
                }else{
                    console.log("remove class for arrival");
                    $("#status_arrived").removeClass('ui-disabled');
                }
            }else{
                $("#status_dispatch").removeClass('ui-disabled');
            }

        });

    },
    drawTaskDetails: function (data) {
        data = data.shift();
        console.log(data);
        this.task_data[this.task_id] = data;
        var task = data;
        $("#taskName").text(task.ProblemDescription + ' - ' + task.Customer_Name);
        $("<h4>Customer</h4>").appendTo("#taskDescription");
        $("<p><pre>" + task.business_name + "</pre></p>").appendTo("#taskDescription");
        $("<p><pre>" + task.Customer_Name + "</pre></p>").appendTo("#taskDescription");
        $("<p><pre>" + task.address_1 + "</pre></p>").appendTo("#taskDescription");
        $("<p><pre>" + task.ge1_description + "</pre></p>").appendTo("#taskDescription");
        $("<p><pre>" + task.ge2_short + "</pre></p>").appendTo("#taskDescription");
        $("<p><pre>" + task.ge3_description + "</pre></p>").appendTo("#taskDescription");

        $("<h4>Site</h4>").appendTo("#taskDescription");
        $("<p><pre>" + task.customer_number + "</pre></p>").appendTo("#taskDescription");
        $("<p><pre>" + task.Customer_Site_Address + "</pre></p>").appendTo("#taskDescription");
        $("<p><pre>" + task.Customer_Site_Ge1_Description + "</pre></p>").appendTo("#taskDescription");
        $("<p><pre>" + task.Customer_Site_Ge2_Short + "</pre></p>").appendTo("#taskDescription");
        $("<p><pre>" + task.Customer_Site_Ge3_Description + "</pre></p>").appendTo("#taskDescription");

        $("<h4>System Information</h4>").appendTo("#taskDescription");
        $("<p><pre>System Account: " + task.alarm_account + "</pre></p>").appendTo("#taskDescription");
        $("<p><pre>System Type: " + task.System_Description + "</pre></p>").appendTo("#taskDescription");
        $("<p><pre>Panel Type: " + task.System_Panel_Description + "</pre></p>").appendTo("#taskDescription");
        $("<p><pre>Site Phone: " + task.phone_1 + "</pre></p>").appendTo("#taskDescription");
        $("<p><pre>Cross Street: " + task.cross_street + "</pre></p>").appendTo("#taskDescription");
        $("<p><pre>System Comments: " + task.system_comments + "</pre></p>").appendTo("#taskDescription");

        $("<h4>Ticket Information</h4>").appendTo("#taskDescription");
        $( "<p><pre>Ticket number: " + task.Ticket_Number + "</pre></p>" ).appendTo( "#taskDescription" );
        $("<p><pre>Status: " + task.ticket_status + "</pre></p>").appendTo("#taskDescription");
        $("<p><pre>Created on: " + task.Creation_Date + "</pre></p>").appendTo("#taskDescription");
        $("<p><pre>Created by: " + task.entered_by + "</pre></p>").appendTo("#taskDescription");
        $("<p><pre>Contact: " + task.Requested_By + "</pre></p>").appendTo("#taskDescription");
        $("<p><pre>Phone: " + task.requested_by_phone + "</pre></p>").appendTo("#taskDescription");
        $("<p><pre>Problem: " + task.ProblemDescription + "</pre></p>").appendTo("#taskDescription");
        $( "<p><pre>Customer Comment : </pre>" + task.CustomerComments + "</p>" ).appendTo( "#taskDescription" );
    },
    clearTask: function () {
        console.log('clear task')
        jQuery("#taskName").empty();
        jQuery("#taskDescription").empty();
        jQuery("#photos").empty();
        jQuery("#files").empty();
        jQuery("#parts").empty();
        $("#status_dispatch,#status_arrived,#status_depart").addClass('ui-disabled');
    },
    setProgressBarValue: function (id, value) {
        $('#' + id).val(value);
        $('#' + id).slider("refresh");
    },
    saveTaskStatus: function (taskStatusData) {
        app.showLoader("Saving task status");

        $.ajax({
            type: 'PUT',
            url: this.apiUrl + 'dispatch/' + this.task_data[this.task_id].dispatch_id + ',' + this.task_id + "?access-token=" + app.access_token,
            data: taskStatusData.data
        }).always(function (dataResponse) {
            console.log(dataResponse);
        });

        $.ajax({
            type: 'POST',
            url: this.apiUrl + "taskhistory/create?access-token=" + app.access_token,
            data: {
                task_id: this.task_id,
                tech_id: this.user_id,
                status: taskStatusData.status
            }
        }).always(function (dataResponse) {
            $.mobile.loading("hide");
            if (typeof dataResponse.id != 'undefined') {
                if ("dispatch" == dataResponse.status) {
                    app.showLoader("Saving task status");

                    $("#status_dispatch,#status_depart,button[id^='task_btn_']").addClass('ui-disabled');
                    $("#status_arrived").removeClass('ui-disabled');
                    jQuery.ajax({
                        type: 'PUT',
                        url: app.apiUrl + 'ticket/' + app.task_id + "?access-token=" + app.access_token,
                        data: {
                            Ticket_Status: 'IP'
                        }
                    }).always(function (data) {
                        $("#task" + data.Service_Ticket_Id).remove();
                        $.mobile.loading("hide");
                    });
                }else
                if ("arrived" == dataResponse.status) {
                    app.showLoader("Saving task status");

                    $("#status_dispatch, #status_arrived").addClass('ui-disabled');
                    $("#status_depart,button[id^='task_btn_']").removeClass('ui-disabled');

                    jQuery.ajax({
                        type: 'PUT',
                        url: app.apiUrl + 'ticket/' + app.task_id + '?access-token=' + app.access_token,
                        data: {
                            Ticket_Status: 'IP'
                        }
                    }).always(function (data) {
                        $.mobile.loading("hide");
                        console.log(data);
                    });
                }else
                if ('depart' == dataResponse.status) {
                    $("#status_dispatch,#status_arrived,#status_depart,button[id^='task_btn_']").addClass('ui-disabled');
                    app.showLoader("Saving task status");

                    navigator.notification.confirm("Select depart type", function (button) {
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
                                       $("#status_depart,button[id^='task_btn_']").removeClass('ui-disabled');
                                        $.mobile.loading("hide");

                                    } else
                                    if (2 == button) {
                                        app.showLoader("Saving task status");

                                        jQuery.ajax({
                                            type: 'PUT',
                                            url: app.apiUrl + 'ticket/' + app.task_id + "?access-token=" + app.access_token,
                                            data: {
                                                Ticket_Status: status
                                            }
                                        }).always(function (data) {
                                            $("#task" + data.Service_Ticket_Id).remove();
                                            $.mobile.loading("hide");
                                            $.mobile.navigate("#gobacknotes");
                                        });
                                    }
                                },
                                'Add material',
                                ['Yes', 'No']
                            );
                        }

                    }, "Depart type", ["Go back", "Resolved"])
                }
            } else {
                navigator.notification.alert(
                    'Time was saved',  // message
                    false,         // callback
                    'Time',            // title
                    'OK'                  // buttonName
                );
            }
        });
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
                    'Ready to go to ' + this.task_data[this.task_id].address_1, // message
                    function (button) {
                        if (1== button) {
                            canSetStatus = true;
                            data.Dispatch_Time = moment().format("MMM DD YYYY HH:mm:ss A");
                            data.Ticket_Status = 'IP';
                            app.saveTaskStatus({status:status,data:data, taskId:this.task_id});
                        }
                        else $.mobile.navigate("#tasks");
                    },            // callback to invoke with index of button pressed
                    'Dispatch?',           // title
                    ['Yes', 'No'] // buttonLabels
                );
                break;
            case 'arrived':
                navigator.notification.confirm(
                    'Arrived to ' + this.task_data[this.task_id].address_1, // message
                    function (button) {
                        if (button == 1) {
                            canSetStatus = true;
                            data.Arrival_Time = moment().format("MMM DD YYYY HH:mm:ss A");
                            app.saveTaskStatus({status:status,data:data, taskId:this.task_id});


                            navigator.notification.confirm(
                                'Place system on test?', // message
                                function (button) {
                                    if (1 == button) {
                                        app.launchMASMobile();
                                    }
                                },            // callback to invoke with index of button pressed
                                'MASMobile',           // title
                                ['Yes', 'No'] // buttonLabels
                            );
                            //app.saveTaskStatus(data);
                        }
                    },
                    'Arrived?',
                    ['Yes', 'No']
                );
                break;
            case 'depart':
                navigator.notification.confirm(
                    'Departure from ' + this.task_data[this.task_id].address_1, // message
                    function (button) {
                        if (1 == button) {
                            //canSetStatus = true;
                            data.Depart_Time = moment().format("MMM DD YYYY HH:mm:ss A");
                            app.saveTaskStatus({status:status,data:data, taskId:this.task_id});
                        }
                    },
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
                $.mobile.navigate("#signin");
            }
        }
        else {
            $.mobile.back();
            return false;
        }
    },
    removePart: function (part_id) {
        this.part_to_delete = part_id;
        navigator.notification.confirm(
            'Remove part from list', // message
            function(index){
                if(1 == index){
                    delete app.usedParts[app.part_to_delete];
                    jQuery("#part" + app.part_to_delete).remove();
                }
            },            // callback to invoke with index of button pressed
            'Part removing',           // title
            ['Yes','No']         // buttonLabels
        );

    },
    removeImage: function(obj){
        this.image_to_remove = obj;
        navigator.notification.confirm(
            'Remove photo from task', // message
            function(index){
                if(1 == index){
                    var obj = app.image_to_remove;
                    var cont = jQuery(obj).closest("div");
                    if(cont.data("attachment-id")){
                        app.attachmentToDelete.push(cont.data("attachment-id"));
                    }
                    cont.remove();
                }
            },            // callback to invoke with index of button pressed
            'Photo removing',           // title
            ['Yes','No']         // buttonLabels
        );


    },
    settings: function(){
        $("#username").val(this.user_data.username);
        $("#email").val(this.user_data.email);
        $("#newpassword").val("");
        $.mobile.navigate("#profile");
    },
    saveProfile:function(){
        var data = {};
        if($("#username").val()){
            data.username = $("#username").val();
        }
        if($("#email").val()){
            data.email = $("#email").val();
        }
        if($("#newpassword").val()){
            data.password_hash = $("#newpassword").val();
        }
        jQuery.ajax({
            type: 'PUT',
            url: this.apiUrl + "user/"+this.user_data.id+'?access-token='+app.access_token,
            data: data
        }).always(function (data) {
            app.user_data = data;
            $.mobile.navigate("#tasks");
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
        $("#login").val("");
        $("#password").val("");
        $("#tasks #tasks_content table tbody").empty();
        jQuery("#table-custom-2").table("refresh");
        $.mobile.navigate("#signin");
    },
    showLoader: function(message){
        $.mobile.loading( "show", {
            text: message,
            textVisible: true,
            textOnly: false,
            inline: true,
            theme: "b",
            html: ""
        });
    }
};
