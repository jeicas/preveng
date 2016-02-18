Ext.define('myapp.store.evento.EstatusStore', {
    extend: 'Ext.data.Store',
    fields: ['id', 'nombre'],
    data: [
        {id: '0', nombre: 'COMPLETADO'},
        {id: '1', nombre: 'PENDIENTE'},
        {id: '2', nombre: 'EN EJECUCION'},
        {id: '3', nombre: 'CANCELADO'},
        {id: '4', nombre: 'SIN PLAN'},
        {id: '5', nombre: 'EXPIRADO'},
    ]
});