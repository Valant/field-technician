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
        console.log("Prepare db");
        console.log("CREATE DB")
        this.db = window.openDatabase("hello_app_db4.sqlite", "1.0", "Hello app db", 100000);
        console.log("CREATE TABLE")
        this.db.transaction(this.populateDB.bind(this), this.dbError.bind(this));
    },
    populateDB: function (tx) {
        console.log("POPULATE DB");
        tx.executeSql('CREATE TABLE IF NOT EXISTS taskData(task_id INTEGER, type VARCHAR(50), data TEXT)');
    },
    signin: function () {
        console.log("User login: " + $("#login").val());
        console.log("User password: " + $("#password").val());
        $.mobile.navigate("#tasks");
    },
    scanBarCode: function () {
        console.log("START SCAN");

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
        options.fileKey = "file";
        options.fileName = imageURI.substr(imageURI.lastIndexOf('/') + 1);
        options.mimeType = "image/jpeg";

        var params = {};
        params.value1 = "test";
        params.value2 = "param";


        options.params = params;
        console.log("options");
        console.log(options);

        this.createProgressBar(id, options.fileName);

        var ft = new FileTransfer();
        var self = this;
        ft.onprogress = function(progressEvent) {
            if (progressEvent.lengthComputable) {
                var perc = Math.floor(progressEvent.loaded / progressEvent.total * 100);
                self.setProgressBarValue("slider_"+id,perc);
            }
        };
        ft.upload(imageURI, encodeURI("http://mapmobility.z.valant.com.ua/upload.php"), this.uploadPhotoWin.bind(this), this.uploadPhotoFail.bind(this), options);
    },
    createProgressBar: function(id, text){
        var cont = $("<div>");
        $("<p>").appendTo(cont).text(text);
        $('<input>').appendTo(cont).attr({'name':'slider_'+id,'id':'slider_'+id,'data-highlight':'true','min':'0','max':'100','value':'50','type':'range'}).slider({
            create: function( event, ui ) {
                $(this).parent().find('input').hide();
                $(this).parent().find('input').css('margin-left','-9999px'); // Fix for some FF versions
                $(this).parent().find('.ui-slider-track').css('margin','0 15px 0 15px');
                $(this).parent().find('.ui-slider-handle').hide();
            }
        }).slider("refresh");
        cont.appendTo('#progressBars');
    },
    uploadPhotoWin: function (r) {
        console.log(r);
        console.log("Code = " + r.responseCode);
        console.log("Response = " + r.response);
        console.log("Sent = " + r.bytesSent);
        this.checkUploadFinish();
    },
    uploadPhotoFail: function (error) {
        alert("An error has occurred: Code = " + error.code);
        console.log("upload error source " + error.source);
        console.log("upload error target " + error.target);
        this.checkUploadFinish()
    },
    checkUploadFinish: function(){
        this.uploaded++;
        if(this.uploaded == this.needToUpload){
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
        console.log("SAVED ID: " + this.task_id);
        var filesList = [];
        console.log("start del");
        tx.executeSql("DELETE FROM taskData WHERE task_id = " + this.task_id);
        console.log("del end");
        //tx.executeSql("INSERT INTO taskData (task_id, type, data) VALUES (?, ?, ?)", [this.task_id, 'photos', 'http://spynet.ru/uploads/images/07/00/55/2014/09/22/ff753a.jpg']);
        jQuery("#photos > img").each(function () {
            console.log("insert 1 star");
            tx.executeSql("INSERT INTO taskData (task_id, type, data) VALUES (?, ?, ?)", [self.task_id, 'photos', jQuery(this).attr('src')]);
            console.log("insert 1 end");
            filesList.push(jQuery(this).attr('src'));
            console.log("insert 1 push");
        });
        jQuery("#files > img").each(function () {
            console.log("insert 2 start");
            tx.executeSql("INSERT INTO taskData (task_id, type, data) VALUES (?, ?, ?)", [self.task_id, 'files', jQuery(this).attr('src')]);
            console.log("insert 2 end");
            filesList.push(jQuery(this).attr('src'));
            console.log("insert 2 push");
        });

        jQuery("#barCodes > p").each(function () {
            tx.executeSql("INSERT INTO taskData (task_id, type, data) VALUES (?, ?, ?)", [self.task_id, 'barCodes', jQuery(this).text()]);
        });
        console.log(filesList[0]);
        this.setProgressBarValue(0);
        $("#progressBars").empty();
        $.mobile.navigate("#progress");
        this.needToUpload = filesList.length;
        this.uploaded = 0;
        $.each(filesList, function(key, val){
            self.uploadPhoto(val, key);
        });

    },
    showTaskDetail: function (task_id) {
        console.log("Task ID: " + task_id);
        this.clearTask();
        this.task_id = task_id;
        this.db.transaction(this.getTaskData.bind(this), this.dbError.bind(this));
        $.mobile.navigate("#taskDetails");
    },
    dbError: function (err) {
        console.log("Error processing SQL: " + err.message);
        alert(err.code + "\n" + err.message);
    },
    getTaskData: function (tx) {
        console.log("this task " + this.task_id);
        tx.executeSql('SELECT * FROM taskData WHERE task_id = ?', [this.task_id], this.getTaskDataSuccess.bind(this), this.dbError.bind(this));
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
    clearTask: function () {
        jQuery("#photos").empty();
        jQuery("#files").empty();
        jQuery("#barCodes").empty();
    },
    setProgressBarValue: function(id, value){
        $('#'+id).val(value);
        $('#'+id).slider("refresh");
    }
};
