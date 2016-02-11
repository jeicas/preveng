Ext.define('myapp.view.seguridad.ListaCalificacionEditar', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.listaCalificacionEditar',
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
    plugins: [{
            ptype: 'cellediting',
            clicksToEdit: 1,
            pluginId: 'rowediting'
        }],
    emptyText: 'No hay calificaciones registradas',
    buildColumns: function () {
        return [{
                xtype: 'rownumberer'
            },
            {
                text: 'Descripcion',
                autoScroll: true,
                renderer: function (v) {
                    return ('<SPAN class="ajustar-texto-grid">' + v + '</SPAN>')
                },
                dataIndex: 'descripcion',
                flex: 1,
                editor: {
                    xtype: 'textfield',
                    name: 'descripcion',
                    maskRe: /[A-Za-z ]/
                }, items: {
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
                                    property: 'descripcion',
                                    value: this.value,
                                    anyMatch: true,
                                    caseSensitive: false
                                });
                            }
                        },
                        buffer: 500
                    },
                }
            },
             {
                text: 'Desde',
                autoScroll: true,
                renderer: function (v) {
                    return ('<SPAN class="ajustar-texto-grid">' + v + '</SPAN>')
                },
                dataIndex: 'desde',
                flex: 0.3,
                editor: {
                    xtype: 'textfield',
                    name: 'desde',
                    vtype: 'numero'
                }, items: {
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
                                    property: 'desde',
                                    value: this.value,
                                    anyMatch: true,
                                    caseSensitive: false
                                });
                            }
                        },
                        buffer: 500
                    },
                }
            },
             {
                text: 'Hasta',
                autoScroll: true,
                renderer: function (v) {
                    return ('<SPAN class="ajustar-texto-grid">' + v + '</SPAN>')
                },
                dataIndex: 'hasta',
                flex: 0.3,
                editor: {
                    xtype: 'textfield',
                    name: 'hasta',
                    vtype: 'numero'
                }, items: {
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
                                    property: 'hasta',
                                    value: this.value,
                                    anyMatch: true,
                                    caseSensitive: false
                                });
                            }
                        },
                        buffer: 500
                    },
                }
            }, 
        
            {
                xtype: 'actioncolumn',
                flex: 0.1,
                name: 'eliminarItem',
                sortable: false,
                menuDisabled: true,
                items: [{
                        iconCls: 'cancel',
                        tooltip: 'Eliminar Item',
                        scope: this,
                    }]
            }]
    },
    buildDockedItems: function () {
        return [
            {
                xtype: 'pagingtoolbar',
                dock: 'bottom',
                store: this.store,
                displayInfo: true,
                items: [{
                        xtype: 'button',
                        name: 'btnAgregar',
                        tooltip: 'Nuevo',
                        iconCls: 'useradd'
                    },
                    {
                        xtype: 'button',
                        name: 'btnGuardar',
                        tooltip: 'Guardar',
                        iconCls: 'save'
                    },
                ]
            },  ];
    }
});





	