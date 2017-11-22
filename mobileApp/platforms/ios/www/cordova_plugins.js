cordova.define('cordova/plugin_list', function(require, exports, module) {
module.exports = [
    {
        "id": "com.hutchind.cordova.plugins.launcher.Launcher",
        "file": "plugins/com.hutchind.cordova.plugins.launcher/www/Launcher.js",
        "pluginId": "com.hutchind.cordova.plugins.launcher",
        "clobbers": [
            "plugins.launcher"
        ]
    },
    {
        "id": "com.phonegap.plugins.barcodescanner.BarcodeScanner",
        "file": "plugins/com.phonegap.plugins.barcodescanner/www/barcodescanner.js",
        "pluginId": "com.phonegap.plugins.barcodescanner",
        "clobbers": [
            "cordova.plugins.barcodeScanner"
        ]
    },
    {
        "id": "cordova-plugin-dialogs.notification",
        "file": "plugins/cordova-plugin-dialogs/www/notification.js",
        "pluginId": "cordova-plugin-dialogs",
        "merges": [
            "navigator.notification"
        ]
    },
    {
        "id": "cordova-plugin-screen-orientation.screenorientation",
        "file": "plugins/cordova-plugin-screen-orientation/www/screenorientation.js",
        "pluginId": "cordova-plugin-screen-orientation",
        "clobbers": [
            "cordova.plugins.screenorientation"
        ]
    },
    {
        "id": "cordova-plugin-screen-orientation.screenorientation.ios",
        "file": "plugins/cordova-plugin-screen-orientation/www/screenorientation.ios.js",
        "pluginId": "cordova-plugin-screen-orientation",
        "merges": [
            "cordova.plugins.screenorientation"
        ]
    },
    {
        "id": "cordova-plugin-touch-id.TouchID",
        "file": "plugins/cordova-plugin-touch-id/www/TouchID.js",
        "pluginId": "cordova-plugin-touch-id",
        "clobbers": [
            "window.plugins.touchid"
        ]
    },
    {
        "id": "cordova-plugin-vibration.notification",
        "file": "plugins/cordova-plugin-vibration/www/vibration.js",
        "pluginId": "cordova-plugin-vibration",
        "merges": [
            "navigator.notification",
            "navigator"
        ]
    },
    {
        "id": "org.apache.cordova.camera.Camera",
        "file": "plugins/org.apache.cordova.camera/www/CameraConstants.js",
        "pluginId": "org.apache.cordova.camera",
        "clobbers": [
            "Camera"
        ]
    },
    {
        "id": "org.apache.cordova.camera.CameraPopoverOptions",
        "file": "plugins/org.apache.cordova.camera/www/CameraPopoverOptions.js",
        "pluginId": "org.apache.cordova.camera",
        "clobbers": [
            "CameraPopoverOptions"
        ]
    },
    {
        "id": "org.apache.cordova.camera.camera",
        "file": "plugins/org.apache.cordova.camera/www/Camera.js",
        "pluginId": "org.apache.cordova.camera",
        "clobbers": [
            "navigator.camera"
        ]
    },
    {
        "id": "org.apache.cordova.camera.CameraPopoverHandle",
        "file": "plugins/org.apache.cordova.camera/www/ios/CameraPopoverHandle.js",
        "pluginId": "org.apache.cordova.camera",
        "clobbers": [
            "CameraPopoverHandle"
        ]
    },
    {
        "id": "org.apache.cordova.console.console",
        "file": "plugins/org.apache.cordova.console/www/console-via-logger.js",
        "pluginId": "org.apache.cordova.console",
        "clobbers": [
            "console"
        ]
    },
    {
        "id": "org.apache.cordova.console.logger",
        "file": "plugins/org.apache.cordova.console/www/logger.js",
        "pluginId": "org.apache.cordova.console",
        "clobbers": [
            "cordova.logger"
        ]
    },
    {
        "id": "org.apache.cordova.device.device",
        "file": "plugins/org.apache.cordova.device/www/device.js",
        "pluginId": "org.apache.cordova.device",
        "clobbers": [
            "device"
        ]
    },
    {
        "id": "org.apache.cordova.file.DirectoryEntry",
        "file": "plugins/org.apache.cordova.file/www/DirectoryEntry.js",
        "pluginId": "org.apache.cordova.file",
        "clobbers": [
            "window.DirectoryEntry"
        ]
    },
    {
        "id": "org.apache.cordova.file.DirectoryReader",
        "file": "plugins/org.apache.cordova.file/www/DirectoryReader.js",
        "pluginId": "org.apache.cordova.file",
        "clobbers": [
            "window.DirectoryReader"
        ]
    },
    {
        "id": "org.apache.cordova.file.Entry",
        "file": "plugins/org.apache.cordova.file/www/Entry.js",
        "pluginId": "org.apache.cordova.file",
        "clobbers": [
            "window.Entry"
        ]
    },
    {
        "id": "org.apache.cordova.file.File",
        "file": "plugins/org.apache.cordova.file/www/File.js",
        "pluginId": "org.apache.cordova.file",
        "clobbers": [
            "window.File"
        ]
    },
    {
        "id": "org.apache.cordova.file.FileEntry",
        "file": "plugins/org.apache.cordova.file/www/FileEntry.js",
        "pluginId": "org.apache.cordova.file",
        "clobbers": [
            "window.FileEntry"
        ]
    },
    {
        "id": "org.apache.cordova.file.FileError",
        "file": "plugins/org.apache.cordova.file/www/FileError.js",
        "pluginId": "org.apache.cordova.file",
        "clobbers": [
            "window.FileError"
        ]
    },
    {
        "id": "org.apache.cordova.file.FileReader",
        "file": "plugins/org.apache.cordova.file/www/FileReader.js",
        "pluginId": "org.apache.cordova.file",
        "clobbers": [
            "window.FileReader"
        ]
    },
    {
        "id": "org.apache.cordova.file.FileSystem",
        "file": "plugins/org.apache.cordova.file/www/FileSystem.js",
        "pluginId": "org.apache.cordova.file",
        "clobbers": [
            "window.FileSystem"
        ]
    },
    {
        "id": "org.apache.cordova.file.FileUploadOptions",
        "file": "plugins/org.apache.cordova.file/www/FileUploadOptions.js",
        "pluginId": "org.apache.cordova.file",
        "clobbers": [
            "window.FileUploadOptions"
        ]
    },
    {
        "id": "org.apache.cordova.file.FileUploadResult",
        "file": "plugins/org.apache.cordova.file/www/FileUploadResult.js",
        "pluginId": "org.apache.cordova.file",
        "clobbers": [
            "window.FileUploadResult"
        ]
    },
    {
        "id": "org.apache.cordova.file.FileWriter",
        "file": "plugins/org.apache.cordova.file/www/FileWriter.js",
        "pluginId": "org.apache.cordova.file",
        "clobbers": [
            "window.FileWriter"
        ]
    },
    {
        "id": "org.apache.cordova.file.Flags",
        "file": "plugins/org.apache.cordova.file/www/Flags.js",
        "pluginId": "org.apache.cordova.file",
        "clobbers": [
            "window.Flags"
        ]
    },
    {
        "id": "org.apache.cordova.file.LocalFileSystem",
        "file": "plugins/org.apache.cordova.file/www/LocalFileSystem.js",
        "pluginId": "org.apache.cordova.file",
        "clobbers": [
            "window.LocalFileSystem"
        ],
        "merges": [
            "window"
        ]
    },
    {
        "id": "org.apache.cordova.file.Metadata",
        "file": "plugins/org.apache.cordova.file/www/Metadata.js",
        "pluginId": "org.apache.cordova.file",
        "clobbers": [
            "window.Metadata"
        ]
    },
    {
        "id": "org.apache.cordova.file.ProgressEvent",
        "file": "plugins/org.apache.cordova.file/www/ProgressEvent.js",
        "pluginId": "org.apache.cordova.file",
        "clobbers": [
            "window.ProgressEvent"
        ]
    },
    {
        "id": "org.apache.cordova.file.fileSystems",
        "file": "plugins/org.apache.cordova.file/www/fileSystems.js",
        "pluginId": "org.apache.cordova.file"
    },
    {
        "id": "org.apache.cordova.file.requestFileSystem",
        "file": "plugins/org.apache.cordova.file/www/requestFileSystem.js",
        "pluginId": "org.apache.cordova.file",
        "clobbers": [
            "window.requestFileSystem"
        ]
    },
    {
        "id": "org.apache.cordova.file.resolveLocalFileSystemURI",
        "file": "plugins/org.apache.cordova.file/www/resolveLocalFileSystemURI.js",
        "pluginId": "org.apache.cordova.file",
        "merges": [
            "window"
        ]
    },
    {
        "id": "org.apache.cordova.file.iosFileSystem",
        "file": "plugins/org.apache.cordova.file/www/ios/FileSystem.js",
        "pluginId": "org.apache.cordova.file",
        "merges": [
            "FileSystem"
        ]
    },
    {
        "id": "org.apache.cordova.file.fileSystems-roots",
        "file": "plugins/org.apache.cordova.file/www/fileSystems-roots.js",
        "pluginId": "org.apache.cordova.file",
        "runs": true
    },
    {
        "id": "org.apache.cordova.file.fileSystemPaths",
        "file": "plugins/org.apache.cordova.file/www/fileSystemPaths.js",
        "pluginId": "org.apache.cordova.file",
        "merges": [
            "cordova"
        ],
        "runs": true
    },
    {
        "id": "org.apache.cordova.file-transfer.FileTransferError",
        "file": "plugins/org.apache.cordova.file-transfer/www/FileTransferError.js",
        "pluginId": "org.apache.cordova.file-transfer",
        "clobbers": [
            "window.FileTransferError"
        ]
    },
    {
        "id": "org.apache.cordova.file-transfer.FileTransfer",
        "file": "plugins/org.apache.cordova.file-transfer/www/FileTransfer.js",
        "pluginId": "org.apache.cordova.file-transfer",
        "clobbers": [
            "window.FileTransfer"
        ]
    },
    {
        "id": "org.apache.cordova.inappbrowser.inappbrowser",
        "file": "plugins/org.apache.cordova.inappbrowser/www/inappbrowser.js",
        "pluginId": "org.apache.cordova.inappbrowser",
        "clobbers": [
            "window.open"
        ]
    },
    {
        "id": "org.apache.cordova.statusbar.statusbar",
        "file": "plugins/org.apache.cordova.statusbar/www/statusbar.js",
        "pluginId": "org.apache.cordova.statusbar",
        "clobbers": [
            "window.StatusBar"
        ]
    },
    {
        "id": "phonegap.plugins.iosnumpad.iosNumpad",
        "file": "plugins/phonegap.plugins.iosnumpad/www/pin.js",
        "pluginId": "phonegap.plugins.iosnumpad",
        "merges": [
            "window.plugins.iosNumpad"
        ]
    },
    {
        "id": "cordova-plugin-app-launcher.Launcher",
        "file": "plugins/cordova-plugin-app-launcher/www/Launcher.js",
        "pluginId": "cordova-plugin-app-launcher",
        "clobbers": [
            "plugins.launcher"
        ]
    }
];
module.exports.metadata = 
// TOP OF METADATA
{
    "com.hutchind.cordova.plugins.launcher": "0.2.2",
    "com.phonegap.plugins.barcodescanner": "2.0.1",
    "cordova-plugin-dialogs": "1.3.3",
    "cordova-plugin-screen-orientation": "1.4.2",
    "cordova-plugin-touch-id": "3.2.0",
    "cordova-plugin-vibration": "2.1.5",
    "org.apache.cordova.camera": "0.3.3",
    "org.apache.cordova.console": "0.2.10",
    "org.apache.cordova.device": "0.2.12",
    "org.apache.cordova.file": "1.3.1",
    "org.apache.cordova.file-transfer": "0.4.6",
    "org.apache.cordova.inappbrowser": "0.5.1",
    "org.apache.cordova.statusbar": "0.1.8",
    "phonegap.plugins.iosnumpad": "0.0.1",
    "cordova-plugin-app-launcher": "0.4.0",
    "cordova-plugin-queries-schemes": "0.1.1"
};
// BOTTOM OF METADATA
});