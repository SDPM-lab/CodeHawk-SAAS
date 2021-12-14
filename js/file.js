$(document).ready(function() {
    $("#fileForm").submit(function(event) {
        event.preventDefault(); // 避免提交表單刷新頁面

        file_data = $("input[name='files']").prop("files")[0]; //取得上傳檔案屬性
        if (file_data == null) {
            $('#errorText').html('請選擇檔案');
            return false;
        }
        if (file_data.name == "") {
            $('#errorText').html('專案名稱不可為空');
            return false;
        }
        var form_data = new FormData(); //建構 new FormData()
        form_data.append('file', file_data); //把 file_data 以 file 加到 form_data 裡面

        $.ajax({
                url: 'ajax/addFile.php',
                type: 'POST',
                processData: false, // 讓 jQuery 不要處理資料
                contentType: false, // 讓 jQuery 不要設置內容類型
                dataType: 'json',
                data: form_data //data 只能指定單一物件
            })
            .done(function(response) {
                // console.log(response);
                if (response.status == 1) {
                    $('#errorText').html('');
                    alert('新增檔案成功！');
                    getFile();
                } else if (response.status == 2) {
                    $('#errorText').html(response.msg);
                }
            })
            .fail(function(error) {
                console.log(error.responseText);
                $('#errorText').html('新增檔案失敗，請重新再試');
            })

    });
    window.analyzeResult = null;

    $("#saveRecord_btn").click(function() { saveRecord() });

    $("#closeModal_btn").click(function() { closeModal() });

    getFile();
})

function getFile() {
    $.ajax({
            url: 'ajax/getFile.php',
            type: 'GET',
            dataType: 'json'
        })
        .done(function(response) {
            renderTable(response);
        })
        .fail(function(error) {
            alert('取得專案資料失敗，請重新再試');
        });
}

function renderTable(data) {
    $('#fileTable').html('');
    var column = 4;
    var fileTable = document.getElementById('fileTable');
    for (var i = 0; i < data.length; i++) {
        var row = document.createElement('tr');
        var cell = new Array(column);

        for (var j = 0; j < column; j++) {
            cell[j] = document.createElement('td');
        }

        cell[0].innerHTML = data[i].fileName;
        cell[1].innerHTML = data[i].uploadDate;

        var analyzeButton = document.createElement('button');
        analyzeButton.innerHTML = '分析';
        analyzeButton.setAttribute('data-id', data[i].fileId);
        analyzeButton.setAttribute('type', 'button');
        analyzeButton.setAttribute('class', 'btn btn-analyze');
        analyzeButton.setAttribute('data-toggle', 'modal');
        analyzeButton.setAttribute('data-target', '#analyzeResultModal');
        analyzeButton.setAttribute('onClick', 'analyzeFile()');
        cell[2].appendChild(analyzeButton);

        var deleteButton = document.createElement('button');
        deleteButton.innerHTML = '刪除';
        deleteButton.setAttribute('data-id', data[i].fileId);
        deleteButton.setAttribute('type', 'button');
        deleteButton.setAttribute('class', 'btn btn-secondary');
        deleteButton.setAttribute('onClick', 'deleteFile()');
        cell[3].appendChild(deleteButton);

        for (var j = 0; j < column; j++) {
            row.appendChild(cell[j]);
        }
        fileTable.appendChild(row);
    }
}

function analyzeFile() {
    event.preventDefault();
    var fileId = $(event.target).data('id');
    $("#analyzeResultGrid").attr("data-fileId", fileId);
    $.ajax({
            url: 'ajax/analyzeFile.php',
            type: 'POST',
            dataType: 'json',
            data: { "fileId": fileId }
        })
        .done(function(response) {
            analyzeResult = response;
            console.log(analyzeResult);
            showAnalyzeResult(response);
        })
        .fail(function(error) {
            // console.log(error);
            $("#errorText").html("伺服器發生錯誤");
        })
}

