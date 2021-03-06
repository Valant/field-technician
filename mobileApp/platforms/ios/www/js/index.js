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
    user_id: 0,
    task_data: [],
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
            console.log(data);
            if (data.id) {
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
            '<td><button onclick="app.showTaskDetail(' + value.Service_Ticket_Id + ')">Details</button></td>' +
            '</tr>').appendTo("#tasks #tasks_content table tbody")
        });
        jQuery.unblockUI();
        $.mobile.navigate("#tasks");
    },
    scanBarCode: function () {
        try {
            window.plugins.barcodeScanner.scan(
                function (result) {
                    if (!result.cancelled) {
                        jQuery("#barCodes").append("<p>Text: '" + result.text + "'. Format: '" + result.format + "'</p>");
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
        jQuery("#files").append("<img class='photoPreview'  src='" + imageURI + "'/>");
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

        this.db.transaction(function (tx) {
            console.log("start clear task");
            console.log('SELECT * FROM taskAttachment WHERE task_id = ' + app.task_id);
            tx.executeSql('SELECT * FROM taskAttachment WHERE task_id = ' + app.task_id, [], function (tx, results) {
                console.log("rows LENGTH: " + results.rows.length);
                for (var i = 0; i < results.rows.length; i++) {
                    console.log("TRY DELETE task attahcment: " + results.rows.item(i).attachment_id);
                    jQuery.ajax({
                        type: 'DELETE',
                        url: app.apiUrl + "taskAttachment/" + results.rows.item(i).attachment_id,
                        success: function () {
                            tx.executeSql("DELETE FROM taskAttachment WHERE attachment_id = ?", [results.rows.item(i).attachment_id]);
                        }
                    });
                }
            });
        }, this.dbError.bind(this));


        var filesList = [];

        tx.executeSql("DELETE FROM taskData WHERE task_id = " + this.task_id);
        tx.executeSql("DELETE FROM taskAttachment WHERE task_id = " + this.task_id);

        jQuery("#photos > img").each(function () {
            tx.executeSql("INSERT INTO taskData (task_id, type, data) VALUES (?, ?, ?)", [self.task_id, 'photos', jQuery(this).attr('src')]);
            filesList.push(jQuery(this).attr('src'));
        });
        jQuery("#files > img").each(function () {
            tx.executeSql("INSERT INTO taskData (task_id, type, data) VALUES (?, ?, ?)", [self.task_id, 'files', jQuery(this).attr('src')]);
            filesList.push(jQuery(this).attr('src'));
        });

        jQuery("#barCodes > p").each(function () {
            tx.executeSql("INSERT INTO taskData (task_id, type, data) VALUES (?, ?, ?)", [self.task_id, 'barCodes', jQuery(this).text()]);
        });
        this.setProgressBarValue(0);
        $("#progressBars").empty();
        $.mobile.navigate("#progress");
        this.needToUpload = filesList.length;
        this.uploaded = 0;
        $.each(filesList, function (key, val) {
            self.uploadPhoto(val, key);
        });

    },
    showTaskDetail: function (task_id, data) {
        jQuery.blockUI({message: '<h1>Loading task data</h1>'});
        this.clearTask();
        var task = this.task_data[task_id];
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
        for (var i = 0; i < results.rows.length; i++) {
            if (('photos' == results.rows.item(i).type) || ('files' == results.rows.item(i).type)) {
                jQuery("#" + results.rows.item(i).type).append("<img class='photoPreview' src='" + results.rows.item(i).data + "'/>");
            }
            if ('barCodes' == results.rows.item(i).type) {
                jQuery("#" + results.rows.item(i).type).append("<p>" + results.rows.item(i).data + "</p>");
            }
        }
    },
    drawTaskDetails: function (data) {
        data = data.shift();
        console.log(data);
        this.task_data[this.task_id] = data;
        var task = data;
        $("#taskName").text(task.ProblemDescription + ' - ' + task.Customer_Name);
        $("<p><b>Customer</b></p>").appendTo("#taskDescription");
        $("<p><span>" + task.business_name + "</span></p>").appendTo("#taskDescription");
        $("<p><span>" + task.Customer_Name + "</span></p>").appendTo("#taskDescription");
        $("<p><span>" + task.address_1 + "</span></p>").appendTo("#taskDescription");
        $("<p><span>" + task.ge1_description + "</span></p>").appendTo("#taskDescription");
        $("<p><span>" + task.ge2_short + "</span></p>").appendTo("#taskDescription");
        $("<p><span>" + task.ge3_description + "</span></p>").appendTo("#taskDescription");

        $("<p><b>Site</b></p>").appendTo("#taskDescription");
        $("<p><span>" + task.customer_number + "</span></p>").appendTo("#taskDescription");
        $("<p><span>" + task.Customer_Site_Address + "</span></p>").appendTo("#taskDescription");
        $("<p><span>" + task.Customer_Site_Ge1_Description + "</span></p>").appendTo("#taskDescription");
        $("<p><span>" + task.Customer_Site_Ge2_Short + "</span></p>").appendTo("#taskDescription");
        $("<p><span>" + task.Customer_Site_Ge3_Description + "</span></p>").appendTo("#taskDescription");

        $("<p><b>System Information</b></p>").appendTo("#taskDescription");
        $("<p><span>System Account: " + task.alarm_account + "</span></p>").appendTo("#taskDescription");
        $("<p><span>System Type: " + task.System_Description + "</span></p>").appendTo("#taskDescription");
        $("<p><span>Panel Type: " + task.System_Panel_Description + "</span></p>").appendTo("#taskDescription");
        $("<p><span>Site Phone: " + task.phone_1 + "</span></p>").appendTo("#taskDescription");
        $("<p><span>Cross Street: " + task.cross_street + "</span></p>").appendTo("#taskDescription");
        $("<p><span>System Comments: " + task.system_comments + "</span></p>").appendTo("#taskDescription");

        $("<p><b>Ticket Information</b></p>").appendTo("#taskDescription");
        $("<p><span>Status: " + task.ticket_status + "</span></p>").appendTo("#taskDescription");
        $("<p><span>Created on: " + task.Creation_Date + "</span></p>").appendTo("#taskDescription");
        $("<p><span>Created by: " + task.entered_by + "</span></p>").appendTo("#taskDescription");
        $("<p><span>Contact: " + task.Requested_By + "</span></p>").appendTo("#taskDescription");
        $("<p><span>Phone: " + task.requested_by_phone + "</span></p>").appendTo("#taskDescription");
        $("<p><span>Problem: " + task.ProblemDescription + "</span></p>").appendTo("#taskDescription");
        $("<p><span>Customer Comment : " + task.CustomerComments + "</span></p>").appendTo("#taskDescription");
    },
    clearTask: function () {
        jQuery("#taskName").empty();
        jQuery("#taskDescription").empty();
        jQuery("#photos").empty();
        jQuery("#files").empty();
        jQuery("#barCodes").empty();
    },
    setProgressBarValue: function (id, value) {
        $('#' + id).val(value);
        $('#' + id).slider("refresh");
    }


};
