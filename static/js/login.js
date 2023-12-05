$("#login-button").on("click", function (e) {
    e.preventDefault();
    let form = $("#login-form");
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