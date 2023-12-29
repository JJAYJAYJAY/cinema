let searchButton=$('.search-btn');
searchButton.on('click',function(e){
    e.preventDefault()
    let form=$('#searchForm')
    let searchInput = form.find('[name="search"]').val();
    let trimmedSearchInput = searchInput.trim();
    form.find('[name="search"]').val(trimmedSearchInput);
    let data=form.serialize()
    console.log(data)
    $.ajax({
        url:form.attr('action'),
        type:'POST',
        data:data,
        success:function(response){
            $('.search-result').html(response)
        }
    })
})