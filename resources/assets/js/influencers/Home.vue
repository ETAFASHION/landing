<template>
	<div id="home">
		<div class="row">
			<div class="col s12 center-align"><h4 class="title">¿QUIERES SER UNO DE NUESTROS INFLUENCERS?</h4></div>
			<div class="col s12 m6 center-align">				
				<div class="video-container" @click="togglePlay">					
					<!--<div class="video" id="video"></div>-->
					<iframe class="video" id="video" src="https://www.youtube.com/embed/yTZJqlH_VL0?rel=0&controls=0&showinfo=0&autoplay=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
				</div>					
				<!--<a style="font-size: 1.5em; cursor: pointer;" @click="togglePlay" class="girar hide-on-med-and-down">PLAY / PAUSE</a>-->	

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
							<input name="edad" type="number" class="validate" min="18" step="1" v-model="form.edad">
							<label for="edad">Edad *</label>
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
		<div class="row" style="padding-top: 20px;">
			<div class="col s12 center-align"><h4 class="title">Inscripciones hasta el 26 de febrero</h4></div>
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
					edad: '',
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
					}
				}else{
					Materialize.toast('Debes aceptar los terminos y condiciones para poder registrarte', 6000);
				}
				
			},
			validate: function(){
				let requeridos = false;
				let mensaje_requeridos = 'Los siguientes campos son requeridos: ';
				let erroneos = false;
				let mensaje_erroneos = 'Los siguientes campos no son validos: ';
				if(this.form.nombres == ''){
					requeridos = true;
					mensaje_requeridos += ' nombres,'
				}
				if(this.form.apellidos == ''){
					requeridos = true;
					mensaje_requeridos += ' apellidos,'
				}
				if(this.form.email == ''){
					requeridos = true;
					mensaje_requeridos += ' email,'
				}
				if(this.form.movil == ''){
					requeridos = true;
					mensaje_requeridos += ' movil,'
				}
				if(this.form.edad == '' || this.form.edad<18){					
					if(this.form.edad==''){
						requeridos = true;
						mensaje_requeridos += ' edad,'
					}else{
						erroneos = true;
						mensaje_erroneos += ' edad minimo 18 años,'
					}
				}
				if(this.form.ciudad == ''){
					requeridos = true;
					mensaje_requeridos += ' ciudad,'
				}
				if(this.form.video == ''){
					requeridos = true;
					mensaje_requeridos += ' link video,'
				}
				if(!requeridos && !erroneos){
					return true;
				}else{
					if(requeridos){
						Materialize.toast(mensaje_requeridos, 6000);
					}
					if(erroneos){
						Materialize.toast(mensaje_erroneos, 6000);
					}
					return false;
				}
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