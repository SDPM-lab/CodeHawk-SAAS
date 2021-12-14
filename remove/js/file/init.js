$(function() {
    var projectId = $("#projectId").val();

    // 檔案上傳
    $("#files").kendoUpload({
        async: {
            autoUpload: false,
            saveUrl: "./file_data.php"
        },
        localization: {
            select: "選擇檔案",
            clearSelectedFiles: "清除",
            uploadSelectedFiles: "上傳檔案",
            headerStatusUploaded: "完成",
            headerStatusUploading: "正在上傳",
            invalidFileExtension: "不允許的檔案格式"
        },
        upload: function(e) {
            e.data = {
                projectId: projectId
            };
        },
        validation: {
            allowedExtensions: [".xml", ".xmi"]
        },
        multiple: false,
        success: function(e) {
            $("#errorMsg").text("上傳成功").prop("class", "success");
            $("#file_grid").data("kendoGrid").dataSource.read();
        },
        error: function(e) {
            var request = e.XMLHttpRequest;
            $("#errorMsg").text(request.responseText).prop("class", "error");
        }
    });

    // kendoWindow
    $("#view_window").kendoWindow({
        width: "450px",
        title: "分析結果",
        visible: false,
        actions: ["Close"],
        draggable: false,
        resizable: false,
        close: function() {
            $("#analyze_result").html();
        }
    }).data("kendoWindow")

    // kendoGrid
    $("#file_grid").kendoGrid({
        dataSource: {
            transport: {
                read: {
                    url: "./file_data.php?projectId=" + projectId,
                    dataType: "json"
                }
            },
            schema: {
                model: {
                    fields: {
                        fileName: { type: "string" },
                        filePath: { type: "string" },
                        uploadDate: { type: "string" }
                    }
                }
            },
            pageSize: 20,
        },
        toolbar: kendo.template("<div class='grid-toolbar'><input id='file-grid-search' placeholder='搜尋檔名......' type='text'></input></div>"),
        height: 550,
        sortable: true,
        pageable: {
            input: true,
            numeric: false
        },
        columns: [
            { field: "fileName", title: "檔案名稱", width: "35%" },
            { field: "uploadDate", title: "上傳時間", width: "15%" },
            { command: { text: "分析", click: analyze }, title: " ", width: "95px" },
            { command: { text: "刪除", click: deleteFile }, title: " ", width: "95px" }
        ]

    });

    // 關閉視窗按鈕
    $("#confirm_btn").click(function() {
        $("#view_window").data("kendoWindow").close();
    });

    $("#back").click(function() {
        $(location).prop("href", "action_file.php");
    });


    // 搜尋檔案
    $("#file-grid-search").on("keyup", searchFile);
})