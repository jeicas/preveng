Ext.define('myapp.model.store.actividad.ListaEmpleadoPlanModel', { 
   extend: 'Ext.data.Model',
    idProperty: 'id',
    fields: [
         { name: 'foto'}, 
        { name: 'nombrecompleto'}, 
        { name: 'fecha'},
        { name: 'idEmpleado'},
        { name: 'idUsuario'},
       
    ] 
});