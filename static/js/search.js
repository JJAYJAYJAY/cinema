let searchButton=$('.search-btn');
searchButton.on('click',function(e){
    e.preventDefault()
    let form=$('#searchForm')
    let searchInput = form.find('[name="search"]').val();
    let trimmedSearchInput = searchInput.trim();
    form.find('[name="search"]').val(trimmedSearchInput);
    let data=form.serialize()
    $.ajax({
        url:form.attr('action'),
        type:'POST',
        data:data,
        success:function(response){
            let result=$('.search-result')
            result.html("")
            if(response.length === 0){
                result.append("<div style=\"text-align: center;width: 100%;color: #6e6e6e\">没有找到相关电影</div>")
            }
            else{
                for(let i=0;i<response.length;i++){
                    addCinemaCard(response[i].image,response[i].name,result)
                }
            }
        }
    })
})

function addCinemaCard(imageSrc, name,target) {
    let cinemaCard = `
    <div class="cinema-card">
        <div class="cinema-image">
            <img src="../../${imageSrc}" alt="加载失败">
        </div>
        <div class="content">
            <div class="cinema-name">${name}</div>
        <div class="button-div">
            <a href="cinemaDetails.php?name=${name}" target="_blank" class="go-button">
                <span class="button-content">查看详情</span>
            </a>
        </div>
        </div>
    </div>
    `;
    target.append(cinemaCard);
}