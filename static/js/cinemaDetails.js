let stars = $('#stars');
stars.children().each( (index, element)=>{
    $(element).on('mouseenter', function (){
        $(this).nextAll().attr('src', '../../static/image/star_hollow_hover.png')
        $(this).prevAll().attr('src', '../../static/image/star_onmouseover.png')
        $(this).attr('src', '../../static/image/star_onmouseover.png')
    })
    $(element).on('mouseleave', function (){
        $(this).prevAll().attr('src', '../../static/image/star_hollow_hover.png')
        $(this).attr('src', '../../static/image/star_hollow_hover.png')
    })
});
stars.children().each((index, element)=>{
    $(element).on('click', ()=>{
        openForm();
        formStars.children().each((index, element)=>{
            $(element).attr('src', '../../static/image/star_hollow_hover.png')
        })
        for(let i = 0; i <= index; i++){
            formStars.children().eq(i).attr('src', '../../static/image/star_onmouseover.png')
        }
        $('#starsInput').attr('value', (index+1)*2)
    });
});



$('.good-button').each((index, element)=>{
    $(element).on('click', ()=>{
        $.ajax({
            url: '../server/detailsServer.php',
            type: 'POST',
            data: {
                'command':'addGood',
                'time':$(element).parent().siblings('.time').text(),
                'who':$(element).parent().siblings('.who').text(),
                'cinema':$('.cinema-name').text().trim(),
                'userid':$('#userid').text().trim(),
                'commentId':$(element).attr('data-id')
            },
            success: (response)=>{
                if(response.status === 'success'){
                    $(element).siblings('span').text(parseInt($(element).siblings('span').text())+1)
                }else{}
            }
        })
    })
})

$('.cinema-delete-button').each((index,element)=>{
    $(element).on('click',()=>{
        //二次确认弹窗
        if(confirm('确认删除该评论？')) {
            $.ajax({
                url: '../server/detailsServer.php',
                type: 'POST',
                data: {
                    'command': 'deleteComment',
                    'commentId': $(element).attr('data-id')
                },
                success: (response) => {
                    if (response.status === 'success') {
                        window.location.reload();
                    } else {
                    }
                }
            })
        }
    })
})
$('.edit-button').on('click',()=>{
    $('#overlay').css('display', 'block')
    $('#editForm').css('display', 'block')
})

$('#editButton').on('click',()=>{
    let form = $('#editForm');
    let data = form.serialize();
    $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: data,
        success: (response)=>{
            if(response.status === 'success'){
                alert('修改成功');
                form.find('.formClose').closeForm()
                window.location.reload();
            }else{
                alert(response.status);
            }
        }
    })
})
