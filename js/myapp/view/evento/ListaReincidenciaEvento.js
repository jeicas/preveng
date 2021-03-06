Ext.define('myapp.view.evento.ListaReincidenciaEvento', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.listaReincidenciaEvento',
    itemId: 'listaReincidenciaEvento',
    requires: [
        'Ext.selection.CellModel',
        'Ext.selection.CheckboxModel',
        'Ext.ux.ajax.SimManager',
    ],
    
    store: Ext.create('myapp.store.reincidencia.ReincidenciaEventoStore'),
    emptyText: 'No hay Reincidencia(s) asignado(s) a este evento',
    columnLines: true,
    initComponent: function () {
        var me = this;
        me.columns = me.buildColumns();
        me.dockedItems = me.buildDockedItems();
        me.callParent();
    },
    buildColumns: function () {
        return [  {
            xtype: 'rownumberer'
        }, 
		{
                dataIndex: 'fecha',
                flex: 1.5,
                text: 'Fecha',
              
            },	 {
                dataIndex: 'descripcion',
                flex: 1.5,
                  renderer: function(v){ 
                             return ('<SPAN class="ajustar-texto-grid">'+v+'</SPAN>')
                         },
                text: 'Descripcion',
              
            }, 
             {
                dataIndex: 'anexo',
                flex: 0.3,
                text: 'Anexo',
                  renderer: function (value, metadata, record) {

                    if (record.data.direccion == '') {
                        return '<img  src="' + value + '">';
                    } else {
                        return '<a target="_blank" href="' + record.data.direccion + '"><img  src="' + value + '"></a>';
                    }

                }
              
            }, 
         
             
            ]
    },
   
    buildDockedItems: function () {
        return [
                {
                xtype: 'pagingtoolbar',
                dock: 'bottom',
                store: this.store,
                displayInfo: true,
                  items:[
                   
                ]
            }
        
        ];
    }
});