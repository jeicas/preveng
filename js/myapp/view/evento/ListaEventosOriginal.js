Ext.define('myapp.view.evento.ListaEventosOriginal', {
    extend: 'Ext.tree.Panel',
    alias: 'widget.listaEventosOriginal',
    requires: [
        'Ext.selection.CellModel',
        'Ext.ux.ajax.SimManager',
        'Ext.ux.grid.FiltersFeature',
        'myapp.view.evento.ListaLineamientoPorEvento'
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
    viewConfig: {
        getRowClass: function (record, index) {
            var c = record.get('estatus');
            switch (c) {
                case 'Pendiente':
                    return 'price-fallPendi';
                    break;
                case 'En Ejecución':
                    return 'price-riseEEjecucion';
                    break;
                case 'Cancelado':
                    return 'price-riseCancelado';
                    break;
                case 'Sin Plan':
                    return 'price-riseSPlan';
                    break;
                case 'Expirado':
                    return 'price-fallExpirado';
                    break;
                default:
                    return 'price-fallCompletado';
                    break;
            }

        }
    },
    store: Ext.create('myapp.store.evento.EventoStore'),
    emptyText: 'No hay Eventos registrados',
    columnLines: true,
   
    initComponent: function () {
        var me = this;
        me.columns = me.buildColumns();
        me.dockedItems = me.buildDockedItems();
        me.callParent();
    },
    buildColumns: function () {
        return [
            {
                xtype: 'listaLineamientoPorEvento'
            },/*
            {
                xtype: 'rownumberer'
            },
            {
                dataIndex: 'fechaEvento',
                flex: 0.4,
                renderer: function (v) {
                    return ('<SPAN class="ajustar-texto-grid">' + v + '</SPAN>')
                },
                text: 'Fecha Limite',
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
                                    property: 'fechaEvento',
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
                dataIndex: 'idEv',
                flex: 0.1,
                text: 'id',
                hidden: true,
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
                                    property: 'id',
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
                dataIndex: 'titulo',
                flex: 1,
                text: 'Titulo',
                renderer: function (v) {
                    return ('<SPAN class="ajustar-texto-grid">' + v + '</SPAN>')
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
                                    property: 'titulo',
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
                dataIndex: 'agente',
                flex: 1,
                text: 'Agente',
                renderer: function (v) {
                    return ('<SPAN class="ajustar-texto-grid">' + v + '</SPAN>')
                },
                renderer: function (v) {
                    return ('<SPAN class="ajustar-texto-grid">' + v + '</SPAN>')
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
                                            property: 'agente',
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
                dataIndex: 'alcance',
                flex: 0.4,
                text: 'Alcance',
                renderer: function (v) {
                    return ('<SPAN class="ajustar-texto-grid">' + v + '</SPAN>')
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
                                    property: 'alcance',
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
                dataIndex: 'sector',
                flex: 0.4,
                text: 'Sector',
                renderer: function (v) {
                    return ('<SPAN class="ajustar-texto-grid">' + v + '</SPAN>')
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
                                    property: 'sector',
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
                dataIndex: 'tipoEvento',
                flex: 0.6,
                text: 'Tipo de Evento',
                renderer: function (v) {
                    return ('<SPAN class="ajustar-texto-grid">' + v + '</SPAN>')
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
                                    property: 'tipoEvento',
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
                flex: 0.5,
                dataIndex: 'estatus',
                text: 'Estado',
                renderer: function (v) {
                    return ('<SPAN class="ajustar-texto-grid">' + v + '</SPAN>')
                },
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
            },
            {
                xtype: 'actioncolumn',
                flex: 0.1,
                name: 'ver',
                sortable: false,
                menuDisabled: true,
                items: [{
                        iconCls: 'icon-eventoL',
                        tooltip: 'Lineamientos/Comisionados/Reincidencias del Evento',
                        scope: this,
                    }]
            },
            {
                xtype: 'actioncolumn',
                flex: 0.1,
                id: 'resumenEvento',
                name: 'resumenEvento',
                sortable: false,
                menuDisabled: true,
                items: [{
                        iconCls: 'icon-eventoR',
                        tooltip: 'Resumen del Evento',
                        scope: this,
                    }]
            },
            {
                xtype: 'actioncolumn',
                flex: 0.1,
                id: 'cerrarEvento',
                name: 'cerrarEvento',
                sortable: false,
                menuDisabled: true,
                items: [{
                        iconCls: 'icon-aceptar',
                        tooltip: 'Cerrar Evento',
                        scope: this,
                    }]
            }*/]
    },
    buildDockedItems: function () {
        return [{
                xtype: 'pagingtoolbar',
                dock: 'bottom',
                store: this.store,
                displayInfo: true,
                items: [
                ]
            },
            {
                xtype: 'toolbar',
                dock: 'top',
                store: this.store,
                displayInfo: true,
                items: [
                    {
                        xtype: 'button',
                        name: 'btnNuevo',
                        text: 'Nuevo',
                        iconCls: 'useradd'
                    },
                    {
                        xtype: 'button',
                        name: 'btnEditar',
                        text: 'Editar',
                        iconCls: 'useredit'
                    },
                    {
                        xtype: 'button',
                        name: 'btnCancelar',
                        text: 'Cancelar',
                        iconCls: 'userdelete'
                    },
                ]
            }];
    }
});