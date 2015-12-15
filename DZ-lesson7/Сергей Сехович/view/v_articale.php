<?php if (isset($res)) :?>
	<p class="<?php echo $css; ?>"><?php echo $res ?></p>
<?php endif  ?>

<?php if (isset($param)) :?>
          <h1> <?php echo $param['title'];?></h1>
          <p>  <?php echo$param['text']; ?> <br>
               <strong>  <?php echo $param['date'];;?> </strong><br>
           </p>	 
<?php endif ?>	


<form method="post">
	<input type="text" name="name_comment"><br/><br/>
	<textarea name="text_comment" rows="15" cols="45"></textarea>
	<br/>
	<input type="submit" value="коментировать" />
</form>
 <a class="btn" href="/"> <?php echo INDEX; ?></a>
<?php if (isset($comment)):  ?>
 <div class="comments"> 

			<?php 	foreach ($comment as $item): ?>			
			 <div>
			 	<h4> <span>Имя:</span> <?php echo $item['name'];  ?></h4>
			 	<span>Коментарий:</span><p><?php echo $item['text'];  ?> 
			 	<a href="/?c=page&act=view&id=<?php echo $_GET['id']; ?>&del=<?php echo $item['id'] ?>"> удалить</a>

			 	</p>
			</div>
			<?php endforeach ?>
		
 </div>
<?php endif ?>	