<a href="index.php">Главная</a> | <a href="index.php?c=editor">Консоль редактора</a>
<hr />
<h1>Добавление статьи</h1>
<div class="error"><?php echo $err?></div>
<div class="result"><?php echo $res?></div>
<form action="index.php?c=editor&amp;act=new" method="post" enctype="multipart/form-data">
	Заголовок статьи<br />
	<input type="text" name="title" size="100" value="<?php echo $article_title?>" /><br />
	Текст статьи:<br />
	<textarea name="content" cols="100" rows="20"><?php echo $article_content?></textarea><br />
	<input type="hidden" name="action" value="add" />
	<input type="submit" value="Добавить" />
</form>