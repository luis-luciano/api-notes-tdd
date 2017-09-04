<template>
    <tr class="animated">
        <template v-if="!editing">
            <td>{{ category_name }}</td>
            <td>{{ note.note }}</td>
            <td>
                <a title="Editar" v-on:click.prevent="edit"><i class="fa fa-pencil"></i></a>
                <a title="Eliminar" v-on:click.prevent="destroy">
                    <i class="fa fa-trash"></i>
                </a>
            </td>
        </template>
        <template v-else>
            <td>
                <select-category v-bind:note='draft' v-bind:categories='categories'></select-category>
            </td>
            <td>
                <input type="text" v-model="draft.note" class="form-control" v-on:keydown.enter="update" v-on:keydown.esc="cancel">
                <ul v-if="errors.length" class="text-danger">
                    <li v-for="error in errors">{{ error }}</li>
                </ul>
            </td>
            <td>
                <a title="Confirmar" v-on:click.prevent="update"><i class="fa fa-check"></i></a>
                <a title="Cancelar Edición" v-on:click.prevent="cancel"><i class="fa fa-times"></i></a>
            </td>
        </template>
    </tr>
</template>

<script>
    export default {
        props: ['note','categories'],
        data: function(){
            return {
                editing: false,
                errors: [],
                draft: {}
            };
        },
        //template: '#note_row_tp',
        computed: {
            category_name: function(){
                var category= _.find(this.categories,["id",this.note.category_id]);
                return category != null ? category.name : "";
            }
        },
        methods: {
            edit: function(){
                this.errors = [];
                this.draft = JSON.parse(JSON.stringify(this.note)); //Clonando un objeto
                this.editing= true;
            },
            cancel:  function (){
                this.editing = false;
            },
            update: function(){
                this.errors = [];

                this.$emit('update-note',this);

                /*$.ajax({
                    url: '/api/notes/'+this.note.id,
                    method: 'PUT',
                    dataType: 'json',
                    data: this.draft,
                    success: function (data){
                        this.$parent.notes.$set(this.$parent.notes.indexOf(this.note),data.note);
                        this.editing= false;
                    }.bind(this),
                    error: function(jqXHR){
                        this.errors = jqXHR.responseJSON.errors;
                    }.bind(this)
                });*/
            },
            destroy: function(){
                // Para evitar el uso de malas practicas, no es recomendable utilizar $parent, $children por lo cual se agrega un despachador
                this.$emit('delete-note',this.note);
                //  Codigo comentado por malas practicas
               /* resource.delete({id: this.note.id}).then(function(response){
                    
                }.bind(this),function(response){
                    this.errors = response.data.errors;
                }.bind(this));*/

                // Acciones realizadas con jquery
                /*$.ajax({
                    url: '/api/notes/'+this.note.id,
                    method: 'DELETE',
                    dataType: 'json',
                    success: function(data){
                        
                    }.bind(this),
                    error: function(jqXHR){
                        this.$parent.error = jqXHR.responseJSON.message;

                        $('#error_message').delay(3000).fadeOut(1000, function(){
                            this.$parent.error = '';
                        }.bind(this));
                    }.bind(this)
                });*/

            }
        }
    }
</script>