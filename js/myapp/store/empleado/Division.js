Ext.define('myapp.store.empleado.Division', {
    extend: 'Ext.data.Store',
    model: 'myapp.model.store.Generico',
    proxy: { 
        type:'ajax', 
        url: BASE_URL + 'registrar/division/buscarDivision',
        reader: {
            type:'json', 
            root: 'data'
        }
    },
    //autoLoad: true
});