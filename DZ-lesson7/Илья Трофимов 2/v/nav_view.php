<div class="nav">
	<?php if($page>1):?>
		<a href="index.php?<?php echo isset($controller) ? "c={$controller}&amp;" : ''?>page=<?php echo $page-1?>">Назад</a>
	<?php else:?>
		<span class="disabled">Назад</span>
	<?php endif?>
	<?php for($i=1;$i<=$pages;$i++):?>
		<a href="index.php?<?php echo isset($controller) ? "c={$controller}&amp;" : ''?>page=<?php echo $i?>"<?php echo $i==$page ? 'class="current_page"' : ''?>><?php echo $i?></a>
	<?php endfor?>
	<?php if($pages>1 && $page<$pages):?>
		<a href="index.php?<?php echo isset($controller) ? "c={$controller}&amp;" : ''?>page=<?php echo $page+1?>">Вперед</a>
	<?php else:?>
		<span class="disabled">Вперед</span>
	<?php endif?>
</div>