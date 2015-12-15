<a href="index.php">Главная</a> | <a href="index.php?c=users&amp;act=logout">Выход</a>
<hr />
<h1>Консоль редактора</h1>
<div class="error"><?php echo $err?></div>
<div class="result"><?php echo $res?></div>
<?php echo $paginator?>
<ul>
<li><a href="index.php?c=editor&amp;act=add">Добавить статью</a></li>
<?php foreach($articles as $article):?>
	<li>
		<a href="index.php?c=editor&amp;act=edit&amp;id=<?php echo $article['article_id']?>"><?php echo $article['article_title'].' <span class="time">('.$article['mod_time'].')</span>'?></a>&nbsp;
		<a href="index.php?c=editor&amp;act=delete&amp;id=<?php echo $article['article_id']?>"><img src="./v/img/del.png" alt="Удалить" /></a>
	</li>
<?php endforeach?>
</ul>
<?php echo $paginator?>