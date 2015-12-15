<a href="index.php">Главная</a> | <a href="index.php?page=<?php echo $page?>">Назад к статьям</a> | <a href="index.php?c=editor">Консоль редактора</a>
<hr />
<h1><?php echo $article['article_title']?></h1>
<div class="content"><?php echo nl2br($article['article_content'])?></div>
<div class="comments">
	<?php echo $comments?>
</div>