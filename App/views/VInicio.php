<?
	#
	# Inicio View File 
	#
?>

<?=CHtml::tag('h1',array(),'Ejemplo de aplicacion usando Lore Framework')?>
<?=CHtml::tag('h2',array(),'Pagina de inicio')?>

<h3>Tests</h3>
<h4>Form</h4>
<form method="POST" action="<?=ACTION.'TestForm'?>">
	<input type="text" name="Name" placeholder="Nombre" autocomplete="off" required/><a href="#" title="Campo obligatorio">(*)</a><br>
	<input type="text" name="Pass" placeholder="Pass" autocomplete="off" required/><a href="#" title="Campo obligatorio">(*)</a><br>
	<input type="text" name="Comentario" placeholder="Comentario" autocomplete="off"/><br>
	<input type="submit" value="Enviar" />
</form>

<h4>Database</h4>
<form method="POST" action="<?=ACTION.'TestBD'?>">
	<input type="text" name="testbd" placeholder="String de prueba" autocomplete="off"/><br>
	<input type="submit" value="Enviar" />
</form>




<h2>Resultado Test</h2>
<? if(isset($data['form'])){ 
print_r($data['form']);
} ?>