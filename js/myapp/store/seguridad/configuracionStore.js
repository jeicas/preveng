
Ext.define('myapp.store.seguridad.configuracionStore', {
    extend: 'Ext.data.Store',
    requires: ['myapp.model.store.seguridad.calificacionModel' ],
    model: 'myapp.model.store.seguridad.calificacionModel', // #2
    proxy: { 
        type:'ajax', 
        url: BASE_URL + 'seguridad/calificacion/buscarcalificacion',
        reader: { 
            type: 'json', 
            root: 'data'   
        }  
    },
    autoLoad: true

});