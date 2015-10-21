    Ext.define('myapp.view.evento.WinEventoCompleto', {
        extend: 'Ext.window.Window',
        alias: 'widget.EventoCompleto',
        itemId: 'winEventoCompleto',
        title: 'Evento',
        height: '80%',
        width: '90%',
        modal: true,
        requires: [
            ' Ext.chart.*',
            'myapp.view.reportes.GraficoNivelEjecucion'
        ],
        layout: {
            type: 'fit'
        },
        initComponent: function () {
            var me = this;
            me.items = me.buildItem();
            me.callParent();
        },
        buildItem: function () {
            return [
                {
                    xtype: 'container',
                    height: '100%',
                    width: '100%',
                    layout: 'hbox',
                    items: [
                        {
                            xtype: 'fieldset',
                            height: '80%',
                            width: '29%',
                            margin:'10 0 0 10',
                            layout: 'hbox',
                            title: 'Datos del Evento',
                            items: [

                             {
                            xtype: 'container',
                            layout: 'vbox',
                            height: '100%',
                            width: '100%',
                            items: [
                              {
                                    xtype: 'textfield',
                                    width: '100%',
                                    fieldLabel: 'Evento:',
                                    name: 'titulo'
                                },
                                 {
                                    xtype: 'textfield',

                                    width: '100%',
                                    fieldLabel: 'Fecha:',
                                    name: 'fecha'
                                },
                                 {
                                    xtype: 'textareafield',

                                  width: '100%',
                                    fieldLabel: 'Descripción',
                                    name: 'descripcion'
                                },
                                  {
                                    xtype: 'textfield',

                                    width: '100%',
                                    fieldLabel: 'Sector:',
                                    name: 'sector'
                                },
                                   {
                                    xtype: 'textfield',

                                    width: '100%',
                                    fieldLabel: 'Alcance:',
                                    name: 'alcance'
                                },
                                 {
                                    xtype: 'textfield',


                                    width: '100%',
                                    fieldLabel: 'Agente:',
                                    name: 'agente'
                                },
                                {
                                    xtype: 'textfield',

                                     width: '100%',
                                    fieldLabel: 'Tipo de Evento',
                                    name: 'tipoEvento'
                                },
                                   {
                                    xtype: 'textfield',

                                    width: '100%',
                                    fieldLabel: 'Estado:',
                                    name: 'estatus'

                                },
                                 {
                                    xtype: 'textareafield',

                                   width: '100%',
                                    fieldLabel: 'Observación',

                                    name: 'observacion'
                                }
                            ]
                        },


                            ]
                        },

                        {
                            xtype: 'container',
                            height: '100%',
                            width: '35%',
                            margin:'10 0 10 10',
                            layout: 'absolute',
                            items: [
                                {
                                    xtype: 'fieldset',

                                    height: 460,
                                    width: 380,
                                    layout: 'absolute',
                                    title: 'Información del Plan de Acción:',
                                    items: [
                                        {
                                            xtype: 'gridpanel',
                                            x: 10,
                                            y: 10,
                                            height: 410,
                                            width: 330,
                                            name: 'gridPlanDeAccion',
                                            columnLines: true,
                                            store: Ext.create('myapp.store.actividad.ActividadAvance2Store'),
                                            emptyText: 'No tiene Plan de accion',
                                            title: 'Plan de Acción',
                                            features: [{
                                                    id: 'group',
                                                    ftype: 'groupingsummary',
                                                    summaryType: 'count',
                                                    groupHeaderTpl: '<font size=2><font size=2>{name}</font>',
                                                    hideGroupedHeader: true,
                                                    enableGroupingMenu: false
                                                }],
                                            columns: [
                                                {
                                                    dataIndex: 'avance',
                                                    text: 'Avance',
                                                    flex: 0.7

                                                },
                                                {
                                                    dataIndex: 'tipoEvento',
                                                    text: 'Tipo',
                                                    flex: 0.4
                                                },
                                                {
                                                    dataIndex: 'ejecutor',
                                                    text: 'Ejecutor',
                                                    flex: 0.5
                                                }
                                            ],
                                            viewConfig: {
                                                height: 273
                                            },
                                            dockedItems: [
                                                {
                                                    xtype: 'toolbar',
                                                    dock: 'top',
                                                    height: 53,
                                                    items: [
                                                        {
                                                            xtype: 'textfield',
                                                            x: 10,
                                                            y: 10,
                                                            width: 300,
                                                            name: 'responsable',
                                                            fieldLabel: 'Responsable:'
                                                        }

                                                    ]
                                                }
                                            ]
                                        }

                                    ]
                                }
                            ]
                        },
                        {
                            xtype: 'container',
                            height: '100%',
                            width: '29%',
                            margin:'10 0 0 10',
                            items: [


                                {
                                    xtype: 'GraficoNivelEjecucion',

                                }, 
                                 {
                            xtype: 'grid',
                            height:58,
                            width: 320,
                            name: 'gridCalcularNivel',
                            columnLines: true,
                            store:  Ext.create('myapp.store.reporte.CalcularNivelEjecucionStore'),
                            columns: [

                                 {
                                    dataIndex: 'name1',
                                    text: '', 
                                     flex: 1
                                },
                                {
                                    dataIndex: 'ejecutadas',
                                    text: 'Ejecutadas', 
                                     flex: 1.3
                                }, 
                                 {
                                    dataIndex: 'porejecutar',
                                    text: 'Por Ejecutar', 
                                     flex: 1.3
                                },
                                {
                                    dataIndex: 'total',
                                    text: 'Total', 
                                     flex: 0.7
                                },
                            ]
                        }
                            ]
                        }
                    ]
                }
            ]
        }

    });



