let btn = $('.control a');
let loginForm = $('.form-login');
let regiserForm = $('.form-register');
let photo = $('.div-description');

btn.eq(0).on('click', function(e) {
    loginForm.removeClass('div-form-left').addClass('div-form-hidden');
    regiserForm.removeClass('div-form-hidden').addClass('div-form-right');
    photo.addClass('div-description-left').removeClass('div-description-right');
});
btn.eq(1).on('click', function(e) {
    loginForm.removeClass('div-form-hidden').addClass('div-form-left');
    regiserForm.removeClass('div-form-right').addClass('div-form-hidden');
    photo.addClass('div-description-right').removeClass('div-description-left');
});

$("#loginButton").on("click", function (e) {
    e.preventDefault();
    let form = $(".form-login");
    // Get form data
    let formData = form.serialize();

    // Ajax request
    $.ajax({
        type: "POST",
        url: form.attr("action"),
        data: formData,
        success: function(response) {
            if (response.status === 'success') {
                window.location.href = 'homeTemplate.php';
            } else {
                alert("用户名或密码错误")
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("Ajax request failed: ", textStatus, errorThrown);
        }
    });
});

let inputBoxes= $(".input-box");
inputBoxes.on("focus", "input", function () {
    $(this).next().removeClass("error");
    $(this).next().removeClass("correct");
});
inputBoxes.on("blur", "input", function () {
    let input = $(this).val();
    let index = $(this).parent().index()-1;
    switch (index){
        case 0:
            if(input.length < 1 || input.length > 10){
                $(this).next().addClass("error");
            }
            else {
                $(this).next().addClass("correct");
            }
            break;
        case 1:
            if(input.length < 1 || input.length > 18 || !/^\w+@\w+(\.\w+)+$/.test(input)){
                $(this).next().addClass("error");
            }else {
                $(this).next().addClass("correct");
            }
            break;
        case 2:
            //检测手机号是否合法
            if(!/^1[3-9]\d{9}$/.test(input)){
                $(this).next().addClass("error");
            } else {
                $(this).next().addClass("correct");
            }
            break;
        case 3:
            //检测密码是否是8-16位
            if(input.length < 8 || input.length > 16){
                $(this).next().addClass("error");
            } else {
                $(this).next().addClass("correct");
            }
            break;
        case 4:
            //检测密码是否一致
            if(input !== $(".input-box input").eq(3).val()){
                $(this).next().addClass("error");
            } else {
                $(this).next().addClass("correct");
            }
            break;
    }
});
function checkAll(inputBoxes) {
    let flag = true;
    inputBoxes.each(function () {
        let input = $(this).children("input").val();
        let index = $(this).index()-1;
        switch (index){
            case 0:
                if(input.length < 1 || input.length > 10){
                    $(this).children().next().addClass("error");
                    flag=false;
                }
                else {
                    $(this).children().next().addClass("correct");
                }
                break;
            case 1:
                if(input.length < 1 || input.length > 18 || !/^\w+@\w+(\.\w+)+$/.test(input)){
                    $(this).children().next().addClass("error");
                    flag=false;
                }
                else {
                    $(this).children().next().addClass("correct");
                }
                break;
            case 2:
                //检测手机号是否合法
                if(!/^1[3-9]\d{9}$/.test(input)){
                    $(this).children().next().addClass("error");
                    flag=false;
                }
                else {
                    $(this).children().next().addClass("correct");
                }
                break;
            case 3:
                //检测密码是否是8-16位
                if(input.length < 8 || input.length > 16){
                    $(this).children().next().addClass("error");
                    flag=false;
                }
                else {
                    $(this).children().next().addClass("correct");
                }
                break;
            case 4:
                let password=$(".input-box input").eq(3).val()
                //检测密码是否一致
                if( input.length < 8 || input.length > 16 ||input !== password){
                    $(this).children().next().addClass("error");
                    flag=false;
                }
                else {
                    $(this).children().next().addClass("correct");
                }
                break;
        }
    });
    return flag;
}
$("#registerButton").on("click", function (e) {
    e.preventDefault();
    if(checkAll(inputBoxes)){
        let form = $(".form-register");
        // Get form data
        let formData = form.serialize();
        $.ajax({
            url: form.attr("action"),
            type: "POST",
            data: formData,
            success: function(response) {
                if (response.status === 'success') {
                    alert("注册成功");
                } else {
                    alert(response.message)
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Handle error
                console.log("Ajax request failed: ", textStatus, errorThrown);
            }
        })
    }
});