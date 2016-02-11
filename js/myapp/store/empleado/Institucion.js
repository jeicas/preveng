Ext.define('myapp.store.empleado.Institucion', {
    extend: 'Ext.data.Store',
    model: 'myapp.model.store.Generico',
    proxy: { 
        type:'ajax', 
        url: BASE_URL + 'registrar/institucion/buscarInstitucion',
        reader: {
            type:'json', 
            root: 'data'
        }
    },
    autoLoad: true
});