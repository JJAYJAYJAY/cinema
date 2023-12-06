let stars=$('#stars')

stars.children().each(function (index, element){
    console.log(element)
    $(element).on('mouseenter', function (){
        $(this).prevAll().attr('src', '../../static/image/star_onmouseover.png')
        $(this).attr('src', '../../static/image/star_onmouseover.png')
    })
    $(element).on('mouseleave', function (){
        $(this).prevAll().attr('src', '../../static/image/star_hollow_hover.png')
        $(this).attr('src', '../../static/image/star_hollow_hover.png')
    })
});