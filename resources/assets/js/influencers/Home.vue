<template>
	<div id="home">
		<div class="row">
			<div class="col s12 center-align"><h4 class="title">¿QUIERES SER UNO DE NUESTROS INFLUENCERS?</h4></div>
			<div class="col s12 m6 center-align">				
				<div class="video-container" @click="togglePlay">
					<div class="video" id="video"></div>
				</div>	
				<a style="font-size: 1.5em; cursor: pointer;" @click="togglePlay" class="girar">PLAY / PAUSE</a>		
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
							<input name="fecha_nacimiento" type="date" class="validate" v-model="form.fecha_nacimiento" placeholder="dd/mm/yyyy">
							<label for="fecha_nacimiento" class="active">Fecha nacimiento *</label>
						</div>
						<material-select class="col s6" name="ciudad" :list="{'Quito':'Quito','Guayaquil':'Guayaquil','Cuenca':'Cuenca','Ibarra':'Ibarra','Machala':'Machala','Ambato':'Ambato','Manta':'Manta'}" :value.sync="form.ciudad" :label="'Ciudad *'" :errors="''" :first-item="'...'"></material-select>
						<div class="input-field col s12 m4">
							<input name="video" type="text" class="validate" v-model="form.video">
							<label for="video">Link video de youtube *</label>
						</div>
						<div class="input-field col s12 m4">
							<input name="facebook" type="text" class="validate" v-model="form.redes.facebook">
							<label for="facebook">Tu perfil de facebook</label>
						</div>		
						<div class="input-field col s12 m4">
							<input name="instagram" type="text" class="validate" v-model="form.redes.instagram">
							<label for="instagram">Tu perfil de instagram</label>
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

	import material_select from '../components/generics/MaterialSelect.vue';
	import Vue from 'vue';

	Vue.component('material-select', material_select);

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
					redes: {
						facebook: '',
						instagram: ''
					}
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
						let url = '/api/contactos';
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
				console.log(this.form);
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
			initFields: function(){				
				$('.datepicker').pickadate({
					selectMonths: true, 
					selectYears: 15, 
					today: 'Today',
					clear: 'Clear',
					close: 'Ok',
					closeOnSelect: false 
				});
				$('select').material_select();
			}		
		},
		mounted: function(){					
			this.initFields();
		},
		updated: function(){					
			this.initFields();
		}
	}

</script>