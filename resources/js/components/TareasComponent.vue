
<template>
    <div>
        
        <form @submit.prevent="editarNota(nota)" v-if="edit">
            <h1>Editar Tareas</h1>
        <div class="form-group">
            <label>Firs Name</label>
            <input v-model="nota.first_name" type="text" class="form-control" placeholder="First Name">
        </div>
        <div>
            <label >Last Name</label>
            <input v-model="nota.last_name" type="text" class="form-control"  placeholder="Last Name">
        </div>
         <div>
            <label >Phone</label>
            <input v-model="nota.phone" type="text" class="form-control"  placeholder="Phone">
        </div>
         <div>
            <label >Email</label>
            <input v-model="nota.email" type="email" class="form-control"  placeholder="Email">
        </div>
        <div>
            <label >City</label>
            <input v-model="nota.city" type="text" class="form-control"  placeholder="City">
        </div>
        <div class="form-check my-2">
            <input type="checkbox" class="form-check-input" >
            <label class="form-check-label" >Check me out</label>
        </div>
        
        <button type="submit" class="btn btn-outline-warning  btn-lg btn-block my-3">Guardar</button>
        </form>

        <!-- edit ture of false -->
             <form @submit.prevent="agregar" v-else>
                  <h1>Agregar Tareas</h1>
             <div class="form-group">
            <label>Firs Name</label>
            <input v-model="nota.first_name" type="text" class="form-control" placeholder="First Name">
        </div>
        <div>
            <label >Last Name</label>
            <input v-model="nota.last_name" type="text" class="form-control"  placeholder="Last Name">
        </div>
         <div>
            <label >Phone</label>
            <input v-model="nota.phone" type="text" class="form-control"  placeholder="Phone">
        </div>
         <div>
            <label >Email</label>
            <input v-model="nota.email" type="email" class="form-control"  placeholder="Email">
        </div>
        <div>
            <label >City</label>
            <input v-model="nota.city" type="text" class="form-control"  placeholder="City">
        </div>
        <div class="form-check my-2">
            <input type="checkbox" class="form-check-input" >
            <label class="form-check-label" >Check me out</label>
        </div>
        
        <button type="submit" class="btn btn-outline-secondary  btn-lg btn-block my-3">Agregar</button>
        </form>



        <hr class="mt-3">
        <h3>Listadodenotas </h3>
        <div class="backgr">
        <ul class="list-group my-1 backgr" >
            <li class="list-group-item mt-4 " v-for="(item, index) in notas" :key="index">
                <h4>{{item.first_name}}</h4>
                <h4>{{item.last_name}}</h4>
                <h4>{{item.phone}}</h4>
                <h4>{{item.email}}</h4>
                <h4>{{item.city}}</h4>
               
           <button @click="deletenota(item, index)" class="btn btn-danger btn-sm ">Delete</button>
           <button @click="editarFormulario(item)" class="btn btn-warning btn-sm">Edit</button>
            </li>
            
        </ul>
        </div>
    </div>
</template>

<script>
export default {
    data(){
       return {
           notas: [],
           nota: {first_name: '', last_name: '', phone: '', email: '', city: ''},
           edit: false
       }
    },
    created(){
        axios.get('http://laravel-api-2.com/api/person')
        .then(res => {
            this.notas =res.data;
        })
        
    },
    methods:{
        editarFormulario(item){
            this.edit = true;
            this.nota.first_name = item.first_name;
            this.nota.last_name = item.last_name;
            this.nota.phone = item.phone;
            this.nota.email = item.email;
            this.nota.city = item.city;
            this.nota.id = item.id;
        },
        editarNota(nota){
           const params = {
               title: nota.title,
               body: nota.body,
               author: nota.author
            };
             this.nota.first_name = '';
            this.nota.last_name ='';
             this.nota.phone ='';
             this.nota.email ='';
             this.nota.city ='';

            axios.put(`http://laravel-api-2.com/api/person/${nota.id}`,params)
                .then(res => {
                    alert('it has been Updated')
                    const index = this.notas.findIndex(
                          item => item.id === nota.id);
                        
                         this.notas[index] = res.data;

                          axios.get('http://laravel-api-2.com/api/person')
                        .then(res => {
                            this.notas = res.data;
                        })
                })
        },
        agregar(){
            if(this.nota.first_name.trim() === '' || this.nota.last_name.trim() === '' ||
            this.nota.phone.trim() === '' || this.nota.email.trim() === ''|| this.nota.city.trim() === ''){
                alert('Debes completar todos los campos antes de gurdar');
                return ;
            }
            console.log(this.nota.first_name,this.nota.last_name, this.nota.phone, this.nota.email,
            this.nota.city);
            
            const params = {
               first_name: this.nota.first_name,
               last_name: this.nota.last_name,
               phone: this.nota.phone,
               email: this.nota.email,
               city: this.nota.city,
            }

            this.nota.first_name ='';
            this.nota.last_name = '';
            this.nota.phone = '';
            this.nota.email = '';
            this.nota.city = '';
           
           axios.post('http://laravel-api-2.com/api/person', params)
            .then(res => {
                alert('Nota Added')
                this.notas.push(res.data);
            })
        },
        deletenota(item, index) {
            axios.delete(`http://laravel-api-2.com/api/person/${item.id}`)
            .then(() => {
                alert('Nota has been Removed');
                this.notas.splice(index,1);
            })
        }
        
    }
    
}
</script>
<style >
.backgr{
    background-color:  none;
}
</style>



