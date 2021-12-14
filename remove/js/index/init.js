$(function () {
    $("#add_project").click(addProject);

    // kendoGrid
    $("#project_grid").kendoGrid({
        dataSource: {
            transport: {
                read: {
                    url: "./project_data.php",
                    dataType: "json"
                }
            },
            schema: {
                model: {
                    fields: {
                        projectName: { type: "string" },
                        numberOfFiles: { type: "number" },
                        initiateDate: { type: "date" }
                    }
                }
            },
            pageSize: 20,
        },
        toolbar: kendo.template("<div class='grid-toolbar'><input id='project_grid-search' placeholder='搜尋專案......' type='text'></input></div>"),
        height: 550,
        sortable: true,
        pageable: {
            input: true,
            numeric: false
        },
        columns: [
            { field: "projectName", title: "專案名稱", width: "30%" },
            { field: "numberOfFiles", title: "檔案個數", width: "15%" },
            { field: "initiateDate", title: "建立時間", width: "15%", format: "{0:yyyy-MM-dd HH:mm:ss}" },
            { command: { text: "查看", click: viewFiles }, title: " ", width: "95px" },
            { command: { text: "刪除", click: deleteProject }, title: " ", width: "95px" }
        ]

    });

    // 搜尋專案
    $("#project_grid-search").on("keyup", searchProject);
})