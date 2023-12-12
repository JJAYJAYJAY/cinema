let changeButtons=$('.change-button');
let deleteButtons=$('.delete-button');

changeButtons.each((index,element)=>{
    $(element).on('click',()=>{
        let id=$(element).attr('data-id');
        if(confirm('确定要把这位用户变为管理员权限吗？')){
            $.ajax({
                url:'../server/adminServer.php',
                type:'POST',
                data:{
                    'command':'changePower',
                    'id':id
                },
                success:(response)=>{
                    if(response.status==='success'){
                        alert('修改成功');
                        window.location.reload();
                    }else{
                        alert(response.status);
                    }
                }
            })
        }
    })
})

deleteButtons.each((index,element)=>{
  $(element).on('click',()=>{
    let id=$(element).attr('data-id');
    if(confirm('确定要删除这位用户吗？')){
      $.ajax({
        url:'../server/adminServer.php',
        type:'POST',
        data:{
          'command':'deleteUser',
          'id':id
        },
        success:(response)=>{
          if(response.status==='success'){
            alert('删除成功');
            window.location.reload();
          }else{
            alert(response.status);
          }
        }
      })
    }
  })
})