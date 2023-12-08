let stars = $('#stars');
let formStars = $('#formStars');

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
    $('#commitForm').css('display', 'block')
}
function closeForm (){
    $('#overlay').css('display', 'none')
    $('#commitForm').css('display', 'none')
}
$('#writeCommit').on('click', ()=> openForm());
$('#formClose').on('click', ()=> closeForm());
stars.children().each((index, element)=>{
    $(element).on('click', ()=>{
        openForm();
        for(let i = 0; i <= index; i++){
            formStars.children().eq(i).attr('src', '../../static/image/star_onmouseover.png')
        }
        $('#starsInput').attr('value', (index+1)*2)
    });
});

formStars.children().each((index, element)=>{
    $(element).on('click', ()=>{
        $('#starsInput').attr('value', (index+1)*2)
    });
});

$('#commitButton').on('click', (event)=>{
    event.preventDefault();
    let form = $('#form');
    let data = form.serialize();
    $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: data,
        success: (response)=>{
            if(response.status === 'success'){
                alert('评论成功');
                closeForm();
            }else{
                alert(response.status);
            }
        }
    })
})

$('.good-button').each((index, element)=>{
    $(element).on('click', ()=>{

        $.ajax({
            url: '../server/detailsServer.php',
            type: 'POST',
            data: {
                'command':'addGood',
                'time':$(element).parent().siblings('.time').text(),
                'who':$(element).parent().siblings('.who').text(),
                'cinema':$('.cinema-name').text().trim()
            },
            success: (response)=>{
                if(response.status === 'success'){
                    $(element).prevAll('.count').text(parseInt($(element).prevAll('.count').text())+1)
                }else{
                    alert("失败")
                }
            }
        })
    })
})