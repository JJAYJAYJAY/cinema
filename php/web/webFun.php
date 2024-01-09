<?php
function getImages(mysqli $dbc,string $name){
    $result=safeSelectQuery($dbc,
        'select * from images where name=?',
        [$name]);
    return $result->fetch_row()[1];
}

/**
 * @throws Exception
 */
function getMovie($dbc, $name){
    if(!is_string($name)||$name==='')
        throw new Exception('name must be string');
    $result=safeSelectQuery($dbc,
        'select * from cinema where name=?',
        [$name]);
    if($result->num_rows===0)
        throw new Exception('no such movie');
    return $result->fetch_row();
}
function addCinemaItems(string $title,$content){
    echo <<<EOF
    <div class="cinema-item">
        <div class="cinema-item-title">$title</div>
        <div class="cinema-item-content">$content</div>
    </div>
EOF;
}
function addCommentCard(Comment $comment){
    global $user;
    $content= htmlspecialchars($comment->getContent(), ENT_QUOTES, 'UTF-8');
    $content=nl2br($content);
    $n=$comment->getScore()/2;
    $commentId = $comment->getId();
    $who = $comment->getWho();
    $time = $comment->getTime();
    $good = $comment->getGood();
    $isAdmin = $user->getPower()==='admin';
    ob_start();
    ?>
    <div class="comment-card">
        <div class="small-title">
            <span class="who"><?= $who ?></span>
            <span class="stars">
                <?php for($i=0;$i<5;$i++): ?>
                    <?php if($i<$n): ?>
                        <img class="star" src="../../static/image/star_onmouseover.png" alt="">
                    <?php else: ?>
                        <img class="star" src="../../static/image/star_hollow_hover.png" alt="">
                    <?php endif; ?>
                <?php endfor; ?>
            </span>
            <span class="time"><?= $time ?></span>
            <span class="good"><span><?= $good ?></span><span data-id="<?= $commentId ?>" class="good-button">赞</span></span>
        </div>
        <div class="comment-content"><?= $content ?></div>
        <?php if($isAdmin): ?>
            <div class='delete-div'><a data-id='<?= $commentId ?>' class='cinema-delete-button'>删除</a></div>
        <?php endif; ?>
    </div>
    <?php
    return ob_get_clean();
}

function addEditItems(string $title,$content,string $type,string $name){
    echo <<<EOF
    <div class="edit-item">
        <div class="edit-item-title">$title</div>
        <input type="$type" class="edit-item-content" name="$name" value="$content" >
    </div>
EOF;
}

/**
 * @param Cinema $cinema
 * @return void
 */
function addEditFrom(Cinema $cinema,$action){
    echo <<<EOF
        <form class="form edit-form" id="editForm" action="{$action}" method="post">
            <div class="form-header">
                <span>编辑</span> <a class="formClose">x</a>
            </div>
            <input type="hidden" name="command" value="edit">
            <input type="hidden" name="cinema" value="{$cinema->getName()}">
            <div class="edit-item">
                <div class="edit-item-title">电影名称:</div>
                <div style="line-height: 30px" id="name">{$cinema->getName()}</div>
            </div>
EOF;
    addEditItems('上映时间:',$cinema->getTime(),"date","time");
    addEditItems('导演:',$cinema->getDirector(),"text","director");
    addEditItems('制片国家/地区:',$cinema->getCountry(),"text","country");
    addEditItems('电影时长:',$cinema->getLength(),"text","length");
    echo <<<EOF
            <div class="comment-label">电影简介:</div>
            <textarea class="form-introduce" name="introduce" id="introduce" placeholder="电影简介">{$cinema->getIntroduce()}</textarea>
            <input class="edit-submit-button" type="submit" value="修改" id="editButton">
        </form>
EOF;
}

function addUserCard($user)
{
    echo <<<EOF
    <tr class="user-card">
        <td>{$user->getUsername()}</td>
        <td>{$user->getPower()}</td>
        <td>{$user->getEmail()}</td>
        <td>{$user->getPhone()}</td>
        <td>
            <button class="change-button" data-id="{$user->getId()}">修改</button>
        </td>
        <td>
            <button class="cinema-delete-button" data-id="{$user->getId()}" data-id="{$user->getId()}">删除</button>
        </td>    
    </tr>
EOF;
}
function addPagination($page, $totalPage): string
{
    $range = 2;
    $showitems = ($range * 2) + 1;
    $html = '';

    if ($totalPage > 1) {
        $html .= '<div class="page-header">';
        if ($page > 2 && $page > $range + 1 && $showitems < $totalPage) $html .= "<a href='?page=1'>首页</a>";
        if ($page > 1) $html .= "<a href='?page=" . ($page - 1) . "'>上一页</a>";
        $html .= '</div>';
        $html .= '<div class="page-number">';
        for ($i = 1; $i <= $totalPage; $i++) {
            if (1 != $totalPage && (!($i >= $page + $range + 1 || $i <= $page - $range - 1) || $totalPage <= $showitems)) {
                $html .= ($page == $i) ? "<span class='current'>" . $i . "</span>" : "<a href='?page=" . $i . "' class='inactive'>" . $i . "</a>";
            }
        }
        $html .= '</div>';
        $html .= '<div class="page-tail">';
        if ($page < $totalPage) $html .= "<a href='?page=" . ($page + 1) . "'>下一页</a>";
        if ($page < $totalPage - 1 && $page + $range - 1 < $totalPage && $showitems < $totalPage) $html .= "<a href='?page=" . $totalPage . "'>尾页</a>";
        $html .= '</div>';
    }

    return $html;
}
/**
 * @param $comment Comment
 * @return void
 */
function addMyComment(Comment $comment): string {
    $content = htmlspecialchars($comment->getContent(), ENT_QUOTES, 'UTF-8');
    $content = nl2br($content);
    $n = $comment->getScore() / 2;
    $stars = '';
    for ($i = 0; $i < 5; $i++) {
        if ($i < $n) {
            $stars .= '<img class="star" src="../../static/image/star_onmouseover.png" alt="">';
        } else {
            $stars .= '<img class="star" src="../../static/image/star_hollow_hover.png" alt="">';
        }
    }

    return <<<EOF
    <div class="comment-card">
        <div class="comment-header">
            <span class="comment-user">
                <span>{$comment->getWho()}</span>
            </span>
            <span class="delete-comment" comment-id="{$comment->getId()}">删除</span>
            <span class="edit-comment" comment-id="{$comment->getId()}">修改</span>
        </div>
        <div class="comment-content">
            <span class="stars">
            <span class="score" hidden>{$comment->getScore()}</span>
            $stars
            </span>
            <div class="comment-text">
                <span>$content</span>
            </div>
        </div>
        <div class="comment-tail">
             <span class="comment-time">{$comment->getTime()}</span>·
             <span>{$comment->getCinema()}</span>·
            <span>{$comment->getGood()}赞</span>
        </div>
    </div>
EOF;
}
/**
 * @param $dbc mysqli
 * @param $name string
 * @return void
 */
function addCinemaCard(mysqli $dbc, string $name){
    $result=safeSelectQuery($dbc,
        'select * from images where name=?',
        [$name]);
    echo <<<EOF
    <div class="cinema-card">
        <div class="cinema-image">
            <img src="../../{$result->fetch_row()[1]}" alt="加载失败">
        </div>
        <div class="content">
            <div class="cinema-name">$name</div>
        <div class="button-div">
            <a href="cinemaDetails.php?name=$name" target="_blank" class="go-button">
                <span class="button-content">查看详情</span>
            </a>
        </div>       
        </div>
    </div>
EOF;
}