function showAnalyzeResult(datas) {
    $("#analyzeResultGrid").html("");
    var analyzeResultGrid = document.getElementById("analyzeResultGrid");
    // 篩出個別的 element
    var origin = new Array();
    for (var i = 0; i < datas.length; i++) {
        var tmp = new Array();
        tmp.push(datas[i].elementType);
        tmp.push(datas[i].elementName);
        origin.push(tmp);
    }
    // 篩出個別 element type & name
    var result = new Array();
    for (var i = 0; i < origin.length; i++) {
        var flag = true;
        if (result.length > 0) {
            for (var j = 0; j < result.length; j++) {
                //依 elementType 與 elementName 作區別
                if (result[j][1] == origin[i][1] & result[j][0] == origin[i][0]) {
                    flag = false;
                }
            }
        }
        if (flag) {
            result.push(origin[i]);
        }
    }

    for (var i = 0; i < result.length; i++) {
        var ul = document.createElement('ul');
        ul.setAttribute("id", result[i][1] + result[i][0]);
        ul.innerHTML = "<strong>" + result[i][1] + "</strong> ";
        switch (result[i][0]) {
            case (0):
                ul.innerHTML += "<font size='1'>Component</font>";
                break;
            case (1):
                ul.innerHTML += "<font size='1'>Interface</font>";
                break;
            case (2):
                ul.innerHTML += "<font size='1'>Class</font>";
                break;
        }

        var functionPoint = 0;
        datas.forEach(function(data) {
            if (data.elementName == result[i][1]) {
                functionPoint += data.functionPoint;
                var li = document.createElement('li');

                var operation = "";
                operation += data.visibility; // function
                if (data.isVoid) {
                    operation += " void ";
                } else {
                    for (var j = 0; j < data.parameterKind.length; j++) {
                        if (data.parameterKind[j] == "return") {
                            operation += " " + data.parameterDataType[j] + " ";
                        }
                    }
                }
                operation += data.functionName + "（";
                var otherParameter = false;
                for (var j = 0; j < data.parameterKind.length; j++) {
                    if (data.parameterKind[j] == "in") {
                        if (otherParameter) {
                            operation += ", "
                        }
                        operation += " " + data.parameterDataType[j] + " " + data.parameter[j];
                    }
                    otherParameter = true;
                }

                li.innerHTML = operation + "）";
                ul.appendChild(li);
            }
        })
        ul.innerHTML += "<u>Function Point：" + functionPoint + "</u>";
        analyzeResultGrid.appendChild(ul);
    }
}

function deleteFile() {
    event.preventDefault();
    if (confirm("確定要刪除檔案嗎？")) {
        var fileId = $(event.target).data('id');
        // console.log(fileId);
        $.ajax({
                url: 'ajax/deleteFile.php',
                type: 'POST',
                dataType: 'json',
                data: { "fileId": fileId }
            })
            .done(function(response) {
                // console.log(response);
                if (response.status == 1) {
                    alert('刪除檔案成功');
                    getFile();
                } else if (response.status == 2) {
                    alert(response.msg)
                } else if (response.status == 3) {
                    alert(response.msg);
                    location.reload();
                }
            })
            .fail(function(error) {
                // console.log(error);
                alert('刪除檔案失敗，請重新再試');
            });
    }
}

function saveRecord() {
    var fileId = $("#analyzeResultGrid").data('fileid');
    $.ajax({
            url: 'ajax/saveRecord.php',
            type: 'POST',
            dataType: 'json',
            data: {
                "fileId": fileId,
                "analyzeResult": analyzeResult
            }
        })
        .done(function(response) {
            if (response.status == 1) {
                alert('儲存分析結果成功！');
            } else if (response.status == 2) {
                alert(response.msg);
            }
        })
        .fail(function(error) {
            alert('儲存結果失敗，請重新再試');
        })
}

function closeModal() {
    analyzeResult = null;
    $("#analyzeResultGrid").html("");
    $("#analyzeResultGrid").attr("data-fileId", null);
}