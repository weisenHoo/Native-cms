<?php
class indexControl extends Control{
	function index(){
		$up = new upload();
		$up->upload();
	}
}
?>