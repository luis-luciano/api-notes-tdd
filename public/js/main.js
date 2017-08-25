var resource = null;

Vue.filter('category', function(id){
    var category= _.find(this.categories,["id",id]);
    return category != null ? category.name : "";
});

Vue.component('select-category',{
    props: ['categories','id'],
    template: '#select_category_tp',
});

Vue.component('note-row',{
    props: ['note','categories'],
    data: function(){
        return {
            editing: false,
            errors: [],
            draft: {}
        };
    },
    template: '#note_row_tp',
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

            resource.update({id: this.note.id}, this.draft).then(function(response){
                this.$parent.notes.$set(this.$parent.notes.indexOf(this.note),response.data.note);
                this.editing= false;
            }.bind(this),function(response){
                this.errors = response.data.errors;
            }.bind(this));

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
            resource.delete({id: this.note.id}).then(function(response){
                this.$parent.notes.$remove(this.note);
            }.bind(this),function(response){
                this.errors = response.data.errors;
            }.bind(this));

            /*$.ajax({
                url: '/api/notes/'+this.note.id,
                method: 'DELETE',
                dataType: 'json',
                success: function(data){
                    this.$parent.notes.$remove(this.note);
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
});

const vm= new Vue({
    el: "#app",
    data: {
        errors: [],
        error: '',
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

        }
    },
    ready: function(){
        resource = this.$resource('/api/notes{/id}');

        resource.get().then(response => {
            // success callback
            this.notes = response.data;
        });


        Vue.http.interceptors.push(function(request, next) {
          // continue to next interceptor
            next(function(response) {
            
                if(response.ok){
                  return response;
                }

                $('#error_message').show();

               this.error = response.data.message;
               $('#error_message').delay(3000).fadeOut(1000, function(){
                    this.error = '';
                });
            }.bind(this));
        }.bind(this));
    }
});