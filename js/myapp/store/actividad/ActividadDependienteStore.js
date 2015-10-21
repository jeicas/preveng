Ext.define('myapp.store.actividad.ActividadDependienteStore', {
    extend: 'Ext.data.Store',
    model: 'myapp.model.store.actividad.ActividadListaModel',
    proxy: { 
        type:'ajax',
        url: BASE_URL + 'actividad/actividad/obtenerActividadDependiente',
        reader: {
            type:'json', 
            root: 'data'
        }
    },
    //autoLoad: true
});