Ext.define('myapp.view.seguridad.GridCalificacion', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.gridCalificacion',
    requires: [
        'Ext.selection.CellModel',
        'Ext.selection.CheckboxModel',
        'Ext.ux.ajax.SimManager',
        'Ext.ux.grid.FiltersFeature',
    ],
    features: [{
            ftype: 'filters',
            local: true
        }, {
            id: 'group',
            ftype: 'groupingsummary',
            summaryType: 'count',
            groupHeaderTpl: '<font size=2><font size=2>{name}</font>',
            hideGroupedHeader: true,
            enableGroupingMenu: false
        }],
    store: Ext.create('myapp.store.seguridad.configuracionStore'),
    viewConfig: {
    },
  
    columnLines: true,
    initComponent: function () {
        var me = this;
        me.columns = me.buildColumns();
        me.dockedItems = me.buildDockedItems();
        me.callParent();
    },
   
    emptyText: 'No hay calificaciones registradas',
    buildColumns: function () {
        return [ {
                xtype: 'rownumberer'
            },
            {
                flex: 1,
                dataIndex: 'descripcion',
                text: 'Descripcion',
                items: {
                    xtype: 'textfield',
                    flex: 1,
                    margin: 2,
                    enableKeyEvents: true,
                    listeners: {
                        keyup: function () {
                            var store = this.up('grid').store;
                            store.clearFilter();
                            if (this.value) {
                                store.filter({
                                    property: 'nombre',
                                    value: this.value,
                                    anyMatch: true,
                                    caseSensitive: false
                                });
                            }
                        },
                        buffer: 500
                    }
                }
            },{
                flex: 1,
                dataIndex: 'desde',
                text: 'Desde',
                items: {
                    xtype: 'textfield',
                    flex: 1,
                    margin: 2,
                    enableKeyEvents: true,
                    listeners: {
                        keyup: function () {
                            var store = this.up('grid').store;
                            store.clearFilter();
                            if (this.value) {
                                store.filter({
                                    property: 'nombre',
                                    value: this.value,
                                    anyMatch: true,
                                    caseSensitive: false
                                });
                            }
                        },
                        buffer: 500
                    }
                }
            },
        {
                flex: 1,
                dataIndex: 'hasta',
                text: 'Hasta',
                items: {
                    xtype: 'textfield',
                    flex: 1,
                    margin: 2,
                    enableKeyEvents: true,
                    listeners: {
                        keyup: function () {
                            var store = this.up('grid').store;
                            store.clearFilter();
                            if (this.value) {
                                store.filter({
                                    property: 'nombre',
                                    value: this.value,
                                    anyMatch: true,
                                    caseSensitive: false
                                });
                            }
                        },
                        buffer: 500
                    }
                }
            },]
    },
    buildDockedItems: function () {
        return [{
                xtype: 'toolbar',
                x: 20,
                y: 10,
                height: 40,
                width: 440,
                items: [
                  {
                        xtype: 'button',
                        name: 'btnNuevaConfiguracion',
                        text: 'Configurar',
                        iconCls: 'useradd'
                    },
                ]
            }, 
        {
                xtype: 'pagingtoolbar',
                dock: 'bottom',
                store: this.store,
                displayInfo: true,
                items: [
                ]
            },];
    }
});





	