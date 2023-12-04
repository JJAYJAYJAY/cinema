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
                }
                else {
                    $(this).children().next().addClass("correct");
                }
                flag=false;
                break;
            case 1:
                if(input.length < 1 || input.length > 18 || !/^\w+@\w+(\.\w+)+$/.test(input)){
                    $(this).children().next().addClass("error");
                }
                else {
                    $(this).children().next().addClass("correct");
                }
                flag=false;
                break;
            case 2:
                //检测手机号是否合法
                if(!/^1[3-9]\d{9}$/.test(input)){
                    $(this).children().next().addClass("error");
                }
                else {
                    $(this).children().next().addClass("correct");
                }
                flag=false;
                break;
            case 3:
                //检测密码是否是8-16位
                if(input.length < 8 || input.length > 16){
                    $(this).children().next().addClass("error");
                }
                else {
                    $(this).children().next().addClass("correct");
                }
                flag=false;
                break;
            case 4:
                let password=$(".input-box input").eq(3).val()
                //检测密码是否一致
                if( input.length < 8 || input.length > 16 ||input !== password){
                    $(this).children().next().addClass("error");
                }
                else {
                    $(this).children().next().addClass("correct");
                }
                flag=false;
                break;
        }
    });
    return flag;
}

$("#register").on("click", function (e) {
    e.preventDefault();
    if(checkAll(inputBoxes)){
        $("#register-form").trigger("submit")
    }
});
