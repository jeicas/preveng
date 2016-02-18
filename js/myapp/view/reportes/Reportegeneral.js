Ext.define('myapp.view.reportes.Reportegeneral', {
    extend: 'Ext.panel.Panel',
    alias: 'widget.reportegeneral',
    autoShow: true,
    title: 'Generar Reporte',
    layout: {
        align: 'center',
        pack: 'center',
        type: 'vbox'
    },
    bodyCls: 'degradado',
    bodyStyle: {
        background: '#F0F8FF',
        padding: '10px',
        color: '#000',
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
                layout: 'vbox',
                items: [
                    {
                        xtype: 'label',
                        width: 400,
                        text: 'REPORTES POR CATEGORIA',
                        name: 'lblTITLE',
                        margin: '20 20 20 20',
                    },
                    {
                        xtype: 'container',
                        layout: 'hbox',
                        items: [
                            {
                                xtype: 'button',
                                name: 'btnEvento',
                                scale: 'large',
                                autoWidth: true,
                                autoHeight: true,
                                tooltip: 'Eventos',
                                iconCls: 'evento2',
                                margin: '20 20 20 20',
                                cls: 'x-btn-green',
                            },
                            {
                                xtype: 'button',
                                name: 'btnActividad',
                                scale: 'large',
                                 autoWidth: true,
                                autoHeight: true,
                                tooltip: 'Plan de Acción',
                                margin: '20 20 50 50',
                                iconCls: 'plan2',
                                cls: 'x-btn-green',
                            },
                        ]

                    }

                ]

            }
        ]
    }


});

  