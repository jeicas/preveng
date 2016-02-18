Ext.define('myapp.view.evento.ListaEventos', {
    extend: 'Ext.tree.Panel',
    
    requires: [
        'Ext.data.*',
        'Ext.grid.*',
        'Ext.tree.*',
        'Ext.ux.CheckColumn',
       
    ],    
    xtype: 'tree-grid',
    title: 'Core Team Projects',
    height: 300,
    useArrows: true,
    rootVisible: false,
    multiSelect: true,
    singleExpand: true,
    
    initComponent: function() {
        this.width = 600;
        
        Ext.apply(this, {
            store: Ext.create('myapp.store.evento.EventoStore'),
            columns: [{
                xtype: 'treecolumn', //this is so we know which column will show the tree
                text: 'Evento',
                flex: 2,
                sortable: true,
                dataIndex: 'titulo'
            }, ]
        });
        this.callParent();
    }
});