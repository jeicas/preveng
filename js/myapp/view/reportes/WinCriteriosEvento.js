Ext.define('myapp.view.reportes.WinCriteriosEvento', {
    extend: 'Ext.window.Window',
    alias: 'widget.winCriteriosEvento',
    itemId: 'winCriteriosEvento',
    title: 'Criterios de Selección para Eventos',
    height: 250,
    width: 600,
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
                                fieldLabel: 'Tipo de Evento:',
                                name: 'cmbTipoEvento',
                                id: 'cmbTipoEvento',
                                editable: false,
                                store: Ext.create('myapp.store.tipoEvento.TipoEventoStore'),
                                valueField: 'id',
                                displayField: 'nombre',
                                emptyText: 'Seleccione',
                                queryMode: 'local',
                                allowBlank: false,
                                triggerAction: 'all'
                            }, {
                                xtype: 'combobox',
                                width: 250,
                                fieldLabel: 'Agente Emisor:',
                                name: 'cmbAgente',
                                id: 'cmbAgente',
                                margins: '0 0 0 10',
                                editable: false,
                                store: Ext.create('myapp.store.agente.AgenteStore'),
                                valueField: 'id',
                                displayField: 'nombre',
                                emptyText: 'Seleccione',
                                queryMode: 'local',
                                allowBlank: false,
                                triggerAction: 'all'
                            },
                        ]// fin del contenedor
                    }, {
                        xtype: 'fieldcontainer',
                        height: 50,
                        width: 700,
                        margins: '0 0 0 17',
                        layout: 'hbox',
                        items: [{
                                xtype: 'combobox',
                                width: 250,
                                fieldLabel: 'Alcance',
                                name: 'cmbAlcance',
                                id: 'cmbAlcance',
                                editable: false,
                                store: Ext.create('myapp.store.alcance.AlcanceStore'),
                                valueField: 'id',
                                displayField: 'nombre',
                                emptyText: 'Seleccione',
                                queryMode: 'local',
                                allowBlank: false,
                                triggerAction: 'all'
                            },
                            {
                                xtype: 'combobox',
                                width: 250,
                                fieldLabel: 'Sector:',
                                name: 'cmbSector',
                                id: 'cmbSector',
                                margins: '0 0 0 10',
                                editable: false,
                                store: Ext.create('myapp.store.sector.SectorStore'),
                                valueField: 'id',
                                displayField: 'nombre',
                                emptyText: 'Seleccione',
                                queryMode: 'local',
                                allowBlank: false,
                                triggerAction: 'all'
                            },
                           
                        ]// fin del contenedor
                    }, 
                     {
                                xtype: 'fieldcontainer',
                                height: 50,
                                width: 700,
                                layout: 'hbox',
                                   margins: '0 0 0 17',
                                items: [
                                    {
                                        xtype: 'combobox',
                                        width: 250,
                                        fieldLabel: 'Estatus:',
                                        name: 'cmbEstatus',
                                        id: 'cmbEstatus',
                                        editable: false,
                                        store: Ext.create('myapp.store.evento.EstatusStore'),
                                        valueField: 'id',
                                        displayField: 'nombre',
                                        emptyText: 'Seleccione',
                                        queryMode: 'local',
                                        allowBlank: false,
                                        triggerAction: 'all'
                                    },
                                    {
                                        xtype: 'datefield',
                                        width: 250,
                                        margins: '-2 0 0 10',
                                        fieldLabel: 'Fecha del Evento:',
                                        name: 'dtfFechaT',
                                        format: 'Y-m-d'
                                        
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
                        name: 'btnGenerar',
                        // itemId: 'addAvance', 
                        text: 'Generar',
                        disabled: false,
                        //formBind: true,
                        scope: this,
                    }, 
                    {
                        xtype: 'button',
                        iconCls: 'icon-limpiar',
                        name: 'btnLimpiar',
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