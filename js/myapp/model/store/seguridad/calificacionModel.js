Ext.define('myapp.model.store.seguridad.calificacionModel', {
    extend: 'Ext.data.Model',
    fields: [
        {name: 'id',             type: 'string'},
    	{name: 'desde',          type: 'int'},
        {name: 'hasta',          type: 'int'},  
        {name: 'descripcion',    type: 'string'},  
    ]
});