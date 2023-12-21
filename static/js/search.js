let searchButton=$('.search-btn');
searchButton.on('click',function(e){
    e.preventDefault()
    let form=$('#searchForm')
    let data=form.serialize()
    $.ajax({
        url:form.attr('action'),
        type:'POST',
        data:data,
        success:function(response){
            $('.search-result').html(response)
        }
    })
})