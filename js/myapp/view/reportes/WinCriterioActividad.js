Ext.define('myapp.view.reportes.WinCriterioActividad', {
    extend: 'Ext.window.Window',
    alias: 'widget.winCriterioActividad',
    itemId: 'winCriterioActividad',
    title: 'Criterios de Selección para las metas alcanzadas',
    height: 150,
    width: 300,
    modal: true,
    requires: [
    ],
    layout: {
        type: 'fit'
    },
    initComponent: function () {
        var me = this;
        me.items = me.buildItem();
        me.dockedItems = me.buildDockedItems();
        me.callParent();
    },
    buildItem: function () {
        return [{
                xtype: 'form',
                height: 670,
                name:'formulario',
                width: 676,
                layout: 'vbox',
                items: [
                    {
                        xtype: 'fieldcontainer',
                        height: 50,
                        width: 700,
                        margins: '17 0 0 17',
                        layout: 'hbox',
                        items: [
                            {
                                xtype: 'combobox',
                                width: 250,
                                fieldLabel: 'Evento:',
                                name: 'cmbEvento',
                                id: 'cmbEvento',
                                editable: false,
                                store: Ext.create('myapp.store.evento.EventoStore'),
                                valueField: 'idEv',
                                displayField: 'titulo',
                                emptyText: 'Seleccione',
                                queryMode: 'local',
                                allowBlank: false,
                                triggerAction: 'all'
                            }, 
                                ]// fin del contenedor
                            }
                ]
            }]
    },
    buildDockedItems: function () {
        return [{
                xtype: 'toolbar',
                flex: 1,
                dock: 'bottom',
                items: [{
                        xtype: 'tbfill'
                    },
                    {
                        xtype: 'button',
                        iconCls: 'generar',
                        name: 'btnGenerarAct',
                        // itemId: 'addAvance', 
                        text: 'Generar',
                        disabled: false,
                        //formBind: true,
                        scope: this,
                    }, 
                    {
                        xtype: 'button',
                        iconCls: 'icon-limpiar',
                        name: 'btnLimpiarAct',
                        // itemId: 'addAvance', 
                        text: 'Limpiar',
                        disabled: false,
                        //formBind: true,
                        scope: this,
                    }
                ]
            }]
    }
});