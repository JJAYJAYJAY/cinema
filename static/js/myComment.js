let editCommentButtons = $('.edit-comment')
let commentForm = $('#commentForm')
let deleteCommentButtons = $('.delete-comment')
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

deleteCommentButtons.each((index,button)=>{
      $(button).on('click',()=>{
          if(confirm('确定删除该评论吗？')) {
              let commentId = $(button).attr('comment-id')
              $.ajax({
                  url: '../server/myCommentServer.php',
                  type: 'POST',
                  data: {
                      command: 'deleteComment',
                      commentId: commentId
                  },
                  success: (data) => {
                      if (data.status === 'success') {
                          alert("删除成功")
                          $(button).parent().parent().remove()
                      }
                  }
              })
          }
      })
})