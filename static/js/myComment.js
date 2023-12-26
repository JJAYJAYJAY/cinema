let editCommentButtons = $('.edit-comment')
let commentForm = $('#commentForm')

editCommentButtons.each((index,button)=>{
    $(button).on('click',()=>{
        openForm();
        //初始化一下表格
        let content = $(button).parent().siblings('.comment-content').children('.comment-text').text().trim();
        let score= $(button).parent().siblings('.comment-content').children('.stars').children('.score').text();
        for(let i = 0; i < Number(score)/2; i++){
            formStars.children().eq(i).attr('src', '../../static/image/star_hollow_hover.png')
        }
        for(let i = 0; i < Number(score)/2; i++){
            formStars.children().eq(i).attr('src', '../../static/image/star_onmouseover.png')
        }
        commentForm.children('#starsInput').attr('value', score);
        commentForm.children('.form-comment').val(content);
        commentForm.children('#commentId').attr('value',$(button).attr('comment-id'));
    })
})