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
    version: '0.13.19',
    db: false,
    task_id: false,
    dispatch_id: false,
    uploaded: 0,
    needToUpload: 0,
    //apiUrl: 'http://api.field-technician.loc/',
//    apiUrl: 'http://ftapi.afap.com/',
    apiUrl: 'http://ftapitest.afap.com/',
    user_id: 0,
    user_code: '',
    service_tech_code: '',
    user_data: {},
    task_data: [],
    taskLocked: [],
    usedParts: {},
    user_warehouse_id: null,
    user_warehouse_code: null,
    attachmentToDelete: [],
    part_to_delete: 0,
    image_to_remove: false,
    access_token: false,
    departType: false,
    taskStatusData: null,
    // Application Constructor
    initialize: function ()
    {
        this.bindEvents();
    },
    // Bind Event Listeners
    //
    // Bind any events that are required on startup. Common events are:
    // 'load', 'deviceready', 'offline', and 'online'.
    bindEvents: function ()
    {
        document.addEventListener( 'deviceready', this.onDeviceReady, false );
        document.addEventListener("orientationchange", this.updateOrientation);

//         this.onDeviceReady();
    },
    // deviceready Event Handler
    //
    // The scope of 'this' is the event. In order to call the 'receivedEvent'
    // function, we must explicitly call 'app.receivedEvent(...);'
    onDeviceReady: function ()
    {
        app.receivedEvent( 'deviceready' );
    },
    // Update DOM on a Received Event
    receivedEvent: function ( id )
    {
        if ('deviceready' == id) {
            StatusBar.overlaysWebView( false );
            this.prepareDB();
        }
        mobile_prompt = navigator.notification.prompt;
        if ('android' != cordova.platformId && undefined != window.plugins.iosNumpad) {
            data.locked_length + ' minutes ago'
            mobile_prompt = window.plugins.iosNumpad.prompt;
        }

        console.log( 'Received Event: ' + id );
    },
    prepareDB: function ()
    {
        this.db = window.openDatabase( "hello_app_db6.sqlite", "1.0", "Hello app db", 100000 );
        this.db.transaction( this.populateDB.bind( this ), this.dbError.bind( this ) );

        if (window.localStorage.getItem( 'tech_id' ) && window.localStorage.getItem( 'access_token' )) {
            this.showLoader( 'Load user data' );
            app.user_id = window.localStorage.getItem( 'tech_id' );
            jQuery.getJSON( app.apiUrl + 'user/' + window.localStorage.getItem( 'user_id' ),
                {'access-token': window.localStorage.getItem( 'access_token' )},
                function ( data )
                {
                    if (data) {
                        if (typeof data.id != 'undefined') {
                            app.user_data = data;
                            app.user_code = data.usercode;
                            app.service_tech_code = data.servicetechcode;
                            app.access_token = data.auth_key;
                            app.user_warehouse_id = data.warehoise_id;
                            app.user_warehouse_code = data.warehouse_code;
                            app.loadTasks();
                            app.loadResolitons();

                        } else {
                            app.logout();
                        }
                    }
                }.bind( this )
            );
        }
    },
    populateDB: function ( tx )
    {

        //console.log('POPULATE DB');
        //tx.executeSql('CREATE TABLE IF NOT EXISTS taskData(task_id INTEGER, type VARCHAR(50), data TEXT)');
        //tx.executeSql('CREATE TABLE IF NOT EXISTS taskAttachment(task_id INTEGER, type VARCHAR(50), data TEXT, attachment_id INTEGER)');
    },
    signin: function ()
    {
        //console.log('User login: ' + $('#login').val());
        //console.log('User password: ' + $('#password').val());
        this.showLoader( 'Authorize' );
        jQuery.post( app.apiUrl + '/user/login', {
            'LoginForm[username]': $( '#login' ).val(),
            'LoginForm[password]': $( '#password' ).val()
        }, function ( data )
        {
            if (data.id) {
                console.log( 'user login [OK]' );
                app.user_data = data;
                window.localStorage.setItem( 'tech_id', data.technition_id );
                window.localStorage.setItem( 'user_id', data.id );
                window.localStorage.setItem( 'user_code', data.usercode );
                window.localStorage.setItem( 'access_token', data.auth_key );
                $( '#signin .errors' ).text( '' );
                app.user_id = data.technition_id;
                app.user_code = data.usercode;
                app.service_tech_code = data.servicetechcode;
                app.access_token = data.auth_key;
                app.user_warehouse_id = data.warehoise_id;
                app.user_warehouse_code = data.warehouse_code;
                app.loadTasks();
                app.loadResolitons();
            } else {
                console.warn( data.message.password[0] );
                $( '#signin .errors' ).text( data.message.password[0] );
                $.mobile.loading( 'hide' );
            }
        } );
    },
    loadTasks: function ()
    {
        app.showLoader( 'Load tasks' );
        jQuery.getJSON( app.apiUrl + '/ticket/list', {
            'access-token': app.access_token,
            'UserCode': app.user_code
        }, this.drawTask );


    },
    loadResolitons: function ()
    {
        jQuery.getJSON( app.apiUrl + '/resolution/', {'access-token': window.localStorage.getItem( 'access_token' ), 'sort':'Resolution_Code'},
            function ( data )
            {
                if (data) {
                    $( 'select#resolution_code' ).empty();
                    $.each( data, function ( key, el )
                    {
                        $( 'select#resolution_code' ).append(
                            '<option value="' + el.Resolution_Id + '">' + el.Description + '</option>' )
                    } );
                }
            } );
    },
    saveGoBackNotes: function ( withcode )
    {
        if (withcode == undefined) {
            withcode = 0;
        }
        if (app.taskStatusData) {
            if(withcode) {
                app.taskStatusData.data.Resolution_Code = $( '#resolution_code option:selected' ).text();
            }
            app.taskStatusData.data.Resolution_Notes = $( '#resolution_notes' + (withcode ? '_withcode' : '') ).val();
            app.depart( app.taskStatusData );

            if ($( '#resolution_notes' + (
                        withcode ? '_withcode' : ''
                    ) ).val()) {
                app.showLoader( 'Saving task status' );
                app.task_data[app.task_id].Resolution_Notes_Comment  = $( '#resolution_notes' + (
                        withcode ? '_withcode' : ''
                    ) ).val();
//                 jQuery.ajax( {
//                     type: 'POST',
//                     url: app.apiUrl + '/ticketnotes/create?access-token=' + app.access_token,
//                     data: {
//                         Service_Ticket_Id: app.task_data[app.task_id].Service_Ticket_Id,
//                         UserCode: app.user_code,
//                         Edit_UserCode: app.user_code,
//                         Ticket_Number: app.task_data[app.task_id].Ticket_Number,
//                         Entered_Date: moment().format( 'MMM DD YYYY HH:mm:ss A' ),
//                         Edit_Date: moment().format( 'MMM DD YYYY HH:mm:ss A' ),
//                         Notes: $( '#resolution_notes' + (
//                                 withcode ? '_withcode' : ''
//                             ) ).val()
//                     }
//                 } ).always( function ( dataResponse )
//                 {
                    var endNotes = function ( data )
                    {

                        app.showReceiptPage();

                        $( '#task' + data.Service_Ticket_Id ).remove();
                        $.mobile.loading( 'hide' );
//                        $.mobile.navigate( '#tasks' );

                        $( '#resolution_notes' + (
                                withcode ? '_withcode' : ''
                            ) ).val( '' );                         // clearing goback/resolved
                        $( '#resolution_code option' ).attr( 'selected', false );    // resolution notes
                        $( '#resolution_code' ).selectmenu( 'refresh', true );    // values
                    };
                    if (! withcode) {
                        endNotes( {Service_Ticket_Id: app.task_data[app.task_id].Service_Ticket_Id, resolved: withcode} );
                    } else {
                        jQuery.ajax( {
                            type: 'PUT',
                            url: app.apiUrl + 'ticket/' + app.task_id + '?access-token=' + app.access_token,
                            data: {
                                'Resolution_Id': parseInt( $( '#resolution_code' ).val() ),
                                'UserCode': app.user_code
                            }
                        } ).always( endNotes( {Service_Ticket_Id: app.task_data[app.task_id].Service_Ticket_Id, resolved: withcode} ) );
                    }

//                 } );
            } else {
                navigator.notification.alert(
                    'Required fields are empty',                    // message
                    false,                                          // callback
                    'Please select resolution status and add notes',// title
                    'OK'                                            // buttonName
                );
            }
        }

    },
    toggletasks: function ( el )
    {
        var $toggleRaw = $( el ).parents( 'tbody' );
        $( 'tr:not(:first)', $toggleRaw ).toggle();
        $toggleRaw.find( 'a' ).toggleClass( 'ui-icon-minus' );
        $toggleRaw.find( 'a' ).toggleClass( 'ui-icon-plus' );

    },
    drawTask: function ( data )
    {
        if ($( '#tasks #tasks_content table' )) {
            $( '#tasks #tasks_content table' ).table();
        }
        $( '#tasks #tasks_content table tbody' ).remove();

        var taskDay = null;
        $.each( data, function ( index, value )
        {

            if (value.LockedByUser != null && app.user_code != value.LockedByUser || (
                    app.user_code == value.LockedByUser && value.Form.toLowerCase() != 'mobile'
                )) {
                app.taskLocked[value.Service_Ticket_Id] = {user: value.LockedByUser, time: ''};
            } else {
                app.taskLocked[value.Service_Ticket_Id] = false;
            }
            var curDay = moment( value.Schedule_Time, 'MMM DD YYYY HH:mm:ss0A' ).format( 'MM/DD/YYYY' );
            var rawCurDayBegin = '';
            var rawCurDayEnd = '';
            var tglbtn = '<a data-role="button" data-icon="plus" data-iconpos="notext" data-theme="a" data-inline="true" class="ui-link ui-btn ui-btn-a ui-icon-plus ui-btn-icon-notext ui-btn-inline ui-shadow ui-corner-all" role="button">Show tasks</a>';
            if (curDay != taskDay) {

                rawCurDayBegin = '<tbody class="ui-collapsible row'+moment( value.Schedule_Time, 'MMM DD YYYY HH:mm:ss0A' ).format( 'MM_DD_YYYY' )+'" ><tr onclick="app.toggletasks(this)"><td><b>' + curDay + '</b>' + tglbtn + '</td></tr>';
                rawCurDayEnd = '</tbody>';
            }
            var taskTime = moment( value.Schedule_Time, 'MMM DD YYYY HH:mm:ss0A' ).format( 'HH:mm:ss' );

            app.task_data[value.Service_Ticket_Id] = value;

            var tr = $( rawCurDayBegin + '<tr id="task' + value.Service_Ticket_Id + '" onClick="app.showTaskDetail('+ value.Service_Ticket_Id +',' + value.Dispatch_Id + ');">' +
               '<td>' + taskTime + '</td>' +
               '<td>' + value.Ticket_Number + '</td>' +
               '<td><b>' + value.ProblemDescription + '</b></td>' +
               '<td>' + value.Customer_Name + '</td>' +
               '<td>' + value.City + '</td>' +
               '<td>' + value.Ticket_Status + '</td>' +
               //'<td><button data-icon="info" onclick="app.showTaskDetail(' + value.Service_Ticket_Id + ')">Details</button></td>' +
               '</tr>' + rawCurDayEnd );
            if(curDay != taskDay) {
                tr.appendTo( '#tasks #tasks_content table' ).closest( 'table#table-custom-2' ).table(
                    'refresh' ).trigger( 'create' );
            }else{
                tr.appendTo( '.row'+moment( value.Schedule_Time, 'MMM DD YYYY HH:mm:ss0A' ).format( 'MM_DD_YYYY' ) ).closest( 'table#table-custom-2' ).table(
                    'refresh' ).trigger( 'create' );
            }
            taskDay = curDay;
        } );
        $( '#tasks #tasks_content table' ).table( 'refresh' );

        $.mobile.loading( 'hide' );
        $.mobile.navigate('#tasks');
        $( '.ui-collapsible' ).find( 'tr:not(:first)' ).toggle();
        navigator.notification && navigator.notification.vibrate( 1000 );
    },
    addMaterial: function ()
    {
        navigator.notification.confirm(
            'Add Material',
            function ( button )
            {
                if (1 == button) {
                    this.scanBarCode();
                }
                else if (2 == button) {

                    $.mobile.navigate( '#partsearch' );
                    $( '#partsearch input' ).attr( 'type', 'text' );
                }
            }.bind( this ),
            'Add material',
            ['Scan barcode', 'Enter Material'] // buttonLabels
        );
    },
    addPartToTicket: function ( data )
    {
        mobile_prompt(
            'Please enter quantity',  // message
            function ( results )
            {
                if (results.buttonIndex == 1) {

                    if("0" == results.input1 ){
                        navigator.notification.alert(
                            'Please enter only numbers that more than 0',  // message
                            false,         // callback
                            'Incorrect value',            // title
                            'OK'                  // buttonName
                        );
                        return false;
                    }

                    if (parseInt( results.input1 ) != NaN) {
                        quantity = parseInt( results.input1 );
                        if(quantity < 1){
                            navigator.notification.alert(
                                'Please enter only numbers that more than 0',  // message
                                false,         // callback
                                'Incorrect value',            // title
                                'OK'                  // buttonName
                            );
                            return false;
                        }
                    } else {
                        navigator.notification.alert(
                            'Please enter only numbers',  // message
                            false,         // callback
                            'Is not  number',            // title
                            'OK'                  // buttonName
                        );
                        return false;
                    }

                    app.showLoader("Adding part...");
                    jQuery.ajax( {
                        type: 'POST',
                        url: app.apiUrl + 'taskpart/create?access-token=' + app.access_token,
                        data: {
                            'Service_Tech_ID': app.user_id,
                            'Service_Ticket_Id': app.task_id,
                            'Ticket_Number': app.task_data[app.task_id].Ticket_Number,
                            'Part_Id': data.Part_Id,
                            'Quantity': quantity,
                            'UserCode': app.user_code,
                            'ServiceTechCode': app.service_tech_code,
                            'Warehouse_Id': app.user_warehouse_id,
                            'Warehouse_Code': app.user_warehouse_code

                        }
                    } ).done(function(result){

                        if (app.usedParts[data.Part_Id]) {
                            if (quantity) {
                                app.usedParts[data.Part_Id] += quantity;
                            } else {
                                app.usedParts[data.Part_Id] ++;
                            }
                            $( '#part' + data.Part_Id + ' .ui-li-count' ).text( app.usedParts[data.Part_Id] );
                        } else {
                            $( '<li  id="part' + data.Part_Id + '">' +
                               '<a  data-inline="true" onclick="app.changePartQuantity(' + result.ServiceTicketPartId + ',' + data.Part_Id + ',' + result.Quantity + ',\'' + result.PartCode + '\',\'' + htmlEncode(data.Description) + '\'); return false;">'
                               + data.Part_Code + ' ' + htmlEncode(data.Description) +
                               '<span class="ui-li-count" >' + (
                                   quantity ? quantity : 1
                               ) + '</span>' +
                               '</a>'+
                               '<a onclick="app.removePart(' + data.Part_Id + ', '+ (quantity ? quantity : 1) +',' + result.ServiceTicketPartId + ')" class="delete">Delete</a>' +
                               '</li>' ).appendTo( '#parts' );
                            app.usedParts[data.Part_Id] = quantity ? quantity : 1;
                        }
                        $( '#parts' ).listview( 'refresh' );
                        jQuery( "#autocomplete" ).html( "" );
                        $( 'input[data-type="search"]' ).val( "" );
                        $.mobile.loading( 'hide' );
                        $.mobile.navigate( '#taskDetails' );
                        $.mobile.silentScroll( $( '#parts' ).offset().top );
//                        app.uploadTaskData();
                        $.mobile.loading( 'hide' );
                    });
                }
            }.bind( this ),                  // callback to invoke
            'Quantity',            // title
            ['Ok', 'Exit'],             // buttonLabels
            '1'                 // defaultText
        );
    },
    searchPart: function ( materialCode )
    {
        this.showLoader( 'Searching part' );
        var self = this;
        jQuery.getJSON( app.apiUrl + 'part/search', {
            code: materialCode,
            'access-token': app.access_token
        }, function ( data )
        {
            if ('error' == data.status) {
                $.mobile.loading( 'hide' );
                navigator.notification.alert(
                    'Part search',  // message
                    false,         // callback
                    'Part was not founded',            // title
                    'OK'                  // buttonName
                );
            } else {
                app.addPartToTicket( data )
            }
        }.bind( this ) );
    },
    keywordSuggestParts: function ( keyword, codesearch )
    {
        if (app.keywordAutocomplete) {
            app.keywordAutocomplete.abort()
        }
        if (codesearch == undefined) {
            codesearch = 0;
        }
        this.showLoader( 'Searching part' );
        var self = this;
        var sugList = jQuery( "#autocomplete" );
        sugList.html( "" );
        var searchpath = 'part/keyword';
//         if (codesearch == 1) {
//             var searchpath = 'part/codesearch';
//         }
        //$('input[data-type="search"]').val("")
        app.keywordAutocomplete = jQuery.getJSON( app.apiUrl + searchpath, {
            code: keyword,
            'access-token': app.access_token
        }, function ( data )
        {
            $.mobile.loading( 'hide' );
            if ('error' == data.status) {
                $.mobile.loading( 'hide' );
                navigator.notification.alert(
                    'Part search',  // message
                    false,         // callback
                    'Part was not founded',            // title
                    'OK'                  // buttonName
                );
            } else {
                jQuery.each( data, function ( key, val )
                {

                    sugList.append( '<li ' +
                                    'onClick="app.addPartToTicket({Part_Code:\'' + val.Part_Code + '\',Part_Id:\'' + val.Part_Id + '\',Description:\'' + val.Description.replace(
                            /"/g, '&quot;' ) + '\',Detail:\'' + val.Detail.replace( /"/g,
                            '&quot;' ) + '\'})" >' + val.Part_Code + '-' + val.Description + '</li>' );
                } );
                sugList.listview( "refresh" );
                $( '#autocomplete li' ).removeClass( 'ui-screen-hidden' );
                app.keywordAutocomplete.abort();
            }
        }.bind( this ) );
    },
    scanBarCode: function ()
    {
        var scanner = cordova.require( 'com.phonegap.plugins.barcodescanner.barcodescanner' ); // ver.0.6.0
        try {
            scanner.scan(
                function ( result )
                {
                    if (! result.cancelled) {
                        var quantity = null;
                        this.searchPart( result.text );
                    }
                }.bind( this ),
                function ( error )
                {
                    navigator.notification.alert(
                        'Scanning',  // message
                        false,         // callback
                        'Scanning failed',            // title
                        'OK'                  // buttonName
                    );
                }
            );

        } catch ( e ) {
            console.log( e );
        }
    },
    uploadPhoto: function ( imageURI, id )
    {

        var options = new FileUploadOptions();
        options.fileKey = 'path';
        options.fileName = imageURI.substr( imageURI.lastIndexOf( '/' ) + 1 );
        options.mimeType = 'image/jpeg';
        options.chunkedMode = false;

        var params = {};
        params.task_id = app.task_id;
        params.name = options.fileName;
        params['access-token'] = app.access_token;
        options.params = params;
        console.log( 'options', options, imageURI );

        this.createProgressBar( id, options.fileName );
        $( 'img[src="' + imageURI + '"]' ).attr( 'data-on-server', true );
        var ft = new FileTransfer();
        var self = this;
        ft.onprogress = function ( progressEvent )
        {
            if (progressEvent.lengthComputable) {
                var perc = Math.floor( progressEvent.loaded / progressEvent.total * 100 );
                self.setProgressBarValue( 'slider_' + id, perc );
            }
        };
        ft.upload( imageURI, encodeURI(
                app.apiUrl + 'taskattachment/upload?access-token=' + app.access_token + '&UserCode=' + app.user_code ),
            this.uploadPhotoWin.bind( this ), this.uploadPhotoFail.bind( this ), options );
    },
    createProgressBar: function ( id, text )
    {
        var cont = $( '<div>' );
        $( '<p>' ).appendTo( cont ).text( text );
        $( '<input>' ).appendTo( cont ).attr( {
            'name': 'slider_' + id,
            'id': 'slider_' + id,
            'data-highlight': 'true',
            'min': '0',
            'max': '100',
            'value': '50',
            'type': 'range'
        } ).slider( {
            create: function ( event, ui )
            {
                $( this ).parent().find( 'input' ).hide();
                $( this ).parent().find( 'input' ).css( 'margin-left', '-9999px' ); // Fix for some FF versions
                $( this ).parent().find( '.ui-slider-track' ).css( 'margin', '0 15px 0 15px' );
                $( this ).parent().find( '.ui-slider-handle' ).hide();
            }
        } ).slider( 'refresh' );
        cont.appendTo( '#progressBars' );
    },
    uploadPhotoWin: function ( r )
    {
        var data = JSON.parse( r.response );
        console.log( JSON.parse( r.response ) );
        console.log( 'Code = ' + r.responseCode );
        console.log( 'Response = ' + r.response );
        console.log( 'Sent = ' + r.bytesSent );
        //this.db.transaction(function (tx) {
        //    tx.executeSql('INSERT INTO taskAttachment (task_id, type, data, attachment_id) VALUES (?, ?, ?, ?)', [data.task_id, 'photos', data.path, data.id]);
        //});
        this.checkUploadFinish();
    },
    uploadPhotoFail: function ( error )
    {
        navigator.notification.alert(
            'Upload error',  // message
            false,         // callback
            'An error has occurred: Code = ' + error.code,            // title
            'OK'                  // buttonName
        );
        //alert('An error has occurred: Code = ' + error.code);
        console.log( error );
        console.log( 'upload error source ' + error.source );
        console.log( 'upload error target ' + error.target );
        this.checkUploadFinish();
    },
    checkUploadFinish: function ()
    {
        //if (this.uploaded == this.needToUpload) {
        //$.mobile.navigate('#tasks');
        //}
        this.uploaded ++;
        $.mobile.navigate( '#taskDetails' );
    },
    choiseFile: function ()
    {
        navigator.camera.getPicture( this.onSuccessMakePhoto, this.onFailMakePhoto,
            {
                quality: 50,
                destinationType: navigator.camera.DestinationType.FILE_URI,
                sourceType: navigator.camera.PictureSourceType.PHOTOLIBRARY
            }
        );
    },
    makePhoto: function ()
    {
        navigator.camera.getPicture( this.onSuccessMakePhoto, this.onFailMakePhoto, {
            quality: 50,
            destinationType: navigator.camera.DestinationType.FILE_URI,
            encodingType: navigator.camera.EncodingType.JPEG,
            sourceType: navigator.camera.PictureSourceType.CAMERA,
            saveToPhotoAlbum: true,
            allowEdit: true
        } );
    },
    supplierPickup: function(){
            navigator.notification.confirm(
                'Photo source',
                function ( button )
                {
                    if (1 == button) {
                        app.makePhoto();
                        app.supplierTicketNotes();
                    }
                    else if (2 == button) {
                        app.choiseFile();
                        app.supplierTicketNotes();
                    }
                }.bind( this ),
                'Select photo source',
                ['Camera', 'Gallery'] // buttonLabels
            );
    },
    supplierTicketNotes: function(){
        jQuery.ajax( {
            type: 'POST',
            url: app.apiUrl + '/ticketnotes/create?access-token=' + app.access_token,
            data: {
                Service_Ticket_Id: app.task_data[app.task_id].Service_Ticket_Id,
                UserCode: app.user_code,
                Edit_UserCode: app.user_code,
                Ticket_Number: app.task_data[app.task_id].Ticket_Number,
                Notes: "Parts Receipt Added",
                Entered_Date: moment().format( 'MMM DD YYYY HH:mm:ss A' ),
                Edit_Date: moment().format( 'MMM DD YYYY HH:mm:ss A' ),
                Is_resolution: "N",
                Access_level: 2
            }
        } );
    },
    /*onSuccessChoiseFile: function (imageURI) {
     console.info('choise', imageURI);
     $('#files').append('<div class="newImage">' +
     '<img class="photoPreview"  src="' + imageURI + '"/>' +
     '<button data-icon="delete" data-iconpos="notext" onclick="app.removeImage(this);"></button>' +
     '</div>');
     $('#files').trigger('create');
     },*/
    onSuccessMakePhoto: function ( imageURI )
    {

        //new Parse.File('myfile.txt', { base64: imageURI });
        $( '#files' ).append( '<div class="newImage"><img class="photoPreview"  src="' + imageURI + '"/>' +
                              '<button data-icon="delete" data-iconpos="notext" onclick="app.removeImage(this);"></button>' +
                              '</div>' );
        $( '#files' ).trigger( 'create' );
        app.uploadTaskData();
    },
    onFailMakePhoto: function ( message )
    {
        //alert('Failed because: ' + message);
    },
    uploadTaskData: function ()
    {
        this.db && this.db.transaction( this.saveTaskData.bind( this ), this.dbError.bind( this ) );
    },
    saveAndExit: function ()
    {
        this.saveTaskData();
        //this.checkUploadFinish();

    },
    saveTaskData: function ()
    {
        var self = this;
        var filesList = [];

        $( '#photos > div > img:not([data-on-server])' ).each( function ()
        {
            filesList.push( $( this ).attr( 'src' ) );
        } );
        $( '#files > div > img:not([data-on-server])' ).each( function ()
        {
            filesList.push( $( this ).attr( 'src' ) );
        } );

        if (this.attachmentToDelete) {
            this.showLoader( 'Saving...' );

            for (var i in this.attachmentToDelete) {
                jQuery.ajax( {
                    type: 'DELETE',
                    url: app.apiUrl + 'taskattachment/' + app.attachmentToDelete[i] + '?access-token=' + app.access_token,
                    UserCode: app.user_code

                } ).always( function ( data )
                {

                    delete app.attachmentToDelete[i];
                    $.mobile.loading( 'hide' );
                } )


            }
        }

        this.setProgressBarValue( 0 );
        $( '#progressBars' ).empty();

        this.needToUpload = filesList.length;

        if (this.needToUpload) {

            $.mobile.navigate( "#progress" );
            $.each( filesList, function ( key, val )
            {
                self.uploadPhoto( val, key );
            } );
            this.uploaded = 0;

        }

        $.mobile.loading( 'hide' );


    },
    showTaskDetail: function ( task_id, dispatch_id )
    {
        this.showLoader( 'Loading task data' );
        this.clearTask();
        var task = app.task_data[task_id];
        app.usedParts = [];
        app.attachmentToDelete = [];
        app.task_id = task_id;
        app.dispatch_id = dispatch_id;
        this.db && this.db.transaction( this.getTaskData, this.dbError );

        $.when( jQuery.getJSON( app.apiUrl + '/ticket/find', {
            'id': dispatch_id,
            'Ticket_Number': app.task_data[app.task_id].Ticket_Number,
            'access-token': app.access_token,
            'UserCode': app.user_code
        }, this.drawTaskDetails.bind( this ) ) ).done( function ( res )
        {

            $.mobile.loading( 'hide' );
            if (res.length) {
                $.mobile.navigate( '#taskDetails' );
            }
//             app.showReceiptPage();
//             app.showSignPopup();


        } );

    },
    dbError: function ( err )
    {
        alert( err.code + '\n' + err.message );
    },
    getTaskData: function ( tx )
    {

        jQuery.getJSON( app.apiUrl + 'ticket/getdispatch', {
            'dispatch_id': app.dispatch_id,
//            'task_id': app.task_id,
            'access-token': app.access_token
        }, function ( data )
        {
            console.info( 'dispatch data', data );
            data = data[0]
            if (data.LockedByUser) {
                if (data.form.toLowerCase() == 'mobile' && data.LockedByUser == app.user_code) {
                    app.taskLocked[app.task_id] = false;
                } else {
                    app.taskLocked[app.task_id] = data.LockedByUser;
                }
            } else {
                app.taskLocked[app.task_id] = false;
            }
            app.task_data[data.Service_Ticket_Id]['Dispatch_Details'] = data;
            app.task_data[data.Service_Ticket_Id]['Dispatch_Id'] = data.Dispatch_Id;
            if (data) {
                if (app.taskLocked[app.task_id]) {
                    var locked_time_message = ''
                    if (data.locked_length <= 1) {
                        locked_time_message = ' one minute ago';
                    } else if (data.locked_length > 1 && data.locked_length <= 60) {
                        locked_time_message = data.locked_length + ' minutes ago';
                    } else {
                        locked_time_message = ' about ' + Math.round( data.locked_length / 60 ) + ' hour(s) ago';
                    }
                    navigator.notification.alert(
                        'Task Locked by user: "' + app.taskLocked[app.task_id] + '"' + locked_time_message,  // message
                        function ( res )
                        {
                        },         // callback
                        'Task Locked',            // title
                        'OK'                  // buttonName
                    );

                    $( '#status_dispatch,#status_arrived,#status_depart,button[id^="task_btn_"]' ).addClass(
                        'ui-disabled' );

                } else if (moment( data.Dispatch_Time, 'MMM DD YYYY HH:mm:ss0A' ).unix() > 0) {

                    $( '#status_dispatch' ).addClass( 'ui-disabled' );

                    if (moment( data.Arrival_Time, 'MMM DD YYYY HH:mm:ss0A' ).unix() > 0) {
                        $( '#status_arrived' ).addClass( 'ui-disabled' );
                        if (moment( data.Departure_Time, 'MMM DD YYYY HH:mm:ss0A' ).unix() > 0) {
                            $( '#status_depart' ).addClass( 'ui-disabled' );

                                console.log(app.task_data[data.Service_Ticket_Id]);
                                if("SC" == app.task_data[data.Service_Ticket_Id].ticket_status){
                                    app.departDetails();
                                }

                        } else {
                            $( '#status_depart,button[id^="task_btn_"]' ).removeClass( 'ui-disabled' );
                        }
                    } else {
                        $( '#status_arrived' ).removeClass( 'ui-disabled' );
                    }
                } else {
                    $( '#status_dispatch' ).removeClass( 'ui-disabled' );
                }
            }

        }.bind( this ) );

        if (app.taskLocked[app.task_id] == false) {
            jQuery.getJSON( app.apiUrl + '/taskattachment/search', {
                task_id: app.task_id,
                'access-token': app.access_token
            }, function ( data )
            {
                if (data) {
                    for (var i in data) {
                        $( '#photos' ).append(
                            '<div class="newImage" data-attachment-id="' + data[i].id + '" >' +
                            '<img class="photoPreview" ' +
                            'data-on-server="true" ' +
                            'src="' + app.apiUrl + '/uploads/' + data[i].task_id + '/' + data[i].path + '"/>' +
                            '<button data-icon="delete" data-iconpos="notext" onclick="app.removeImage(this);"></button>' +
                            '</div>' );
                        $( '#photos' ).trigger( 'create' );
                    }
                }

            } );

            jQuery.getJSON( app.apiUrl + '/taskpart/search', {
                'Service_Ticket_Id': app.task_id,
                'expand': 'part',
                'access-token': app.access_token
            }, function ( data )
            {
                if (data) {
                    for (var i in data) {
                        app.usedParts[data[i].part.Part_Id] = data[i].Quantity;
                        $( '#parts' ).append( '<li id="part' + data[i].part.Part_Id + '">' +
                                              '<a data-inline="true" onclick="app.changePartQuantity('+ data[i].Service_Ticket_Part_Id + ',' + data[i].part.Part_Id + ',' + data[i].Quantity+ ',\'' + data[i].part.Part_Code+ '\',\'' + htmlEncode(data[i].part.Description) + '\'); return false;">'
                                              + data[i].part.Part_Code + ' ' + data[i].part.Description +
                                              '<span class="ui-li-count" >' + data[i].Quantity + '</span>' +
                                              '</a>'+
                                              '<a onclick="app.removePart(' + data[i].part.Part_Id + ', '+data[i].Quantity+','+ data[i].Service_Ticket_Part_Id + ')" class="delete">Delete</a>' +
                                              '</li>' );
                    }
                    $( '#parts:visible' ).listview( 'refresh' );
                }
            }.bind( this ) );
        }


    },
    changePartQuantity: function(Service_Ticket_Part_Id, part_id, currentQuantity, partCode, partDescription){
        mobile_prompt(
            'Please enter total quantity for '+ partCode + ' '+ partDescription,  // message
            function ( results )
            {
                if (results.buttonIndex == 1) {

                    if("0" == results.input1 ){
                        navigator.notification.alert(
                            'Please enter only numbers that more than 0',  // message
                            false,         // callback
                            'Incorrect value',            // title
                            'OK'                  // buttonName
                        );
                        return false;
                    }

                    if (parseInt( results.input1 ) != NaN) {
                        quantity = parseInt( results.input1 );
                        if(quantity <1){
                            navigator.notification.alert(
                                'Please enter only numbers that more than 0',  // message
                                false,         // callback
                                'Incorrect value',            // title
                                'OK'                  // buttonName
                            );
                            return false;
                        }
                    } else {
                        navigator.notification.alert(
                            'Please enter only numbers',  // message
                            false,         // callback
                            'Is not  number',            // title
                            'OK'                  // buttonName
                        );
                    }

                    app.showLoader("Saving part...");

//                     $.ajax({
//                         type: 'POST',
//                         url: app.apiUrl + 'taskpart/delete?access-token=' + app.access_token,
//                         data: {
//                             service_ticket_part_id: Service_Ticket_Part_Id,
//                             part_id: part_id,
//                             Service_Tech_ID: app.user_id,
//                             Service_Ticket_Id: app.task_id,
//                             Ticket_Number: app.task_data[app.task_id].Ticket_Number,
//                             Quantity: currentQuantity,
//                             UserCode: app.user_code,
//                             ServiceTechCode: app.service_tech_code,
//                             Warehouse_Id: app.user_warehouse_id,
//                             Warehouse_Code: app.user_warehouse_code
//                         }
//                     } ).done(function(){


                        jQuery.ajax( {
                            type: 'POST',
                            url: app.apiUrl + 'taskpart/update?access-token=' + app.access_token,
                            data: {
                                'service_ticket_part_id': Service_Ticket_Part_Id,
                                'Service_Tech_ID': app.user_id,
                                'Service_Ticket_Id': app.task_id,
                                'Ticket_Number': app.task_data[app.task_id].Ticket_Number,
                                'Part_Id': part_id,
                                'Quantity': quantity,
                                'UserCode': app.user_code,
                                'ServiceTechCode': app.service_tech_code,
                                'Warehouse_Id': app.user_warehouse_id,
                                'Warehouse_Code': app.user_warehouse_code

                            }
                        } ).always(function(){

                            if (app.usedParts[part_id]) {
                                if (quantity) {
                                    app.usedParts[part_id] = quantity;
                                } else {
                                    app.usedParts[part_id] ++;
                                }
                                $( '#part' + part_id + ' .ui-li-count' ).text( app.usedParts[part_id] );
                            } else {
                                $("#part"+part_id+" .ui-li-count").text(quantity);

                                app.usedParts[part_id] = quantity ? quantity : 1;
                            }
                            $( '#parts' ).listview( 'refresh' );
                            jQuery( "#autocomplete" ).html( "" );
                            $( 'input[data-type="search"]' ).val( "" );
                            $.mobile.loading( 'hide' );
//                             $.mobile.navigate( '#taskDetails' );
//                             $.mobile.silentScroll( $( '#parts' ).offset().top );
    //                        app.uploadTaskData();
                            $.mobile.loading( 'hide' );
                        });
//                     });
                }
            }.bind( this ),                  // callback to invoke
            'Quantity',            // title
            ['Ok', 'Exit'],             // buttonLabels
            currentQuantity.toString()                 // defaultText
        );
    },
    drawTaskDetails: function ( data )
    {
        data = data[0];

        if (undefined != data) {
            //this.task_data[this.task_id] = data; // here was error with rewriting task custom params
            $.extend( this.task_data[this.task_id], data );


            var task = data;

            $( '#taskName' ).text( task.ProblemDescription + ' - ' + task.Customer_Name );

            $( '<h4>Customer</h4>' ).appendTo( '#taskDescription' );
            $( '<p><pre>' + task.customer_number + '</pre></p>' ).appendTo( '#taskDescription' );
            $( '<p><pre>' + task.Customer_Name + '</pre></p>' ).appendTo( '#taskDescription' );
            $( '<p><pre>' + task.address_1 + '</pre></p>' ).appendTo( '#taskDescription' );
            $( '<p><pre>' + task.ge1_description + '</pre></p>' ).appendTo( '#taskDescription' );
            $( '<p><pre>' + task.ge2_short + '</pre></p>' ).appendTo( '#taskDescription' );
            $( '<p><pre>' + task.ge3_description + '</pre></p>' ).appendTo( '#taskDescription' );

            $( '<h4>Site</h4>' ).appendTo( '#taskDescription' );
            $( '<p><pre>' + task.business_name + '</pre></p>' ).appendTo( '#taskDescription' );
            $( '<p><pre>' + task.Customer_Site_Address + '</pre></p>' ).appendTo( '#taskDescription' );
            $( '<p><pre>' + task.Customer_Site_Ge1_Description + '</pre></p>' ).appendTo( '#taskDescription' );
            $( '<p><pre>' + task.Customer_Site_Ge2_Short + '</pre></p>' ).appendTo( '#taskDescription' );
            $( '<p><pre>' + task.Customer_Site_Ge3_Description + '</pre></p>' ).appendTo( '#taskDescription' );

            $( '<h4>System Information</h4>' ).appendTo( '#taskDescription' );
            $( '<p><pre>System Account: ' + task.alarm_account + '</pre></p>' ).appendTo( '#taskDescription' );
            $( '<p><pre>System Type: ' + task.System_Description + '</pre></p>' ).appendTo( '#taskDescription' );
            $( '<p><pre>Panel Type: ' + task.System_Panel_Description + '</pre></p>' ).appendTo( '#taskDescription' );
            $( '<p><pre>Site Phone: ' + task.phone_1 + '</pre></p>' ).appendTo( '#taskDescription' );
            $( '<p><pre>Cross Street: ' + task.cross_street + '</pre></p>' ).appendTo( '#taskDescription' );
            $( '<p><pre>System Comments: ' + task.system_comments + '</pre></p>' ).appendTo( '#taskDescription' );

            $( '<h4>Ticket Information</h4>' ).appendTo( '#taskDescription' );
            $( '<p><pre>Ticket number: ' + task.Ticket_Number + '</pre></p>' ).appendTo( '#taskDescription' );
            $( '<p><pre>Status: ' + task.ticket_status + '</pre></p>' ).appendTo( '#taskDescription' );
            $( '<p><pre>Created on: ' + task.Creation_Date + '</pre></p>' ).appendTo( '#taskDescription' );
            $( '<p><pre>Created by: ' + task.entered_by + '</pre></p>' ).appendTo( '#taskDescription' );
            $( '<p><pre>Contact: ' + task.Requested_By + '</pre></p>' ).appendTo( '#taskDescription' );
            $( '<p><pre>Phone: ' + task.requested_by_phone + '</pre></p>' ).appendTo( '#taskDescription' );
            $( '<p><pre>Problem: ' + task.ProblemDescription + '</pre></p>' ).appendTo( '#taskDescription' );
            $( '<p><pre>Customer Comment : </pre>' + task.CustomerComments + '</p>' ).appendTo( '#taskDescription' );


        } else {

            navigator.notification.alert(
                'There is no data for this task',  // message
                function ( res )
                {
                    app.showTasksList();
                },         // callback
                'Task loading error',            // title
                'OK'                  // buttonName
            );
        }
    },
    clearTask: function ()
    {
        $( '#taskName, #taskDescription, #photos, #files, #parts' ).empty();

        $( '#status_dispatch,#status_arrived,#status_depart,button[id^="task_btn_"]' ).addClass( 'ui-disabled' );
    },
    setProgressBarValue: function ( id, value )
    {
        $( '#' + id ).val( value );
        $( '#' + id ).slider( 'refresh' );
    },
    saveTaskStatus: function ( taskStatusData )
    {

        taskStatusData.data.UserCode = app.user_code;
        taskStatusData.data.Ticket_Number = app.task_data[app.task_id].Ticket_Number;

        app.taskStatusData = taskStatusData;
        jQuery.ajax( {
            type: 'POST',
            url: app.apiUrl + 'taskhistory/create?access-token=' + app.access_token,
            data: {
                'task_id': app.task_id,
                'tech_id': app.user_id,
                'Ticket_Number': app.task_data[app.task_id].Ticket_Number,
                'status': taskStatusData.status
            }
        } ).always( function ( dataResponse )
        {
            $.mobile.loading( 'hide' );
            if (typeof dataResponse.id != 'undefined') {
                if ('dispatch' == dataResponse.status) {
                    this.showLoader( 'Saving task status' );
                    jQuery.ajax( {
                        type: 'PUT',
                        url: app.apiUrl + 'dispatch/' + app.task_data[app.task_id].Dispatch_Id + ',' + app.task_id + '?access-token=' + app.access_token,
                        data: taskStatusData.data
                    } ).always( function ( dataResponse )
                    {
                        console.log( dataResponse );
                    } );
                    this.showLoader( 'Saving task status' );
                    $( '#status_dispatch,#status_depart,button[id^="task_btn_"]' ).addClass( 'ui-disabled' );
                    $( '#status_arrived' ).removeClass( 'ui-disabled' );
                    jQuery.ajax( {
                        type: 'PUT',
                        url: app.apiUrl + 'ticket/' + app.task_id + '?access-token=' + app.access_token,
                        data: {
                            'Ticket_Status': 'IP',
                            'UserCode': app.user_code,
                            'Ticket_Number': app.task_data[app.task_id].Ticket_Number
                        }
                    } ).always( function ( data )
                    {
                        //$('#task' + data.Service_Ticket_Id).remove();
                        $.mobile.loading( 'hide' );
                    } );
                } else if ('arrived' == dataResponse.status) {

                    this.showLoader( 'Saving task status' );
                    jQuery.ajax( {
                        type: 'PUT',
                        url: app.apiUrl + 'dispatch/' + app.task_data[app.task_id].Dispatch_Id + ',' + app.task_id + '?access-token=' + app.access_token,
                        data: taskStatusData.data
                    } ).always( function ( dataResponse )
                    {
                        console.log( dataResponse );
                    } );
                    $( '#status_dispatch, #status_arrived' ).addClass( 'ui-disabled' );
                    $( '#status_depart,button[id^="task_btn_"]' ).removeClass( 'ui-disabled' );

                    jQuery.ajax( {
                        type: 'PUT',
                        url: app.apiUrl + 'ticket/' + app.task_id + '?access-token=' + app.access_token,
                        data: {
                            'Ticket_Status': 'IP',
                            'UserCode': app.user_code,
                            'Ticket_Number': app.task_data[app.task_id].Ticket_Number


                        }
                    } ).always( function ( data )
                    {
                        $.mobile.loading( 'hide' );
                    } );
                } else if ('depart' == dataResponse.status) {
                    //$('#status_dispatch,#status_arrived,#status_depart,button[id^="task_btn_"]').addClass('ui-disabled');
                    this.showLoader( 'Saving task status' );
                    app.departDetails();
                }
            } else {
                navigator.notification.alert(
                    'Time was saved',  // message
                    false,         // callback
                    'Time',            // title
                    'OK'                  // buttonName
                );
            }

        }.bind( this ) );
    },

    departDetails: function(){
        if(!app.taskStatusData){
            app.taskStatusData =  {status: 'depart', data: {}, taskId: app.task_id}
            app.taskStatusData.data.UserCode = app.user_code;
            app.taskStatusData.data.Ticket_Number = app.task_data[app.task_id].Ticket_Number;
        }
        navigator.notification.confirm( '',
            function ( button )
            {

                if (1 == button) {
                    $( '#status_depart,button[id^="task_btn_"]' ).removeClass( 'ui-disabled' );
                    $.mobile.loading( 'hide' );
                } else if (2 == button) {

                    navigator.notification.confirm( 'Select depart type', function ( button )
                    {

                        if (1 == button) {
                            app.departType = 'GB';
                        } else if (2 == button) {
                            app.departType = 'RS';
                            //app.depart(taskStatusData);
                        } else if (3 == button) {
                            departType = false;
                            if (!moment( app.task_data[app.task_id].Dispatch_Details.Departure_Time, 'MMM DD YYYY HH:mm:ss0A' ).unix() > 0) {
                                $( '#status_depart,button[id^="task_btn_"]' ).removeClass( 'ui-disabled' );
                            }
                            $.mobile.loading( 'hide' );
                        }

                        if ((app.departType == 'RS') || (app.departType == 'GB')) {
                            navigator.notification.confirm(
                                'Reminder: Place system back on line via MASMobile.', // message
                                function ( button )
                                {
                                    $.mobile.navigate( '#gobacknoteswithcode' );
                                },            // callback to invoke with index of button pressed
                                'MASMobile',           // title
                                ['Ok'] // buttonLabels
                            );


                        }
//                                     else if (app.departType == 'GB') {
//                                         $.mobile.navigate( '#gobacknotes' );
//
//                                     }

                    }, 'Depart type', ['Go back', 'Resolved', 'Cancel'] )


                } else {
                    $( '#status_depart,button[id^="task_btn_"]' ).removeClass( 'ui-disabled' );
                    $.mobile.loading( 'hide' );
                }
            },
            'Do you need to add materials?',
            ['Yes', 'No']
        );
    },

    depart: function ( taskStatusData )
    {
        if (app.departType) {
            var data = taskStatusData.data;
            data.Ticket_Status = app.departType;
            data.Ticket_Number = app.task_data[app.task_id].Ticket_Number


            jQuery.ajax( {
                type: 'PUT',
                url: app.apiUrl + 'dispatch/' + app.task_data[app.task_id].Dispatch_Id + ',' + app.task_id + '?access-token=' + app.access_token,
                data: data
            } ).always( function ( dataResponse )
            {
                console.log( dataResponse );
            } );

            jQuery.ajax( {
                type: 'PUT',
                UserCode: app.user_code,
                url: app.apiUrl + 'ticket/' + app.task_id + '?access-token=' + app.access_token,
                data: data
            } ).always( function ( data )
            {
                $( '#task' + data.Service_Ticket_Id ).remove();
            } );
        }
    },
    launchMASMobile: function ()
    {
        if ('android' == cordova.platformId) {
            window.plugins.launcher.launch( {packageName: 'com.mas.masmobile'}, function ( data )
            {
                console.log( data )
            }, function ( data )
            {
                console.log( data )
            } );
        } else {
            window.plugins.launcher.launch( {packageName: 'com.mas.masmobile'}, function ( data )
            {
                console.log( data )
            }, function ( data )
            {
                console.log( data )
            } );
        }
    },
    setTaskStatus: function ( status )
    {
        var canSetStatus = false;
        var data = {};
        switch (status) {
            case 'dispatch':
                navigator.notification.confirm(
                    '', // message
                    function ( button )
                    {
                        if (1 == button) {
                            canSetStatus = true;
                            //data.Dispatch_Time = moment().format('MMM DD YYYY HH:mm:ss A');
                            data.Dispatch_Time = moment().format( 'YYYY-MM-DD HH:mm:ss.000' );
                            data.Arrival_Time = 0;
                            data.Departure_Time = 0;
                            data.Ticket_Status = 'IP';
                            this.saveTaskStatus( {status: status, data: data, taskId: app.task_id} );
                        } else {
                            app.showTasksList();
                        }
                    }.bind( this ),            // callback to invoke with index of button pressed
                    'On Your Way?',           // title
                    ['Yes', 'No'] // buttonLabels
                );
                break;
            case 'arrived':
                navigator.notification.confirm(
                    '', // message
                    function ( button )
                    {
                        if (button == 1) {
                            canSetStatus = true;
                            //data.Arrival_Time = moment().format('MMM DD YYYY HH:mm:ss A');
                            data.Arrival_Time = moment().format( 'YYYY-MM-DD HH:mm:ss.000' );
                            data.Departure_Time = 0;
                            this.saveTaskStatus( {status: status, data: data, taskId: app.task_id} );
                            navigator.notification.confirm(
                                'Remember to place system on test using MAS Mobile app.', // message
                                function ( button )
                                {
                                    if (1 == button) {
//                                        this.launchMASMobile();
                                    }
                                },            // callback to invoke with index of button pressed
                                'MASMobile',           // title
                                ['Ok',] // buttonLabels
                            );
                        }
                    }.bind( this ),
                    'Arrived?',
                    ['Yes', 'No']
                );
                break;
            case 'depart':
                navigator.notification.confirm(
                    '', // message
                    function ( button )
                    {
                        if (1 == button) {
                            data.Departure_Time = moment().format( 'MMM DD YYYY HH:mm:ss A' );
                            data.Departure_Time = moment().format( 'YYYY-MM-DD HH:mm:ss.000' );
                            this.saveTaskStatus( {status: status, data: data, taskId: app.task_id} );
                        }
                    }.bind( this ),
                    'Ready to Depart?',
                    ['Yes', 'No']
                );
                break;
        }
    },
    goBack: function ()
    {
        if ($.mobile.activePage.is( '#tasks' ) || $.mobile.activePage.is( '#signin' )) {
            if (navigator.app) {
                navigator.app.exitApp();
            }
            else if (navigator.device) {
                navigator.device.exitApp();
            } else {
                window.localStorage.clear();
                $.mobile.navigate( '#signin' );
            }
        }
        else {
            $.mobile.back();
            return false;
        }
    },
    removePart: function ( part_id, quantity, service_ticket_part_id )
    {
        app.part_to_delete = part_id;
        navigator.notification.confirm(
            'Remove part from list', // message
            function ( index )
            {
                if (1 == index) {
                    app.showLoader("Removing part...");
                    $.ajax({
                        type: 'POST',
                        url: app.apiUrl + 'taskpart/delete?access-token=' + app.access_token,
                        data: {
                            service_ticket_part_id: service_ticket_part_id,
                            part_id: app.part_to_delete,
                            Service_Tech_ID: app.user_id,
                            Service_Ticket_Id: app.task_id,
                            Ticket_Number: app.task_data[app.task_id].Ticket_Number,
                            Quantity: quantity,
                            UserCode: app.user_code,
                            ServiceTechCode: app.service_tech_code,
                            Warehouse_Id: app.user_warehouse_id,
                            Warehouse_Code: app.user_warehouse_code
                        }
                    } ).always(function(){
                        delete app.usedParts[app.part_to_delete];
                        $( '#part' + app.part_to_delete ).remove();
                        $.mobile.loading( 'hide' );
                    })

//                    app.saveTaskData();
                }
            },            // callback to invoke with index of button pressed
            'Part removing',           // title
            ['Yes', 'No']         // buttonLabels
        );

    },
    removeImage: function ( obj )
    {
        app.image_to_remove = obj;
        navigator.notification.confirm(
            'Remove photo from task', // message
            function ( index )
            {
                if (1 == index) {
                    var obj = app.image_to_remove;
                    var cont = $( obj ).closest( 'div' );
                    if (cont.data( 'attachment-id' )) {
                        app.attachmentToDelete.push( cont.data( 'attachment-id' ) );
                    }
                    cont.remove();
                    app.uploadTaskData();

                }
            },            // callback to invoke with index of button pressed
            'Photo removing',           // title
            ['Yes', 'No']         // buttonLabels
        );


    },
    settings: function ()
    {
        $( '#username' ).val( app.user_data.username );
        $( '#email' ).val( app.user_data.email );
        $( '#appversion' ).html( 'version: ' + app.version );


        //$('#newpassword').val('');
        $.mobile.navigate( '#profile' );
    },
    saveProfile: function ()
    {
        var data = {};
        if ($( '#username' ).val()) {
            data.username = $( '#username' ).val();
        }
        if ($( '#email' ).val()) {
            data.email = $( '#email' ).val();
        }
        if ($( '#newpassword' ).val()) {
            data.password_hash = $( '#newpassword' ).val();
        }
        jQuery.ajax( {
            type: 'PUT',
            url: app.apiUrl + 'user/' + app.user_data.id + '?access-token=' + app.access_token,
            data: data
        } ).always( function ( data )
        {
            app.user_data = data;
            app.showTasksList();
            navigator.notification.alert(
                'Profile was saved',  // message
                false,         // callback
                'Profile',            // title
                'OK'                  // buttonName
            );
        } );
    },
    logout: function ()
    {
        window.localStorage.clear();
        $( '#login' ).val( '' );
        $( '#password' ).val( '' );
        $( '#tasks #tasks_content table tbody' ).empty();
        $( '#table-custom-2' ).table( 'refresh' );
        $.mobile.navigate( '#signin' );
    },
    showLoader: function ( message )
    {
        $.mobile.loading( 'show', {
            text: message,
            textVisible: true,
            textOnly: false,
            inline: true,
            theme: 'b',
            html: ''
        } );
    },
    showReceiptPage: function ()
    {
        jQuery("#receiptData .timing" ).empty();
        jQuery( '#receiptData .parts' ).empty();
        jQuery("#userEmail" ).val("");
        jQuery("#signName" ).val("");
        jQuery("#sendReceiptBtn").attr("disabled","disabled");
        jQuery("#terms").checkboxradio();
        jQuery("#terms").prop('checked', false);
        jQuery("#terms").removeAttr("checked");
        jQuery("#terms").attr("checked",false).checkboxradio("refresh");
        jQuery("#emailHolder").hide();
        jQuery("#termsBlock").hide();
        jQuery("#noSigner").show();
        jQuery("#addSignBtn").show();
        jQuery( "#contentCanvas" ).empty();
        


        jQuery.getJSON( app.apiUrl + '/taskpart/search', {
            'Service_Ticket_Id': app.task_id,
            'expand': 'part',
            'access-token': app.access_token
        }, function ( data )
        {
            $( '#receiptData .parts' ).empty();
            if (data.length) {
                $('#usedPartsLabel' ).show();
                for (var i in data) {

                    $( '#receiptData .parts' ).append(
                        '<p>' + data[i].part.Part_Code + ' ' + data[i].part.Detail + ' ' +
                        '(' + data[i].Quantity + ')' +
                        '</p>' );
                }
            }
        }.bind( this ) );

        jQuery.getJSON( app.apiUrl + 'ticket/getdispatch', {
            'dispatch_id': app.dispatch_id,
//             'task_id': app.task_id,
            'access-token': app.access_token
        }, function ( data )
        {
            data = data[0]

            if (data) {
                if (moment( data.Dispatch_Time, 'MMM DD YYYY HH:mm:ss0A' ).unix() > 0) {
                    jQuery("#receiptData .timing" ).append('<p><b>Dispatch time: </b>'+moment( data.Dispatch_Time, 'MMM DD YYYY HH:mm:ss0A' ).format("YYYY-MM-DD HH:mm:ss")+'</p>')
                }
                if (moment( data.Arrival_Time, 'MMM DD YYYY HH:mm:ss0A' ).unix() > 0) {
                    jQuery("#receiptData .timing" ).append('<p><b>Arrival time: </b>'+moment(data.Arrival_Time, 'MMM DD YYYY HH:mm:ss0A' ).format("YYYY-MM-DD HH:mm:ss")+'</p>')
                }
                if (moment( data.Departure_Time, 'MMM DD YYYY HH:mm:ss0A' ).unix() > 0) {
                    jQuery("#receiptData .timing" ).append('<p><b>Departure time: </b>'+moment(data.Departure_Time, 'MMM DD YYYY HH:mm:ss0A' ).format("YYYY-MM-DD HH:mm:ss")+'</p>')
                }

            }

        }.bind( this ) );

        $.mobile.navigate( '#receipt' );
    },
    initCanvas:
    {
//        var margin = $("#signature div[data-role='header']" ).height()+$("#signature #emailHolder" ).height()+$("#signature #canvasControl" ).height()+$("#signature div[data-role='footer']" ).height();

        context: null,
        canvasObj: null,

        clickX: new Array(),
        clickY: new Array(),
        clickDrag: new Array(),
        paint: null,

        init: function()
        {
            var margin = 170;


            $( "#contentCanvas" ).height( $( window ).height() - margin );
            var canvas = '<canvas id="canvas" width="' + (
                    $( window ).width() - 8
                ) + '" height="' + (
                             $( window ).height() - margin
                         ) + '"></canvas>';
            $( "#contentCanvas" ).html( canvas );
            app.initCanvas.context = document.getElementById( "canvas" ).getContext( "2d" );
            app.initCanvas.canvasObj = document.getElementById( "canvas" );
            app.initCanvas.clickX = new Array();
            app.initCanvas.clickY = new Array();
            app.initCanvas.clickDrag = new Array();
            app.initCanvas.drawGrid();

            app.initCanvas.canvasObj.addEventListener( 'touchstart', function ( evt )
            {
                app.initCanvas.paint = true;
                app.initCanvas.addClick( evt.touches[0].pageX - app.initCanvas.canvasObj.offsetLeft, evt.touches[0].pageY - app.initCanvas.canvasObj.offsetTop );
                app.initCanvas.redraw(true);
                evt.preventDefault();
            }, false );

            app.initCanvas.canvasObj.addEventListener( 'touchmove', function ( evt )
            {

                if (app.initCanvas.paint) {
                    app.initCanvas.addClick( evt.touches[0].pageX - app.initCanvas.canvasObj.offsetLeft, evt.touches[0].pageY - app.initCanvas.canvasObj.offsetTop,
                        true );
                    app.initCanvas.redraw(true);
                }
            }, false );

            app.initCanvas.canvasObj.addEventListener( 'touchend', function ()
            {
                app.initCanvas.paint = false;
            }, false );

        },

        addClick: function( x, y, dragging )
        {
            app.initCanvas.clickX.push( x );
            app.initCanvas.clickY.push( y );
            app.initCanvas.clickDrag.push( dragging );
        },

         drawGrid: function(){

            // https://developer.mozilla.org/en-US/docs/Web/API/Canvas_API/Tutorial/Pixel_manipulation_with_canvas
             app.initCanvas.context.strokeStyle = "#000000";
             app.initCanvas.context.lineJoin = "round";
             app.initCanvas.context.lineWidth = 2;

            var lineY = app.initCanvas.context.canvas.height - (app.initCanvas.context.canvas.height * 0.2);
//              app.initCanvas.context.setLineDash([15, 15]);
            app.initCanvas.context.moveTo(0,  lineY);
            app.initCanvas.context.lineTo(app.initCanvas.context.canvas.width,  lineY);
            app.initCanvas.context.closePath();

             app.initCanvas.context.moveTo(5,  lineY - 20);
             app.initCanvas.context.lineTo(15,  lineY - 5);
             app.initCanvas.context.closePath();

             app.initCanvas.context.moveTo(15,  lineY - 20);
             app.initCanvas.context.lineTo(5,  lineY - 5);
             app.initCanvas.context.closePath();

             app.initCanvas.context.stroke();
//              app.initCanvas.context.setLineDash([]);
        },

        redraw: function(visGrid)
        {
            app.initCanvas.context.clearRect( 0, 0, app.initCanvas.context.canvas.width, app.initCanvas.context.canvas.height ); // Clears the canvas
            if(visGrid) {
                app.initCanvas.drawGrid();
            }
            app.initCanvas.context.strokeStyle = "#df4b26";
            app.initCanvas.context.lineJoin = "round";
            app.initCanvas.context.lineWidth = 5;

            for (var i = 0; i < app.initCanvas.clickX.length; i ++) {
                app.initCanvas.context.beginPath();
                if (app.initCanvas.clickDrag[i] && i) {
                    app.initCanvas.context.moveTo( app.initCanvas.clickX[i - 1], app.initCanvas.clickY[i - 1] );
                } else {
                    app.initCanvas.context.moveTo( app.initCanvas.clickX[i] - 1, app.initCanvas.clickY[i] );
                }
                app.initCanvas.context.lineTo( app.initCanvas.clickX[i], app.initCanvas.clickY[i] );
                app.initCanvas.context.closePath();
                app.initCanvas.context.stroke();
            }
        }

    },
    clearCanvas: function ()
    {
        var canvas = document.getElementById( "canvas" );
        var context = canvas.getContext( "2d" );
        context.clearRect( 0, 0, canvas.width, canvas.height );
        app.initCanvas.init();
    },
    sendReceipt: function ()
    {

        if(jQuery("#userEmail:visible" ).length > 0) {
            if (! jQuery( "#userEmail" ).val()) {
                return false;
            }
        }

        this.showLoader( 'Sending receipt' );
        var canvas = document.getElementById( "canvas" );

        var data = {};
        if(canvas) {
            app.initCanvas.redraw();
            data.sign = canvas.toDataURL();
            data.sign_name = jQuery("#signName" ).val();
            data.email = jQuery("#userEmail" ).val();
        }
        data.parts = jQuery("#receiptData .parts" ).html();
        data.time = jQuery("#receiptData .timing" ).html();
        data.task_id = app.task_id;
        data.ticket_number = app.task_data[app.task_id].Ticket_Number;
        data.comment = app.task_data[app.task_id].Resolution_Notes_Comment;

        jQuery.ajax({
            type: 'PUT',
            url: app.apiUrl + 'user/sendreceipt?access-token=' + app.access_token,
            data: data
        } ).then(function(data){
            $.mobile.loading( 'hide' );
            app.showTasksList();
        });
    },
    showTasksList: function(){
        app.loadTasks();

    },
    showSignPopup: function(){
        $.mobile.navigate( '#signature' );
        app.initCanvas.init();
    },
    saveSignature: function(){
        $("#emailHolder").show();
        $("#termsBlock").show();
        $("#noSigner").hide();
        $("#addSignBtn").hide();
        $.mobile.navigate( '#receipt' );
    },
    showTerms: function(){
        navigator.notification.alert(
            'To the extent that AFA may be held liable for any damage or loss that is caused or results from the above stated work, the undersigned agrees that said liability shall be limited to the lesser of the amount paid for said work or $250.',  // message
            false,         // callback
            'Terms',            // title
            'OK'                  // buttonName
        );
    },
    checkTerms: function(){
        if(jQuery("#terms").is(":checked")){
            jQuery("#sendReceiptBtn").removeAttr("disabled");
        }else{
            jQuery("#sendReceiptBtn").attr("disabled","disabled");
        }
        return true;
    },
    updateOrientation: function(){
        if(app.initCanvas.context){
            app.initCanvas.init();
        }
    }
};


function htmlEncode(value){
    //create a in-memory div, set it's inner text(which jQuery automatically encodes)
    //then grab the encoded contents back out.  The div never exists on the page.
    value =  value.replace(/'/g, "");
    value =  value.replace(/"/g, "");
    return value;
}

function htmlDecode(value){
    return $('<div/>').html(value).text();
}

function addslashes( str ) {
    return (str + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
}
