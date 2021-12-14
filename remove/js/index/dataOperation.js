// 查看專案裡的檔案
function viewFiles(e) {
    e.preventDefault();
    var tr = $(e.target).closest("tr");
    var data = this.dataItem(tr);
    $(location).prop("href", "view_file.php?projectId=" + data.projectId + "&projectName=" + data.projectName);
}

// 新增專案
function addProject() {
    var projectName = $("#project_name").val();
    $.ajax({
        url: "project_data.php",
        data: { projectName: projectName, operation: "add" },
        type: "POST",
        dataType: "text",
        success: function (result) {
            if (result == "add success") {
                $("#project_name").val("");
                $("#project_error").text("新增成功").prop("class", "success");
                $("#project_grid").data("kendoGrid").dataSource.read();
            } else {
                $("#project_error").text(result).prop("class", "error");
            }
        },
        error: function () {
            $("#project_error").text("伺服器發生錯誤").prop("class", "error");
        }
    });
}

// 刪除專案
function deleteProject(e) {
    e.preventDefault();
    var check = confirm("確定刪除專案?");
    if (check) {
        var tr = $(e.target).closest("tr");
        var data = this.dataItem(tr);
        $.ajax({
            url: "project_data.php",
            data: { projectId: data.projectId, operation: "delete" },
            type: "POST",
            dataType: "text",
            success: function (result) {
                if (result == "delete success") {
                    $("#project_error").text("刪除成功").prop("class", "success");
                    $("#project_grid").data("kendoGrid").dataSource.read();
                } else {
                    $("#project_error").text(result).prop("class", "error");
                }
            },
            error: function () {
                $("#project_error").text("伺服器發生錯誤").prop("class", "error");
            }
        });
        /*var projectDataSource = $("#project_grid").data("kendoGrid").dataSource;
        projectDataSource.remove(data);*/
    }

}

// 根據名稱搜尋專案
function searchProject() {
    var projectDataSource = $("#project_grid").data("kendoGrid").dataSource;
    var value = this.value;
    if (value == "") {
        projectDataSource.filter({});
    }
    projectDataSource.filter(
        { field: "projectName", operator: "contains", value: value }
    );
}