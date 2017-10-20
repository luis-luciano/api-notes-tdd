<template>
    <div>
        <transition name='fade'>
            <div class="alert_container">
                <p  v-show="alert.display"
                    class="alert alert-danger"
                >{{ alert.message }}</p>
            </div>
        </transition>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Categoria</th>
                    <th>Nota</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>

            <transition-group tag='tbody' leave-active-class='bounceOut'>
                <tr v-for="note in notes"
                    :key="note.id"
                    is="note-row"
                    v-bind:note="note"
                    v-bind:categories="categories"
                    v-on:update-note="updateNote"
                    v-on:delete-note="deleteNote">
                </tr>
            </transition-group>

            <tfoot>
                <tr>
                    <td>
                        <select-category v-bind:note='new_note' v-bind:categories='categories'></select-category>
                    </td>
                    <td>
                        <input type="text" v-model="new_note.note" class="form-control">
                        
                        <ul v-if="errors.length" class="text-danger">
                            <li v-for="error in errors">{{ error }}</li>
                        </ul>
                    </td>
                    <td>
                        <a title="Aceptar" v-on:click.prevent="createNote"><i class="fa fa-check"></i></a>
                    </td>
                </tr>
            </tfoot>
        </table>
        <pre>{{ $data }}</pre>
    </div>
</template>

<script>
    var resource = null;
    
    export default {
    data: function() {
        return {
            errors: [],
            alert: {
                message: '',
                display: false
            },
            new_note: {
                note: '',
                category_id: ''
            }, 
            notes: [],
            categories: [
                {
                    id: 1,
                    name: "Laravel"
                },
                {
                    id: 2,
                    name: "Vue"
                },
                {
                    id: 3,
                    name: "Php"
                },
            ]
        }
    },
    methods: {
        createNote: function(){
            this.errors = [];

            // Ajax con Vue - resource
            resource.save({},this.new_note).then(function(response){
                this.notes.push(response.data.note);
            },function(response){
                this.errors = response.data.errors;
            });

            this.new_note= {note: '', category_id: ''};
            
            // ajax con Jquery
            /*$.ajax({
                url: '/api/notes',
                method: 'POST',
                data: this.new_note,
                dataType: 'json',
                success: function(data) {
                    vm.notes.push(data.note);
                },
                error: function(jqXHR){
                    vm.errors = jqXHR.responseJSON.errors;
                }
            });*/

        },
        updateNote: function(component){
            resource.update({id: component.note.id}, component.draft).then(function(response){
                //this.$parent.notes.$set(this.$parent.notes.indexOf(this.note),response.data.note);
                
                for(var key in response.data.note){
                   component.note[key] = response.data.note[key];
                }

                component.editing= false;
            },function(response){
                component.errors = response.data.errors;
            });
        },
        deleteNote: function(note){
            resource.delete({id: note.id}).then(function(response){
                
                var index = this.notes.indexOf(note); 
                this.notes.splice(index, 1);
            }.bind(this));
        }
    },
    mounted: function(){
        resource = this.$resource('/api/notes{/id}');

        resource.get().then(response => {
            // success callback
            this.notes = response.data;
        });

        Vue.http.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');

        Vue.http.interceptors.push(function(request, next) {
          // continue to next interceptor
            next(function(response) {
                /*var token = document.getElementById('token').getAttribute('content');
                request.headers['X-CSRF-TOKEN'] = token;*/

                if(response.ok){
                  return response;
                }

               this.alert.message = response.data.message;
               this.alert.display = true;

               setTimeout(function(){
                    this.alert.display = false;
               }.bind(this),4000);
            }.bind(this));
        }.bind(this)); 
    }
}
</script>
