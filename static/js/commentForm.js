let formStars = $('#formStars');
formStars.children().each( (index, element)=>{
    $(element).on('mouseenter', function (){
        $(this).nextAll().attr('src', '../../static/image/star_hollow_hover.png')
        $(this).prevAll().attr('src', '../../static/image/star_onmouseover.png')
        $(this).attr('src', '../../static/image/star_onmouseover.png')
    })
    $(element).on('mouseleave', function (){
        let cnt=$('#starsInput').val()/2;
        $(this).prevAll().attr('src', '../../static/image/star_hollow_hover.png')
        $(this).attr('src', '../../static/image/star_hollow_hover.png')
        for(let i = 0; i < cnt; i++){
            formStars.children().eq(i).attr('src', '../../static/image/star_onmouseover.png')
        }
    })
});
function openForm (){
    $('#overlay').css('display', 'block')
    $('#commentForm').css('display', 'block')
}

$.fn.closeForm=function (){
    $('#overlay').css('display', 'none')
    this.parent().parent().css('display', 'none')
}

$('#writeComment').on('click', ()=> openForm());
$('.formClose').each((index, element)=>{
    $(element).on('click', ()=> {
        $(element).closeForm()
    })
});
formStars.children().each((index, element)=>{
    $(element).on('click', ()=>{
        $('#starsInput').attr('value', (index+1)*2)
    });
});

$('#commentButton').on('click', (event)=>{
    event.preventDefault();
    let form = $('#commentForm');
    let data = form.serialize();
    if(form.find('[name="content"]').val()===''){
        alert('评论内容不能为空');
        return;
    }
    $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: data,
        success: (response)=>{
            if(response.status === 'success'){
                alert('评论成功');
                form.find('.formClose').closeForm()
                window.location.reload();
            }else{
                alert(response.status);
            }
        }
    })
})