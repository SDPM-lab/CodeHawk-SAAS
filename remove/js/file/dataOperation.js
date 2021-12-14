// 分析檔案
function analyze(e) {
    e.preventDefault();
    var tr = $(e.target).closest("tr");
    var data = this.dataItem(tr);
    $.ajax({
        url: "analyze.php",
        data: { filePath: data.filePath },
        type: "POST",
        dataType: "text",
        success: function(result) {
            $("#analyze_result").html(result);
            $("#view_window").data("kendoWindow").center().open();
        },
        error: function() {
            $("#errorMsg").text("伺服器發生錯誤").prop("class", "error");
        }
    });
}

// 刪除檔案
function deleteFile(e) {
    e.preventDefault();
    var check = confirm("確定刪除檔案?");
    if (check) {
        var tr = $(e.target).closest("tr");
        var data = this.dataItem(tr);
        $.ajax({
            url: "file_data.php",
            data: { projectId: data.projectId, filePath: data.filePath, operation: "delete" },
            type: "POST",
            dataType: "text",
            success: function(result) {
                if (result == "delete success") {
                    $("#errorMsg").text("刪除成功").prop("class", "success");
                    $("#file_grid").data("kendoGrid").dataSource.read();
                } else {
                    $("#errorMsg").text(result).prop("class", "error");
                }
            },
            error: function() {
                $("#errorMsg").text("伺服器發生錯誤").prop("class", "error");
            }
        });
        /*var projectDataSource = $("#project_grid").data("kendoGrid").dataSource;
        projectDataSource.remove(data);*/
    }
}

// 根據檔名搜尋檔案
function searchFile() {
    var fileDataSource = $("#file_grid").data("kendoGrid").dataSource;
    var value = this.value;
    if (value == "") {
        fileDataSource.filter({});
    }
    fileDataSource.filter({ field: "fileName", operator: "contains", value: value });
}