<a href="?c=editor">Консоль редактора</a> | <a href="?c=admin">Админка</a>
<hr />
<h1>Все статьи</h1>
<?php echo $paginator?>
<hr />
<?php foreach($articles as $article):?>
	<h2><a href="index.php?act=view&amp;id=<?php echo $article['article_id']?>&amp;page=<?php echo $page?>"><?php echo $article['article_title']?></a></h2>
	<div class="time"><?php echo $article['mod_time']?></div>
	<div class="content">
		<?php echo nl2br($article['article_content'])?>
		<?php if($article['readmore']):?>
			...<a class="readmore" href="index.php?act=view&amp;id=<?php echo $article['article_id']?>&amp;page=<?php echo $page?>">Читать далее</a>
		<?php endif?>
	</div>
<?php endforeach?>
<?php echo $paginator?>