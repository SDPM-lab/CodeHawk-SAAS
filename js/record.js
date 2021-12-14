$(document).ready(function () {
    window.analyzeRecord = null;
    getProjectRecord();

    $("#project_select").change(function (e) {
        var projectId = e.target.value;
        getRecordByProjectId(projectId);
    });
});

function getProjectRecord() {
    $.ajax({
        url: 'ajax/getProjectRecord.php',
        type: 'GET',
        dataType: 'json'
    })
        .done(function (response) {
            renderDropdown(response);
        })
        .fail(function (error) {
            alert('取得紀錄失敗，請重新再試');
        });
}

function renderDropdown(data) {
    var dropdown = document.getElementById("project_select");
    for (var i = 0; i < data.length; i++) {
        var option = document.createElement("option");
        option.setAttribute("value", data[i].projectId);
        option.innerHTML = data[i].projectName;
        dropdown.appendChild(option);
    }
}

function getRecordByProjectId(projectId) {
    $.ajax({
        url: 'ajax/getFileRecord.php',
        type: 'POST',
        dataType: 'json',
        data: { "projectId": projectId }
    })
        .done(function (response) {
            // console.log(response);
            analyzeRecord = response;
            if (response.length > 0) {
                renderTable(response);
            }
        })
        .fail(function (error) {
            console.log(error);
            alert('取得紀錄失敗，請重新再試');
        });
}

function renderTable(data) {
    var newTabEl = function (active,id, href, ariaControls, ariaSelected, tabName) {
        return `<a class="nav-link ${active}"  
                    id="${id}"
                    data-toggle="pill"
                    href="#${href}"
                    role="tab"
                    aria-controls="${ariaControls}"
                    aria-selected="${ariaSelected}">${tabName}</a>`;
    };

    var newContentEl = function (id, ariaLabelledby) {
        return `<div class="tab-pane fade show active"
                    id="${id}"
                    role="tabpanel"
                    aria-labelledby="${ariaLabelledby}"></div>`;
    }

    var alltabEl = "";
    var allContentEl = "";
    var i = 0;
    data.forEach(function (el) {
        alltabEl += newTabEl((i++ == 0 ? "active" : ""),`v-pills-${el.fileId}-tab`, `#v-pills-${el.fileId}`, `v-pills-${el.fileId}`, (i++ == 0 ? "true" : "false"), el.fileName);
        allContentEl += newContentEl(`v-pills-${el.fileId}`, `v-pills-${el.fileId}-tab`);
    });

    document.querySelector("#v-pills-tab").innerHTML = alltabEl;
    document.querySelector("#v-pills-tabContent").innerHTML = allContentEl;

}