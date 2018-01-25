<template>
	<div v-if="!readonly" class="input-field material-select">
		<select v-if="!multiple" :name="name" :id="id?id:name" v-model="data" :class="['validate',{invalid:errors_string},classSelect]">
			<option value="" disabled v-if="firstItem">{{firstItem}}</option>
			<option v-for="(label, key) in list" :value="key" :selected="key==value">{{label}}</option>
		</select>
		<select v-if="multiple" :name="name" :id="id?id:name" :multiple="multiple" :class="['validate',{invalid:errors_string},classSelect]">
			<option value="" disabled v-if="firstItem">{{firstItem}}</option>
			<option v-for="(label, key) in list" :value="key" :selected="isSelected(key)">{{label}}</option>
		</select>
		<label :for="name" :data-error="errors_string">{{label}}</label>
	</div>
	<div v-else class="input-field">
		<input v-model="labelsItemsSelected" type="text" :name="name" :id="id?id:name" readonly/>
		<label :for="name" :class="{active:labelsItemsSelected}">{{label}}</label>
	</div>
</template>

<script>

	export default {
		props: {
			'id':{type: String,required: false},
			'name':{type: String,required: true},
			'multiple':{type: Boolean,default: false},
			'value':{type: [Array,String],default: ''},
			'list':{type: [Array,Object],default: []},
			'firstItem':{type: String,default: ''},
			'label':{type: String,default: ''},
			'classSelect':{type: String,default: ''},
			'errors':{type: [Array,String],default: ''},
			'readonly':{type:Boolean,default:false}
		},
		data: function() {
			return {
				data: this.value
			}
		},
		computed: {
			errors_string: function(){
				let errors_string = '';				
				if(this.errors.length){
					let count_errors = this.errors.length;
					this.errors.forEach((elem,index)=>{
						errors_string += elem;
						if(count_errors-1!=index){
							errors_string +=', ';
						}
					});
				}
				return errors_string;
			},
			labelsItemsSelected: function(){
				let data = '';
				if(typeof this.data == 'object'){
					let count_data_items = this.data.length;
					this.data.forEach((itemData,index)=>{
						data += this.list[itemData];
						if(count_data_items-1!=index){
							data +=', ';
						}
					});
				}else{
					data =  this.data!='' ? this.list[this.data] : '';
				}
				return data;
			}
		},
		watch: {
			data: function(val){
				this.$emit('update:value', val);
			},
			errors_string: function(val){
				if(val==''){
					$('.material-select .select-wrapper').removeClass('invalid');
				}else{
					$('.material-select .select-wrapper').addClass('invalid');
				}
			},
			readonly: function(val){
				if(val){
					$('select[name='+this.name+']').material_select('destroy');
				}
			}
		},
		methods:{
			/*Establece los valores resultantes de los selects al cambiar con materialize*/
			selectChange: function(elem){				
				let select = $('select[name='+elem+']');
				if(typeof select.attr('multiple') == 'undefined'){
					Vue.set(this,'data',select.val());
				}else{
					let newValuesArr = [],
					ul = select.prev();
					ul.children('li').toArray().forEach((li, i) => {
						if ($(li).hasClass('active')) {
							newValuesArr.push(select.children('option').toArray()[i].value);
						}
					});
					Vue.set(this,'data',newValuesArr);
				}
			},
			isSelected: function(elem){
				if(typeof this.data == 'object'){
					return this.data.some(function(item){
						return elem==item;
					});
				}else{
					return false;
				}
			},
			labelsItemsSelected2: function(){
				let data = '';
				if(typeof this.data == 'object'){
					labels_filter = this.list.filter((itemList)=>{
						console.log(itemList);
					});
				}else{
					data =  this.data!='' ? this.list[this.data] : '';
				}
				return data;
			}
		},
		mounted: function(){
			$('select[name='+this.name+']').material_select();
			$('select[name='+this.name+']').on('change',(e) => {
				this.selectChange(this.name);								
			});
		},
		updated: function(){
			$('select[name='+this.name+']').material_select();
			$('select[name='+this.name+']').on('change',(e) => {
				this.selectChange(this.name);								
			});
		}
	}
</script>