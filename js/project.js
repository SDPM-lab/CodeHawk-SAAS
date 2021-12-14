$(document).ready(function() {
    $("#projectForm").submit(function(event) {
        event.preventDefault(); // 避免提交表單刷新頁面

        var projectName = $("input[name='projectName']").val();
        if (projectName == "") {
            $('#errorText').html('專案名稱不可為空');
            return false;
        } else {
            $.ajax({
                    url: 'ajax/addProject.php',
                    type: 'POST',
                    dataType: 'json',
                    data: { "projectName": projectName }
                    // dataType: 'text',
                    // data: $("#projectForm").serialize()
                })
                .done(function(response) {
                    if (response.status == 1) {
                        $('#errorText').html('');
                        alert('新增專案成功！');
                        getProject();
                    } else if (response.status == 2) {
                        $('#errorText').html(response.msg);
                    }
                })
                .fail(function(error) {
                    // console.log(error.responseText);
                    $('#errorText').html(error.responseText);
                })
        }
    });

    getProject();
})

function getProject() {
    $.ajax({
            url: 'ajax/getProject.php',
            type: 'GET',
            dataType: 'json'
        })
        .done(function(response) {
            // console.log(response);
            renderTable(response);
        })
        .fail(function(error) {
            alert('取得專案資料失敗，請重新再試');
        });
}

function renderTable(data) {
    $('#projectTable').html('');
    var column = 5;
    var projectTable = document.getElementById('projectTable');
    for (var i = 0; i < data.length; i++) {
        var row = document.createElement('tr');
        var cell = new Array(column);

        for (var j = 0; j < column; j++) {
            cell[j] = document.createElement('td');
        }

        cell[0].innerHTML = data[i].projectName;
        cell[1].innerHTML = data[i].numberOfFile;
        cell[2].innerHTML = data[i].initiateDate;

        var viewButton = document.createElement('button');
        viewButton.innerHTML = '查看';
        viewButton.setAttribute('data-id', data[i].projectId);
        viewButton.setAttribute('type', 'button');
        viewButton.setAttribute('class', 'btn btn-info');
        viewButton.setAttribute('onClick', 'viewFile()');
        cell[3].appendChild(viewButton);

        var deleteButton = document.createElement('button');
        deleteButton.innerHTML = '刪除';
        deleteButton.setAttribute('data-id', data[i].projectId);
        deleteButton.setAttribute('type', 'button');
        deleteButton.setAttribute('class', 'btn btn-secondary');
        deleteButton.setAttribute('onClick', 'deleteProject()');
        cell[4].appendChild(deleteButton);

        for (var j = 0; j < column; j++) {
            row.appendChild(cell[j]);
        }
        projectTable.appendChild(row);
    }
}

function viewFile() {
    event.preventDefault();
    var projectId = $(event.target).data('id');
    $.ajax({
            url: 'ajax/viewFile.php',
            type: 'POST',
            dataType: 'json',
            data: { "projectId": projectId }
        })
        .done(function(response) {
            // console.log(response);
            if (response.status == 1) {
                window.location.href = 'filePage.php';
            } else if (response.status == 2) {
                alert("專案不存在");
            }
        })
        .fail(function(error) {
            // console.log(error);
            alert('取得專案檔案失敗，請重新再試');
        });
}

function deleteProject() {
    event.preventDefault();
    if (confirm('確定要刪除專案嗎？')) {
        var projectId = $(event.target).data('id');
        // console.log(projectId);
        $.ajax({
                url: 'ajax/deleteProject.php',
                type: 'POST',
                dataType: 'json',
                data: { "projectId": projectId }
            })
            .done(function(response) {
                if (response.status == 1) {
                    alert('刪除專案成功！');
                    getProject();
                } else if (response.status == 2) {
                    alert(response.msg);
                }
            })
            .fail(function(error) {
                alert('刪除專案失敗，請重新再試');
            });
    }
}