Ext.define('myapp.model.store.actividad.ActividadListaModel', { 
   extend: 'Ext.data.Model',
    idProperty: 'id',
    fields: [
        { name: 'id'},
        { name: 'descripcion'},
        { name: 'fecha'},
        { name: 'fechaPA'},
        { name: 'depende'},
        { name: 'iddepende'},
        { name: 'evento'},
        { name: 'meta'},
        { name: 'medida'},
        { name: 'observacion'},
        { name: 'estatus'},
        { name: 'idUsuario'},
        { name: 'nombrecompleto'},
        { name: 'cedula'},
        { name: 'correo'},
        { name: 'foto'},
         { name: 'idencargado'},
    ] 
});