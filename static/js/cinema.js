let deleteButton = $('.delete-button');
let changeButton = $('.change-button');

deleteButton.each((index, element)=>{
    $(element).on('click',()=>{
        //二次确认弹窗
        if(confirm('确认删除该电影？')) {
            $.ajax({
                url: '../server/cinemaServer.php',
                type: 'POST',
                data: {
                    'command': 'delete',
                    'id': $(element).attr('data-id')
                },
                success: (response) => {
                    if (response.status === 'success') {
                        // window.location.reload();
                    } else {
                    }
                }
            })
        }
    })
})
let changeForm=$('#editForm');
let overlay=$('#overlay');
let closeButton=$('.formClose');

closeButton.on('click',()=>{
    overlay.css('display', 'none')
    changeForm.css('display', 'none')
})
changeButton.each((index, element)=>{
    $(element).on('click',()=>{
        overlay.css('display', 'block')
        changeForm.css('display', 'block')
        let cinemaId=$(element).attr('data-id');
        let cinemaName=$(element).parent().siblings('.cinema-info').find('.cinema-name').text();
        let cinemaDirector=$(element).parent().siblings('.cinema-info').find('.cinema-director').text();
        let cinemaTime=$(element).parent().siblings('.cinema-info').find('.cinema-time').text();
        let cinemaCountry=$(element).parent().siblings('.cinema-info').find('.cinema-country').text();
        let cinemaLength=$(element).parent().siblings('.cinema-info').find('.cinema-length').text();
        let cinemaIntroduce=$(element).parent().siblings('.cinema-info').find('.cinema-introduce').text();
        changeForm.find('#name').text(cinemaName);
        changeForm.find('input[name=director]').val(cinemaDirector);
        changeForm.find('input[name=time]').val(cinemaTime);
        changeForm.find('input[name=country]').val(cinemaCountry);
        changeForm.find('input[name=length]').val(cinemaLength);
        changeForm.find('textarea[name=introduce]').val(cinemaIntroduce)
        })
})
let editButton=$('#editButton');
editButton.on('click',()=>{
    let data = changeForm.serialize();
    $.ajax({
        url: changeForm.attr('action'),
        type: changeForm.attr('method'),
        data: data,
        success: (response)=>{
            if(response.status === 'success'){
                alert('修改成功');
                window.location.reload();
            }else{
                alert(response.status);
            }
        }
    })
})