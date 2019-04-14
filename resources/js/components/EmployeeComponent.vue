<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card border-primary ">
                  <div class="card-header">
                      <i class="fa fa-align-justify"></i> Empleados
                      <button type="button"  class="btn btn-primary text-right"  @click="abrirModal('empleado','registrar')">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                  </div>
                  <div class="card-body text-dark">
                    
                    <div class="form-group row">
                            <div class="form-group row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <select class="form-control col-md-4" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="apellido">Apellido</option>
                                      <option value="documento">Documento</option>
                                      <option value="email">Email</option>
                                      <option value="telefono">Teléfono</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarEmpleado(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarEmpleado(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        </div>
                  </div>
                  <div class="container">
                      <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Tipo Documento</th>
                                    <th>Documento</th>
                                    <th>Nombre</th>
                                    <th>Apellidos</th>
                                    <th>Dirección</th>
                                    <th>Telefono</th>
                                    <th>Email</th>
                                    <th>Estado</th>
                                    <th>Modificar</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="empleado in arrayEmpleado" :key="empleado.id">
                                    
                                    <td v-text="empleado.tipo_documento"></td>
                                    <td v-text="empleado.documento"></td>
                                    <td v-text="empleado.nombre"></td>
                                    <td v-text="empleado.apellido"></td>
                                    <td v-text="empleado.direccion"></td>
                                    <td v-text="empleado.telefono"></td>

                                    <td v-text="empleado.email"></td>
                                    <td v-if="empleado.estado == 1">Habilitado</td>
                                    <td v-else>Inhabilitado</td>
                                    <td>
                                        <button type="button" @click="abrirModal('empleado','actualizar',empleado)" class="btn btn-warning btn-sm">
                                          <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <button type="button" @click.prevent="eliminarEmpleado(empleado)" class="btn btn-danger btn-sm">
                                          <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>                                
                            </tbody>
                            
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>

                  </div>
                  
                </div>
            </div>
        </div>
        <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title text-center" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div v-show="errorEmpleado" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjEmpleado" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                      <label>Tipo Documento</label>
                                       <select v-model="tipo_documento" class="form-control">
                                            <option value="Cedula de Ciudadania">Cedula de Ciudadania</option>
                                            <option value="Tarjeta de Identidad">Tarjeta de Identidad</option>
                                            <option value="Cedula de Extranjeria">Cedula de Extranjeria</option>
                                        </select>  
                                    </div>
                                    <div class="form-group col-md-6">
                                      <label>Documento (*)</label>
                                      <input type="text" v-model="documento" class="form-control" placeholder="Número de documento">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                      <label >Nombre (*)</label>
                                      <input type="text" v-model="nombre" class="form-control" placeholder="Nombres">
                                    </div>
                                    <div class="form-group col-md-6">
                                      <label >Apellido (*)</label>
                                      <input type="text" v-model="apellido" class="form-control" placeholder="Apellidos">
                                    </div>
                                    
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                      <label >Direccion (*)</label>
                                      <input type="text" v-model="direccion" class="form-control" placeholder="Dirección">  
                                    </div>
                                    <div class="form-group col-md-6">
                                      <label >Teléfono</label>
                                      <input type="text" v-model="telefono" class="form-control" placeholder="Teléfono">
                                    </div>                                    
                                </div>
                                                                
                                
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                      <label >Correo Electronico</label>
                                      <input type="email" v-model="email" class="form-control" placeholder="Email">
                                    </div>                                    
                                </div>
                                
                                
                                

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarEmpleado()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarEmpleado()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->

    </div>


    </div>
</template>

<script>
    export default {
        data (){
            return {
                id: 0,
                tipo_documento : 'Cedula de Ciudadania',
                documento: '',
                nombre : '',
                apellido : '',
                direccion : '',
                telefono : '',
                email : '',
                estado : 1,
                arrayEmpleado : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorEmpleado : 0,
                errorMostrarMsjEmpleado : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'nombre',
                buscar : ''
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             

            }
        },
        methods : {
            listarEmpleado (page,buscar,criterio){
                let me=this;
                var url= '/empleados?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    console.log(response.data);
                    
                    me.arrayEmpleado = response.data.empleados.data;
                    me.pagination= response.data.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarEmpleado(page,buscar,criterio);
            },
            registrarEmpleado(){
                if (this.validarEmpleado()){
                    return;
                }
                
                let me = this;

                axios.post('/empleados/registrar',{
                    'tipo_documento': this.tipo_documento,
                    'documento' : this.documento,
                    'nombre': this.nombre,
                    'apellido': this.apellido,
                    'direccion' : this.direccion,
                    'telefono' : this.telefono,
                    'email' : this.email,
                    'estado' : this.estado,
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarEmpleado(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarEmpleado(){
               if (this.validarEmpleado()){
                    return;
                }
                
                let me = this;

                axios.put('/empleados/actualizar',{
                    'tipo_documento': this.tipo_documento,
                    'documento' : this.documento,
                    'nombre': this.nombre,
                    'apellido': this.apellido,
                    'direccion' : this.direccion,
                    'telefono' : this.telefono,
                    'email' : this.email,
                    'estado' : this.estado,
                    'id': this.id
                }).then(function (response) {
                    console.log(response);
                    me.cerrarModal();
                    me.listarEmpleado(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            }, 
            eliminarEmpleado(empleado){
               
               let url = 'empleados/eliminar/' + empleado.id;
               let me = this;
               axios.delete(url).then(response=> {
                   me.listarEmpleado(1,'','nombre');
               });

            },            
            validarEmpleado(){
                this.errorEmpleado=0;
                this.errorMostrarMsjEmpleado =[];

                if (!this.documento) this.errorMostrarMsjEmpleado.push("El documento es requerido.");
                if (!this.nombre) this.errorMostrarMsjEmpleado.push("El nombre es requerido.");
                if (!this.apellido) this.errorMostrarMsjEmpleado.push("El apellido es requerido.");
                if (!this.direccion) this.errorMostrarMsjEmpleado.push("La direccion es requerida.");
                if (!this.email) this.errorMostrarMsjEmpleado.push("El email es requerida.");

                if (this.errorMostrarMsjEmpleado.length) this.errorEmpleado = 1;

                return this.errorEmpleado;
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "empleado":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Nuevo Empleado';
                                this.tipo_documento='Cedula de Ciudadania';
                                this.documento='';
                                this.nombre= '';
                                this.apellido= '';
                                this.direccion='';
                                this.telefono='';
                                this.email='';
                                this.estado=1;
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                console.log(data);
                              
                                this.modal=1;
                                this.tituloModal='Actualizar Empleado';
                                this.tipoAccion=2;
                                this.id=data['id'];
                                this.tipo_documento = data['tipo_documento'];
                                this.documento = data['documento'];       
                                this.nombre = data['nombre'];
                                this.apellido = data['apellido'];
                                this.direccion = data['direccion'];
                                this.telefono = data['telefono'];
                                this.email = data['email'];
                                this.estado = 1;
                                break;
                            }
                        }
                    }
                }
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombre='';
                this.tipo_documento='Cedula de Ciudadania';
                this.documento='';
                this.direccion='';
                this.telefono='';
                this.email='';
                this.errorEmpleado=0;

            },
        },
        mounted() {
            this.listarEmpleado(1,this.buscar,this.criterio);
        }
    };
</script>
<style>    

    .modal-content{
        margin-top: 60px;
        width: 100% !important;
        
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        /*position: absolute !important;*/
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>