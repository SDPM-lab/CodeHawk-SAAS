$(document).ready(function() {
    $("#accountForm").submit(function(){
        event.preventDefault();
        var username = $("input[name='username']").val();
        var password = $("input[name='password']").val();
        var email = $("input[name='email']").val();
        if (username == "") {
            $('#errorText').html('帳號不可為空');
        } else if (password == "") {
            $('#errorText').html('密碼不可為空');
        } else if ($("input[name='repassword']").length > 0) {
            var repassword = $("input[name='repassword']").val();
            if(repassword != password){
                $('#errorText').html('再次輸入密碼與密碼不同');
            }
        } else if (email == "") {
            $('#errorText').html('電子郵件不可為空');
        } else {
            $.ajax({
                url: 'ajax/updateUser.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    "email": email,
                    "username": username,
                    "password": password
                }
            })
            .done(function(response) {
                if (response.status == 1) {
                    $('#errorText').html('');
                    alert('修改個人資料成功!');
                    location.reload();
                } else if (response.status == 2) {
                    $('#errorText').html(response.msg);
                }
            })
            .fail(function(error) {
                console.log(error);
                $('#errorText').html('連線失敗請重新再試');
            });
        }
    });

    getUserInfo();

    $("input[name='username']").click(function(){ unlock() });
    $("input[name='password']").click(function(){ unlock()} );
    $("input[name='email']").click(function(){ unlock()} );
    $("#cancel_btn").click(function(){ cancelModify() });
});

function getUserInfo(){
    $.ajax({
        url: 'ajax/getUser.php',
        type: 'POST',
        dataType: 'json'
    })
    .done(function(response) {
        if (response.status == 1) {
            $("input[name='username']").val(response.user.username);
            $("input[name='password']").val(response.user.password);
            $("input[name='email']").val(response.user.email);
        } else if (response.status == 2) {
            $('#errorText').html(response.msg);
        }
    })
    .fail(function(error) {
        $('#errorText').html('連線失敗請重新再試');
    });
}

function unlock(){
    $("#hintText").html('');
    $(event.target).removeAttr("readonly");
    if(event.target.name == "password"){
        $("#repassword_div").html('');
        $("input[name='password']").val('');
        var div = document.createElement("div");
        div.setAttribute("class","col-sm-8");
        var label = document.createElement("label");
        label.setAttribute("for","email");
        label.setAttribute("class","col-sm-4 col-form-label");
        label.innerHTML = "再次輸入密碼";

        var input = document.createElement("input");
        input.setAttribute("type","password");
        input.setAttribute("class","form-control");
        input.setAttribute("name","repassword");
        input.setAttribute("placeholder","再次輸入密碼");
        input.setAttribute("required",true);
        div.appendChild(input);
        $("#repassword_div").append(label);
        $("#repassword_div").append(div);
        $("#repassword_div").css("display","");
    }
}

function cancelModify(){
    getUserInfo();
    $("#repassword_div").html('');
    $("input[name='username']").attr("readonly",true);
    $("input[name='password']").attr("readonly",true);
    $("input[name='email']").attr("readonly",true);
}