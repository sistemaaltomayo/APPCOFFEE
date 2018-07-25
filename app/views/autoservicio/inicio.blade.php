@extends('templateautoservicio')
@section('section')

<div class="container">
	<div class="row inicio">  

		<div class='col-xs-12 col-sm-12 col-md-12'>
			<div class='logo'>
				{{ HTML::image('img/logoautoservicio.png', 'logo coffee and arts') }}
			</div>
			<div class="titulo">
				<h1>{{strtoupper(array_search('00001', $tags))}}</h1>
			</div>
		</div>
		<div class='comerllevar col-xs-12 col-sm-12 col-md-12'>
			<div class="comeraca">
				{{ HTML::image('img/comeraca.png', 'comer aca') }}
					<a href="{{ url('/autoservicio/menu/tipoentrega') }}" class="btn btn-default">
                        {{strtoupper(array_search('00003', $tags))}}
                    </a>
			</div>
			<div class="llevar">
				{{ HTML::image('img/llevar.png', 'llevar') }}
					<a href="{{ url('/autoservicio/menu/llevar') }}" class="btn btn-default">
                        {{strtoupper(array_search('00004', $tags))}}
                    </a>
			</div>
			<div class="tituloidioma">
				<h1>{{strtoupper(array_search('00002', $tags))}}</h1>
			</div>
		</div>
		
		<div class='idioma col-xs-12 col-sm-12 col-md-12'>

			{{Form::open(array('method' => 'POST', 'url' => '/autoservicio/idioma'))}}
				<input type="hidden" name="idioma" value='Es'>
				<button type="submit" class="btnfrank btnespanol btn btn-default" >ESPAÑOL</button>
			{{Form::close()}}

			{{Form::open(array('method' => 'POST', 'url' => '/autoservicio/idioma'))}}
				<input type="hidden" name="idioma" value='En'>
				<button type="submit" class="btnfrank btningles btn btn-default" >INGLES</button>
			{{Form::close()}}

		</div>
	</div>	
</div>

@stop

