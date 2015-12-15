Комментарии<br />
<?php foreach($comments as $row):?>
<div class="comment">
<em><?php echo $row['comment_author']?></em> написал <small><?php echo $row['mod_time']?></small>:<br />
&nbsp;&nbsp;<?php echo $row['comment_content']?><br />
</div>
<?php endforeach?>
<div class="error"><?php echo $err?></div>
<div class="result"><?php echo $res?></div>
Ваш комментарий:<br />
<form method="post" action="index.php?act=view&amp;id=<?php echo $article['article_id']?>&amp;page=<?php echo $page?>">
Имя:<br />
<input type="text" name="author"><br />
Комментарий:<br />
<textarea name="content"></textarea>
<input type="hidden" name="article_id" value="<?php echo $article['article_id']?>"><br />
<input type="submit" value="Отправить">
</form>