Ext.define('myapp.view.evento.ListaLineamientoPorEvento', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.listaLineamientoPorEvento',
    itemId: 'listaLineamientoPorEvento',
    requires: [
        'Ext.selection.CellModel',
        'Ext.selection.CheckboxModel',
        'Ext.ux.ajax.SimManager',
    ],
    
    store: Ext.create('myapp.store.lineamiento.LineamientoEventoStore'),
    emptyText: 'No hay lineamientos registrado',
    columnLines: true,
    initComponent: function () {
        var me = this;
        me.columns = me.buildColumns();
        me.dockedItems = me.buildDockedItems();
        me.callParent();
    },
  /*  plugins: [{
            ptype: 'rowexpander',
            rowBodyTpl : new Ext.XTemplate(
                '<p><b>Company:</b> </p>',
                '<p><b>Change:</b> </p><br>',
                '<p><b>Summary:</b> </p>',
            {
               /* formatChange: function(v){
                    var color = v >= 0 ? 'green' : 'red';
                    return '<span style="color: ' + color + ';">' + Ext.util.Format.usMoney(v) + '</span>';
                }*/
           /* })
        }],*/
        collapsible: true,
    buildColumns: function () {
        return [   {
            xtype: 'rownumberer'
        },{
                dataIndex: 'idLin',
                hidden: true,
                flex: 0.2,
                text: 'idLin',
               
            }, {
                dataIndex: 'descripcion',
                flex: 1.5,
                renderer: function(v){ 
                             return ('<SPAN class="ajustar-texto-grid">'+v+'</SPAN>')
                         },
                text: 'Descripcion',
              
            }
            ]
    },
    buildDockedItems: function () {
        return [
        {
                xtype: 'pagingtoolbar',
                dock: 'bottom',
                store: this.store,
                displayInfo: true,
                items: [
                ]
            },
];
    }
});