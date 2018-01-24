<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Influencers</title>
	<link href="https://fonts.googleapis.com/css?family=Amatic+SC" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{mix('css/influencers.css')}}">
	<script src="https://www.youtube.com/iframe_api"></script>
	<script type="text/javascript">
		window.Laravel = {!! json_encode(['csrfToken' => csrf_token(),]) !!};
	</script>
</head>
<body>
	<div id="influencers" class="container-fluid">
		<img class="responsive-img up" src="{{asset('images/influencers/up.png')}}">
		<img class="responsive-img down" src="{{asset('images/influencers/down.png')}}">
		<div class="row logo_menu">
			<div class="col s12 m6">
				<img class="responsive-img logo" src="{{asset('images/influencers/LOGO.png')}}">
			</div>
			<div class="col s12 m6 content-menu">
				<img class="responsive-img menu" src="{{asset('images/influencers/fondo_menu.png')}}">
				<div class="menu-items">
					<div class="col s6 right-align girar">
						<router-link :to="{name: 'home'}">HOME</router-link>
					</div>
					<div class="col s6 left-align girar">
						<router-link :to="{name: 'condiciones'}">CONDICIONES</router-link>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<transition name="fade">				
				<router-view></router-view>
			</transition>
		</div>
		<div class="fixed-action-btn">
			<a class="btn-floating btn-large red lighten-1">
				<i class="large material-icons">people</i>
			</a>
			<ul>
				<li><a class="btn-floating blue lighten-5"><i class="fa fa-facebook-official" aria-hidden="true"></i></a></li>
				<li><a class="btn-floating blue lighten-5"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
				<li><a class="btn-floating blue lighten-5"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
			</ul>
		</div>
	</div>	
	<script src="{{mix('js/influencers.js')}}"></script>
</body>
</html>