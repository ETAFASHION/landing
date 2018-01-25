<template>
	<div id="home">
		<div class="row">
			<div class="col s12 center-align"><h4 class="title">¿QUIERES SER UNO DE NUESTROS INFLUENCERS?</h4></div>
			<div class="col s12 m6 center-align">				
				<div class="video-container" @click="togglePlay">
					<div class="video" id="video"></div>
					<!--<iframe class="video" id="video" src="https://www.youtube.com/embed/yTZJqlH_VL0?rel=0&enablejsapi=1&html5=1&autoplay=1&controls=0&showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>-->
				</div>	
				<a v-if="play" style="font-size: 1.5em; cursor: pointer;" @click="togglePlay" class="girar">PAUSE</a>		
				<a v-else style="font-size: 1.5em; cursor: pointer;" @click="togglePlay" class="girar">PLAY</a>	
			</div>
			<div class="col s12 m6">
				<form class="col s12 formulario">
					<div class="row">
						<div class="input-field col s6">
							<input name="nombres" type="text" class="validate" v-model="form.nombres">
							<label for="nombres">Nombres *</label>
						</div>
						<div class="input-field col s6">
							<input name="apellidos" type="text" class="validate" v-model="form.apellidos">
							<label for="apellidos">Apellidos *</label>
						</div>
						<div class="input-field col s6">
							<input name="email" type="email" class="validate" v-model="form.email">
							<label for="email">Email *</label>
						</div>
						<div class="input-field col s6">
							<input name="movil" type="text" class="validate" v-model="form.movil">
							<label for="movil">Telefono movil *</label>
						</div>
						<div class="input-field col s6">
							<input name="fecha_nacimiento" type="date" class="validate" v-model="form.fecha_nacimiento">
							<label for="fecha_nacimiento" class="active">Fecha nacimiento *</label>
						</div>
						<div class="input-field col s6">
							<select name="ciudad" class="validate" v-model="form.ciudad">
								<option value="" disabled selected>...</option>
								<option value="Quito">Quito</option>
								<option value="Guayaquil">Guayaquil</option>
								<option value="Cuenca">Cuenca</option>
								<option value="Ibarra">Ibarra</option>
								<option value="Machala">Machala</option>
								<option value="Ambato">Ambato</option>
								<option value="Manta">Manta</option>
							</select>
							<label for="ciudad">Ciudad *</label>
						</div>
						<div class="input-field col s6">
							<input name="video" type="url" class="validate" v-model="form.video">
							<label for="video">Copia y pega link video de youtube *</label>
						</div>
						<div class="input-field col s6">
							<div class="chips chips-placeholder"></div>
							<label class="active">Tus perfiles sociales</label>
						</div>												
					</div>
					<div class="row">
						<div class="terminos col s12">
							<input type="checkbox" id="acepta" v-model="acepta"/>
							<label for="acepta">Acepto términos y condiciones</label>
						</div>
						<div class="col s12">
							<div class="enviar-content">
								<img class="fondo-enviar" src="/images/influencers/fondo_enviar.png">
								<a class="link-enviar girar" @click="enviar">ENVIAR</a>
							</div>
						</div>
					</div>
				</form>				
			</div>
		</div>
	</div>
</template>

<style>
	
</style>

<style scope>
	
</style>

<script>	

	export default {
		data: function(){
			return {
				player: null,
				play: true,
				acepta: false,
				form: {
					nombres: '',
					apellidos: '',
					email: '',
					movil: '',
					fecha_nacimiento: '',
					ciudad: '',
					video: '',
					redes: null
				}
			}
		},
		methods: {
			playVideo: function(){
				player.playVideo();
				this.play = true;
			},
			pauseVideo: function(){
				player.pauseVideo();
				this.play = false;
			},
			togglePlay: function(){
				if(this.play){
					this.pauseVideo();
				}else{
					this.playVideo();
				}
			},
			enviar: function(){
				if(this.acepta){
					if(this.validate()){					
						let chips = $('.chips-placeholder').material_chip('data');
						this.form.redes = chips;
						let url = '/api/contactos';
						console.log(JSON.stringify(this.form));
						axios.post(url,this.form)
						.then((response) => {			
							console.log(response);
							Materialize.toast('Información registrada exitosamente', 6000);					
						})
						.catch((error) => {
							/*Hubo un error*/
							if(error.response.status == 422){
								Materialize.toast('Uno o más datos son invalidos, por favor verifique la información ingresada', 6000);
							}else{
								Materialize.toast('Hubo un error al intentar guardar la información', 6000);	
							}
						});
					}else{
						Materialize.toast('Por favor llenar todos los campos requeridos', 6000);
					}
				}else{
					Materialize.toast('Debes aceptar los terminos y condiciones para poder registrarte', 6000);
				}
				
			},
			validate: function(){
				if(this.form.nombres == ''){
					return false;
				}
				if(this.form.apellidos == ''){
					return false;
				}
				if(this.form.email == ''){
					return false;
				}
				if(this.form.movil == ''){
					return false;
				}
				if(this.form.fecha_nacimiento == ''){
					return false;
				}
				if(this.form.ciudad == ''){
					return false;
				}
				if(this.form.video == ''){
					return false;
				}
				return true;
			},			
		},
		created: function(){
			var tag = document.createElement('script');
			tag.src = "https://www.youtube.com/iframe_api";
			var firstScriptTag = document.getElementsByTagName('script')[0];
			firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
		},
		mounted: function(){					
			$('.datepicker').pickadate({
				selectMonths: true, 
				selectYears: 15, 
				today: 'Today',
				clear: 'Clear',
				close: 'Ok',
				closeOnSelect: false 
			});
			$('.chips-placeholder').material_chip({
				placeholder: 'Perfil de Facebook',
				secondaryPlaceholder: 'Perfil de Instagram',
			});
			$('select').material_select();
		}
	}

</script>