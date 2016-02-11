Ext.define('myapp.view.Viewport', {
    extend: 'Ext.container.Viewport',
    alias: 'widget.mainviewport',
    requires: [
        'myapp.view.Header',
        'myapp.view.menu.Accordion',
        'myapp.view.menu.Mainpanel',
    ],
    store: Ext.create('myapp.store.Session'),
    layout: {type: 'border'},
    initComponent: function () {
        var me = this;
        me.items = me.buildItem();
        me.callParent();
    },
    buildItem: function () {
        return [{
                xtype: 'mainmenu',
                width: 220,
                name: 'regionmenu',
                collapsible: true,
                region: 'west',
                'text': 'Base',
            }, {
                xtype: 'appheader',
                width: '100%',
                height: '20%',
                name: 'regionheader',
                region: 'north'
            }, {
                xtype: 'mainpanel',
                region: 'center',
                name: 'menu',
                bodyCls: 'degradado',
                bodyStyle: "background­color:#999999;", 
            },
            {
                xtype: 'panel',
                region: 'east',
                collapsible: true,
                height: '50%',
                width: '30%',
                bodyCls: 'degradado',
                bodyStyle: "background­color:#999999;", 
                name: 'regioneste',
                hidden: true,
                split: true,
                items: [{
                        xtype: 'container',
                        height: '100%',
                        width: '100%',
                        layout: 'vbox',
                        items: [
                            {
                                xtype: 'gridpanel',
                                height: 150,
                                width: '100%',
                                //title: 'Lineamientos',
                                name: 'gridLineamiento',
                                emptyText: 'No tiene lineamientos registrados',
                                store: Ext.create('myapp.store.lineamiento.LineamientoEventoStore'),
                                columns: [
                                    {
                                        dataIndex: 'fecha',
                                        flex: 0.7,
                                        text: 'Fecha'
                                    },
                                    {
                                        dataIndex: 'descripcion',
                                        flex: 1,
                                        renderer: function (v) {
                                            return ('<SPAN class="ajustar-texto-grid">' + v + '</SPAN>')
                                        },
                                        text: 'Descripción'
                                    }
                                ],
                                dockedItems: [
                                    {
                                        xtype: 'toolbar',
                                        dock: 'top',
                                        height: 35,
                                       
                                        items: [
                                            {
                                                xtype: 'label',
                                                text: 'Lineamientos',
                                            },
                                            {
                                                xtype: 'tbfill'
                                            },
                                            {
                                                xtype: 'tbfill'
                                            },
                                            {
                                                xtype: 'tbfill'
                                            },
                                            {
                                                xtype: 'tbfill'
                                            },
                                            {
                                                xtype: 'fieldcontainer',
                                                layout: 'hbox',
                                                items: [
                                                    {
                                                        xtype: 'button',
                                                        name: 'btnNuevoLineamiento',
                                                        tooltip: 'Nuevo',
                                                        margin: '0 0 0 5',
                                                        iconCls: 'useradd',
                                                        cls: 'icon-clave'
                                                    },
                                                    {
                                                        xtype: 'button',
                                                        name: 'btnEditarLineamiento',
                                                        tooltip: 'Editar',
                                                        margin: '0 0 0 5',
                                                        cls: 'icon-clave',
                                                        iconCls: 'useredit'
                                                    },
                                                    {
                                                        xtype: 'button',
                                                        name: 'btnEliminarLineamiento',
                                                        tooltip: 'Eliminar',
                                                        margin: '0 0 0 5',
                                                        cls: 'icon-clave',
                                                        iconCls: 'icon-eliminar'
                                                    },{
                                                        xtype: 'button',
                                                        name: 'btnVerLineamientos',
                                                        tooltip: 'Ver Lineamientos',
                                                        margin: '0 0 0 5',
                                                         cls:'icon-clave',
                                                        iconCls: 'buscar'
                                                    }]
                                            },
                                        ]
                                    }
                                ]
                            },
                            {
                                xtype: 'gridpanel',
                                height: 150,
                                width: '100%',
                                name: 'gridComisionado',
                                store: Ext.create('myapp.store.comisionado.ComisionadoEventoStore'),
                                emptyText: 'No tiene comisionados registrados',
                                //title: 'Comisionados',
                                columns: [
                                    {
                                        dataIndex: 'nombrecompleto',
                                        flex: 1,
                                        text: 'Nombre'
                                    },
                                    {
                                        dataIndex: 'cargo',
                                        flex: 0.7,
                                        text: 'Cargo'
                                    }
                                ],
                                dockedItems: [
                                    {
                                        xtype: 'toolbar',
                                        dock: 'top',
                                        height: 35,
                                        items: [
                                             {
                                                xtype: 'label',
                                                text: 'Comisionados',
                                            },
                                            {
                                                xtype: 'textfield',
                                                fieldLabel: 'Evento:',
                                                name: 'titleEvento', 
                                                hidden:true 
                                            },
                                            {
                                                xtype: 'tbfill'
                                            },
                                            {
                                                xtype: 'tbfill'
                                            },
                                            {
                                                xtype: 'tbfill'
                                            },
                                            {
                                                xtype: 'tbfill'
                                            },
                                            {
                                                xtype: 'fieldcontainer',
                                                layout: 'hbox',
                                                items: [
                                                    {
                                                        xtype: 'button',
                                                        name: 'btnNuevoComisionado',
                                                        tooltip: 'Asignar Comisionado',
                                                        margin: '0 0 0 5',
                                                        iconCls: 'icon-agregarUs',
                                                        cls: 'icon-clave'
                                                    },
                                                    {
                                                        xtype: 'button',
                                                        name: 'btnEliminarComisionado',
                                                        tooltip: 'Eliminar Comisionado',
                                                        margin: '0 0 0 5',
                                                        cls: 'icon-clave',
                                                        iconCls: 'icon-eliminarUs'
                                                    }]
                                            },
                                        ]
                                    }
                                ]
                            },
                            {
                                xtype: 'gridpanel',
                                height: 150,
                                width: '100%',
                                name: 'gridReincidencia',
                                store: Ext.create('myapp.store.reincidencia.ReincidenciaEventoStore'),
                                emptyText: 'No tiene reincidencias registradas',
                                //title: 'Reincidencias',
                                columns: [
                                    {
                                        dataIndex: 'fecha',
                                        flex: 0.7,
                                        text: 'Fecha'
                                    },
                                    {
                                        dataIndex: 'descripcion',
                                        flex: 1,
                                        renderer: function (v) {
                                            return ('<SPAN class="ajustar-texto-grid">' + v + '</SPAN>')
                                        },
                                        text: 'Descripción'
                                    }
                                ],
                                dockedItems: [
                                    {
                                        xtype: 'toolbar',
                                        dock: 'top',
                                        height: 35,
                                        items: [
                                             {
                                                xtype: 'label',
                                                text: 'Reincidencias',
                                            },
                                            {
                                                xtype: 'textfield',
                                                fieldLabel: 'Evento:',
                                                name: 'idEvento', 
                                                hidden:true 
                                            },
                                            {
                                                xtype: 'tbfill'
                                            },
                                            {
                                                xtype: 'tbfill'
                                            },
                                            {
                                                xtype: 'tbfill'
                                            },
                                            {
                                                xtype: 'tbfill'
                                            },
                                            {
                                                xtype: 'fieldcontainer',
                                                layout: 'hbox',
                                                items: [
                                                    {
                                                        xtype: 'button',
                                                        name: 'btnNuevoReincidencia',
                                                        tooltip: 'Nuevo',
                                                        
                                                        margin: '0 0 0 5',
                                                        iconCls: 'useradd',
                                                        cls: 'icon-clave'
                                                    },
                                                    {
                                                        xtype: 'button',
                                                        name: 'btnEliminarReincidencia',
                                                        tooltip: 'Eliminar',
                                                        margin: '0 0 0 5',
                                                        cls: 'icon-clave',
                                                        iconCls: 'icon-eliminar'
                                                    }, {
                                                        xtype: 'button',
                                                        name: 'btnVerReincidencias',
                                                        tooltip: 'Ver Reincidencias',
                                                        margin: '0 0 0 5',
                                                       cls: 'icon-clave',
                                                        iconCls: 'buscar'
                                                    }]
                                            },
                                        ]
                                    }
                                ]

                            }

                        ]// fin del contenedor
                    }]


            },
            {
                xtype: 'container',
                region: 'south',
                name: 'regionsur',
                height: 30,
                style: 'border-top: 1px solid #4c72a4;',
                html: '<div id="titleHeader"><center><span style="font-size:10px;">Oficina de Informática-División de Desarrollo de Sistemas </span></center></div>'
            }]
    }
});