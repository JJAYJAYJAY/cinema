let items=$('.menu-item');
let iframe=$('iframe');
items.eq(0).on('click',function(){
    clearActive(items);
    $(this).addClass('active');
    iframe.attr('src','/home.php');
})

items.each(function(index){
    switch (index){
        case 0:
            $(this).on('click',function(){
                clearActive(items);
                $(this).addClass('active');
                iframe.attr('src','home.php');
            })
            break;
        case 1:
            $(this).on('click',function(){
                clearActive(items);
                $(this).addClass('active');
                iframe.attr('src','search.php');
            })
            break;
        case 2:
            $(this).on('click',function(){
                clearActive(items);
                $(this).addClass('active');
                iframe.attr('src','myComment.php');
            })
            break;
        case 3:
            $(this).on('click',function(){
                clearActive(items);
                $(this).addClass('active');
                iframe.attr('src','admin.php');
            })
            break;
    }
})

function clearActive(items){
    for(let i=0;i<items.length;i++){
        items.eq(i).removeClass('active');
    }
}