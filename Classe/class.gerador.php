<?php

class Gerador {

	public static function Form($link) {
		print "{{ Form::open(array('url' => '".$link."'')) }}";
	}

	public static function EndForm(){
		print "{{ Form::close() }}";
	}


	public static function Campos(array $campos){
		foreach ($campos['campos'] as $key => $campo) {
			
			print $campo;
			echo Form::label('email', 'E-Mail Address');
		}
	}
	

}