$(document).ready(function() {
    $("#signUpForm").submit(function(event) {
        event.preventDefault(); // 避免提交表單刷新頁面
        var email = $("input[name='email']").val();
        var username = $("input[name='username']").val();
        var password = $("input[name='password']").val();
        var repassword = $("input[name='repassword']").val();
        if (username == "") {
            $('#errorText').html('帳號不可為空');
        } else if (password == "") {
            $('#errorText').html('密碼不可為空');
        } else if (repassword != password) {
            $('#errorText').html('再次輸入密碼與密碼不同');
        } else if (email == "") {
            $('#errorText').html('電子郵件不可為空');
        } else {
            var newUser = {
                "email": email,
                "username": username,
                "password": password
            };
            $.ajax({
                    url: 'ajax/addUser.php',
                    type: 'POST',
                    dataType: 'json',
                    data: newUser
            })
            .done(function(response) {
                if (response.status == 1) {
                    $('#errorText').html('');
                    alert('註冊成功，為您轉跳登入畫面!');
                    window.location.href = 'signin.php';
                } else if (response.status == 2) {
                    $('#errorText').html(response.msg);
                }
            })
            .fail(function(error) {
                $('#errorText').html('連線失敗請重新再試');
            });
        }
    });
});