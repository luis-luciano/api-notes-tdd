@extends('layout')

@section('content')
<!-- Start your project here-->
    <div id="app" class="container">
        <div class="col-md-8 col-md-offset-2">
            <p class="alert alert-danger" v-show="error" id="error_message" transition="fade">@{{ error }}</p>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Categoria</th>
                        <th>Nota</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="note in notes" is="note-row" v-bind:note.sync="note" v-bind:categories="categories"></tr>
                    <tr>
                        <td>
                            <select-category v-bind:id.sync='new_note.category_id' v-bind:categories='categories'></select-category>
                        </td>
                        <td>
                            <input type="text" v-model="new_note.note" class="form-control">
                            {{-- Display errors --}}
                            <ul v-if="errors.length" class="text-danger">
                                <li v-for="error in errors">@{{ error }}</li>
                            </ul>
                        </td>
                        <td>
                            <a title="Aceptar" v-on:click.prevent="createNote"><i class="fa fa-check"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <pre>@{{ $data | json }}</pre>
        </div>
    </div>
@endsection

@section('scripts')
    @verbatim
        <!-- /Start your project here-->
        <script  type="text/template" id="select_category_tp">
            <select v-model="id" class="browser-default">
                <option value="" disabled>Elija una opcion</option>
                <option v-for="category in categories" v-bind:value="category.id">{{ category.name }}</option>
            </select>
        </script>

        <script type="text/template" id="note_row_tp">
            <tr>
                <template v-if="!editing">
                    <td>{{ note.category_id | category }}</td>
                    <td>{{ note.note }}</td>
                    <td>
                        <a title="Editar" v-on:click.prevent="edit"><i class="fa fa-pencil"></i></a>
                        <a title="Eliminar" v-on:click.prevent="destroy" v-show='note.category_id != 1'>
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </template>
                <template v-else>
                    <td>
                        <select-category v-bind:id.sync='draft.category_id' v-bind:categories='categories'></select-category>
                    </td>
                    <td>
                        <input type="text" v-model="draft.note" class="form-control">
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

        </script>
    @endverbatim
    <!-- SCRIPTS -->
   <!-- JQuery -->
    <script type="text/javascript" src="{{ asset('MDB_Free/js/jquery.min.js') }}"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="{{ asset('MDB_Free/js/bootstrap.min.js') }}"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="{{ asset('MDB_Free/js/mdb.min.js') }}"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="{{ asset('MDB_Free/js/tether.min.js') }}"></script>
    <script src="{{ asset('js/lodash.js') }}"></script>
    <script src="{{ asset('js/vue.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.3.4/vue-resource.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
@endsection