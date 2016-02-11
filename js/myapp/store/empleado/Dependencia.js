Ext.define('myapp.store.empleado.Dependencia', {
    extend: 'Ext.data.Store',
    model: 'myapp.model.store.Generico',
    proxy: { 
        type:'ajax', 
        url: BASE_URL + 'registrar/dependencia/buscarDependencia',
        reader: {
            type:'json', 
            root: 'data'
        }
    },
 autoLoad: true
});