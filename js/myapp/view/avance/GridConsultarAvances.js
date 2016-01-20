Ext.define('myapp.view.consultar.GridConsultarAvances', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.gridConsultarAvances',
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
            enableGroupingMenu: false,
            startCollapsed: true

        }],
    viewConfig: {
        getRowClass: function (record, index) {
            var c = record.get('estatus');
            switch (c) {
                case 'Cancelado':
                    return 'price-riseCancelado';
                    break;
                case 'Rechazado':
                    return 'price-fallRechazado';
                    break;
                case 'Extenporaneo':
                    return 'price-fallExtenporaneo';
                    break;
                case 'Pendiente por Evaluar':
                    return 'price-fallPend';
                    break;

                default:
                    return 'price-fallCompletado';
                    break;
            }

        }
    },
    store: Ext.create('myapp.store.avance.AvanceStore'),
    columnLines: true,
    initComponent: function () {
        var me = this;
        me.columns = me.buildColumns();
        me.dockedItems = me.buildDockedItems();
        me.callParent();
    },
    buildColumns: function () {
        return [{
                xtype: 'rownumberer'
            },
            {
                dataIndex: 'descripcion',
                flex: 1.2,
                text: 'Descripcion',
                 renderer: function(v){ 
                             return ('<SPAN class="ajustar-texto-grid">'+v+'</SPAN>')
                         },
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
                                    property: 'descripcion',
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
                dataIndex: 'tipo',
                flex: 0.3,
                text: 'Tipo',
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
                                    property: 'tipo',
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
                dataIndex: 'fecha',
                flex: 0.4,
                text: 'Fecha:',
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
                                    property: 'fecha',
                                    value: this.value,
                                    anyMatch: true,
                                    caseSensitive: false
                                });
                            }
                        },
                        buffer: 500
                    }
                }
            }, {
                flex: 0.6,
                dataIndex: 'nombre',
                text: 'Nombre',
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
            }, {
                dataIndex: 'meta',
                flex: 0.3,
                text: 'Meta',
            }, {
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
            {
                flex: 0.5,
                dataIndex: 'estatus',
                text: 'Estado',
                tdCls: 'x-change-cell',
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
                                    property: 'estatus',
                                    value: this.value,
                                    anyMatch: true,
                                    caseSensitive: false
                                });
                            }
                        },
                        buffer: 500
                    }
                }
            }]
    },
    buildDockedItems: function () {
        return [{
                xtype: 'pagingtoolbar',
                dock: 'bottom',
                store: this.store,
                displayInfo: true,
                items: []
            }];
    }
});