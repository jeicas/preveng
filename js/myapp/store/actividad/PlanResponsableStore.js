Ext.define('myapp.store.actividad.PlanResponsableStore', {
    extend: 'Ext.data.Store',
    model: 'myapp.model.store.actividad.ListaEmpleadoPlanModel',
    proxy: { 
        type:'ajax', 
        url: BASE_URL + 'actividad/actividad/obtenerResponsablePlandeAccion',
        reader: {
            type:'json', 
            root: 'data'
        }
    },
    //autoLoad: true
});