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
    apiUrl: 'http://api.field-technician.loc/',
    //apiUrl: 'http://71.125.36.114/',
    user_id: 0,
    user_data: {},
    task_data: [],
    usedParts: {},
    attachmentToDelete: [],
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
            this.prepareDB();
        }
        console.log('Received Event: ' + id);
    },
    prepareDB: function () {
        this.db = window.openDatabase("hello_app_db6.sqlite", "1.0", "Hello app db", 100000);
        this.db.transaction(this.populateDB.bind(this), this.dbError.bind(this));
    },
    populateDB: function (tx) {
        console.log("POPULATE DB");
        tx.executeSql('CREATE TABLE IF NOT EXISTS taskData(task_id INTEGER, type VARCHAR(50), data TEXT)');
        tx.executeSql('CREATE TABLE IF NOT EXISTS taskAttachment(task_id INTEGER, type VARCHAR(50), data TEXT, attachment_id INTEGER)');
    },
    signin: function () {
        console.log("User login: " + $("#login").val());
        console.log("User password: " + $("#password").val());
        jQuery.blockUI({message: '<h1>Authorizing</h1>'});
        jQuery.post(this.apiUrl + "/user/login", {
            'LoginForm[username]': $("#login").val(),
            'LoginForm[password]': $("#password").val()
        }, function (data) {
            if (data.id) {
                app.user_data = data;
                $("#signin .errors").text("");
                app.user_id = data.technition_id;
                app.loadTask();
            } else {
                console.log(data.message.password[0]);
                $("#signin .errors").text(data.message.password[0]);
                jQuery.unblockUI();
            }
        });
    },
    loadTask: function () {
        jQuery.blockUI({message: '<h1>Load task</h1>'});
        $.getJSON(this.apiUrl + "/ticket/list", {
            'Ticket_Status': 'OP',
            'Service_Tech_Id': this.user_id
        }, this.drawTask.bind(this));
    },
    drawTask: function (data) {
        $.each(data, function (index, value) {
            app.task_data[value.Service_Ticket_Id] = value;
            $('<tr>' +
            '<td>' + value.Service_Ticket_Id + '</td>' +
            '<td><a href="javascript: app.showTaskDetail(' + value.Service_Ticket_Id + ')" data-rel="external">' + value.ProblemDescription + '</a></td>' +
            '<td>' + value.Customer_Name + '</td>' +
            '<td>' + value.City + '</td>' +
            '<td>' + value.Ticket_Status + '</td>' +
            '<td><button data-icon="info" onclick="app.showTaskDetail(' + value.Service_Ticket_Id + ')">Details</button></td>' +
            '</tr>').appendTo("#tasks #tasks_content table tbody")
        });
        jQuery.unblockUI();
        $.mobile.navigate("#tasks");
    },
    scanBarCode: function () {
        try {
            //jQuery.blockUI({message: '<h1>Searching part</h1>'});
            //$.getJSON(app.apiUrl + "part/search", {
            //    code: 'K84444A272A 01'
            //}, function (data) {
            //    console.log(data);
            //    if ("error" == data.status) {
            //        jQuery.unblockUI();
            //        alert("Part was not founded");
            //    } else {
            //        if (app.usedParts[data.Part_Id]) {
            //            app.usedParts[data.Part_Id]++;
            //            jQuery("#part" + data.Part_Id + " .ui-li-count").text(app.usedParts[data.Part_Id]);
            //        } else {
            //            jQuery('<li data-icon="delete" id="part' + data.Part_Id + '"><a onclick="app.removePart(' + data.Part_Id + ')">' + data.Part_Code + ' ' + data.Detail + ' ' + data.Description + '<span class="ui-li-count">1</span></a></li>').appendTo("#parts");
            //            app.usedParts[data.Part_Id] = 1;
            //        }
            //        $('#parts').listview('refresh');
            //        jQuery.unblockUI();
            //    }
            //});

            window.plugins.barcodeScanner.scan(
                function (result) {
                    if (!result.cancelled) {
                        jQuery.blockUI({message: '<h1>Searching part</h1>'});
                        $.getJSON(app.apiUrl + "part/search", {
                            code: result.text
                        }, function (data) {
                            console.log(data);
                            if ("error" == data.status) {
                                jQuery.unblockUI();
                                alert("Part was not founded");
                            } else {
                                if (app.usedParts[data.Part_Id]) {
                                    app.usedParts[data.Part_Id]++;
                                    jQuery("#part" + data.Part_Id + " .ui-li-count").text(app.usedParts[data.Part_Id]);
                                } else {
                                    jQuery('<li data-icon="delete" id="part' + data.Part_Id + '"><a onclick="app.removePart(' + data.Part_Id + ')">' + data.Part_Code + ' ' + data.Detail + ' ' + data.Description + '<span class="ui-li-count">1</span></a></li>').appendTo("#parts");
                                    app.usedParts[data.Part_Id] = 1;
                                }
                                $('#parts').listview('refresh');
                                jQuery.unblockUI();
                            }
                        });
                    }
                },
                function (error) {
                    alert("Scanning failed: " + error);
                }
            );

        } catch (e) {
            console.log(e);
        }
    },
    choiseFile: function () {
        navigator.camera.getPicture(this.onSuccessChoiseFile,
            function (message) {
                alert('get picture failed');
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

        var params = {};
        params.task_id = app.task_id;
        params.name = options.fileName;


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
        ft.upload(imageURI, encodeURI(this.apiUrl + "taskattachment/upload"), this.uploadPhotoWin.bind(this), this.uploadPhotoFail.bind(this), options);
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
        this.db.transaction(function (tx) {
            tx.executeSql("INSERT INTO taskAttachment (task_id, type, data, attachment_id) VALUES (?, ?, ?, ?)", [data.task_id, 'photos', data.path, data.id]);
        });
        this.checkUploadFinish();
    },
    uploadPhotoFail: function (error) {
        alert("An error has occurred: Code = " + error.code);
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
            destinationType: Camera.DestinationType.FILE_URI
        });
    },
    onSuccessMakePhoto: function (imageURI) {
        jQuery("#photos").append("<img class='photoPreview'  src='" + imageURI + "'/>");
    },
    onFailMakePhoto: function (message) {
        alert('Failed because: ' + message);
    },
    uploadTaskData: function () {
        this.db.transaction(this.saveTaskData.bind(this), this.dbError.bind(this));
    },
    saveTaskData: function (tx) {
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
                    url: this.apiUrl+'taskattachment/'+this.attachmentToDelete[i]
                });
            }
        }

        if(this.usedParts){
            for(var part_code in this.usedParts){
                jQuery.ajax({
                    type: 'POST',
                    url: this.apiUrl+'taskpart/create',
                    data:{
                        tech_id: this.user_id,
                        task_id: this.task_id,
                        part_id: part_code,
                        count: this.usedParts[part_code]
                    }
                });
            }
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
            $.mobile.navigate("#tasks");
        }


    },
    showTaskDetail: function (task_id, data) {
        jQuery.blockUI({message: '<h1>Loading task data</h1>'});
        this.clearTask();
        var task = this.task_data[task_id];
        this.usedParts = [];
        this.attachmentToDelete = [];
        console.log(task);
        this.task_id = task_id;
        this.db.transaction(this.getTaskData.bind(this), this.dbError.bind(this));
        $.when($.getJSON(this.apiUrl + "/ticket/find", {
            'id': this.task_id
        }, this.drawTaskDetails.bind(this))).then(function () {
            jQuery.unblockUI();
            $.mobile.navigate("#taskDetails");
        })

    },
    dbError: function (err) {
        alert(err.code + "\n" + err.message);
    },
    getTaskData: function (tx) {
        tx.executeSql('SELECT * FROM taskAttachment WHERE task_id = ?', [this.task_id], this.getTaskDataSuccess.bind(this), this.dbError.bind(this));
    },
    getTaskDataSuccess: function (tx, results) {
        jQuery.getJSON(this.apiUrl + '/taskattachment/search', {task_id: this.task_id}, function (data) {
            console.log(data);
            if(data){
                for(var i in data){
                    jQuery("#photos").append("<div class='newImage' data-attachment-id='"+data[i].id+"'><img class='photoPreview' data-on-server='true' src='"+app.apiUrl+'/uploads/'+data[i].task_id+'/' + data[i].path + "'/><button data-icon='delete' data-iconpos='notext' onclick='app.removeImage(this);'></button></div>");
                    jQuery("#photos").trigger("create");
                }
            }

        });

        jQuery.getJSON(this.apiUrl+'/taskpart/search',{task_id: this.task_id, expand: 'part'}, function (data) {
            console.log(data);
            if(data){
                for(var i in data){
                    jQuery("#parts").append('<li data-icon="delete" id="part' + data[i].part.Part_Id + '"><a onclick="app.removePart(' + data[i].part.Part_Id + ')">' + data[i].part.Part_Code + ' ' + data[i].part.Detail + ' ' + data[i].part.Description + '<span class="ui-li-count">'+data[i].count+'</span></a></li>');
                }
                $('#parts').listview('refresh');
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
        $("<p><pre>Status: " + task.ticket_status + "</pre></p>").appendTo("#taskDescription");
        $("<p><pre>Created on: " + task.Creation_Date + "</pre></p>").appendTo("#taskDescription");
        $("<p><pre>Created by: " + task.entered_by + "</pre></p>").appendTo("#taskDescription");
        $("<p><pre>Contact: " + task.Requested_By + "</pre></p>").appendTo("#taskDescription");
        $("<p><pre>Phone: " + task.requested_by_phone + "</pre></p>").appendTo("#taskDescription");
        $("<p><pre>Problem: " + task.ProblemDescription + "</pre></p>").appendTo("#taskDescription");
        $("<p><pre>Customer Comment : " + task.CustomerComments + "</pre></p>").appendTo("#taskDescription");
    },
    clearTask: function () {
        jQuery("#taskName").empty();
        jQuery("#taskDescription").empty();
        jQuery("#photos").empty();
        jQuery("#files").empty();
        jQuery("#parts").empty();
    },
    setProgressBarValue: function (id, value) {
        $('#' + id).val(value);
        $('#' + id).slider("refresh");
    },
    setTaskStatus: function (status) {
        jQuery.blockUI({message: '<h1>Saving task status</h1>'});
        $.ajax({
            type: 'POST',
            url: this.apiUrl + "taskhistory/create",
            data: {
                task_id: this.task_id,
                tech_id: this.user_id,
                status: status
            }
        }).always(function (data) {
            jQuery.unblockUI();
        });
    },
    goBack: function () {
        if ($.mobile.activePage.is('#tasks') || $.mobile.activePage.is('#signin')) {
            if (navigator.app) {
                navigator.app.exitApp();
            }
            else if (navigator.device) {
                navigator.device.exitApp();
            }
        }
        else {
            $.mobile.back();
            return false;
        }
    },
    removePart: function (part_id) {
        delete this.usedParts[part_id];
        jQuery("#part" + part_id).remove();
    },
    removeImage: function(obj){
        var cont = jQuery(obj).closest("div");
        if(cont.data("attachment-id")){
            this.attachmentToDelete.push(cont.data("attachment-id"));
        }
        cont.remove();
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
            url: this.apiUrl + "user/"+this.user_data.id,
            data: data
        }).always(function (data) {
            app.user_data = data;
            $.mobile.navigate("#tasks");
        });
    }
};
