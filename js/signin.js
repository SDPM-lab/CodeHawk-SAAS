$(document).ready(function() {
    $("#signInForm").submit(function(event) {
        event.preventDefault(); // 避免提交表單刷新頁面

        var username = $("input[name='username']").val();
        var password = $("input[name='password']").val();
        if (username == "") {
            alert('帳號不可為空');
            return false;
        } else if (password == "") {
            alert('密碼不可為空');
            return false;
        } else {
            $.ajax({
                    url: 'ajax/signIn.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        "username": username,
                        "password": password
                    }
                })
                .done(function(response) {
                    if (response.status == 1) {
                        // alert('登入成功');
                        window.location.href = 'index.php';
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
});