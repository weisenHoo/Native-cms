<html>
	<heard>
		<meta charset="gbk"/>
		<title>后盾框架——调试页面</title>
		<style type="text/css">
			* {margin: 0;padding: 0;}
			body {margin: 20px;}
			#debug {width: 960px;border: 1px solid #dcdcdc;padding: 10px;margin-top: 20px;}
			fieldset {padding: 10px;font-size: 14px;}
			legend {padding: 5px;}
			p {background: #666;color: #fff;font-size: 12px;padding: 3px 5px;margin-top: 10px;}
		</style>
	</heard>
	<body>
		
		<div id="debug">
			<h2>DEBUG</h2>
			<?php if(isset($e['message'])){ ?>
			<fieldset>
				<legend>TRACE</legend>
				<?php echo $e['message'] ?>
			</fieldset>
			<?php } ?>
			<?php if(isset($e['info'])){ ?>
			<fieldset>
				<legend>TRACE</legend>
				<?php echo $e['info'] ?>
			</fieldset>
			<?php } ?>
		</div>
		
	</body>
</html>