Ext.define('myapp.view.actividad.WinActividad', {
extend: 'Ext.window.Window',
        alias: 'widget.winActividad',
        itemId: 'winActividad',
        title:'Actividad',
        height: '66%',
        width: '40%',
        modal:true,
        requires: [
                'myapp.view.actividad.ActividadForm'
        ],
        layout: {
        type: 'fit'
        },
        initComponent: function() {
        var me = this;
                me.items = me.buildItem();
                me.dockedItems = me.buildDockedItems();
                me.callParent();
        },
        buildItem : function(){
        return [ {
        xtype: 'container',
                margin:'5 0 0 0',
                height: '100%',
                width: '100%',
                layout: 'vbox',
                items: [
                {
                xtype: 'fieldset',
                        margin:'5 0 0 5',
                        height: 150,
                        width: 517,
                        layout: 'absolute',
                        title: '',
                        items: [
                        {
                        xtype: 'textareafield',
                                x: 10,
                                y: 10,
                                width: 470,
                                allowBlank :false,
                                minLength:5,
                                maxLength: 95,
                                fieldLabel: 'Descripción (*):',
                                name:'descripcion'
                        },
                        {
                        xtype: 'datefield',
                                x: 10,
                                y: 90,
                                width: 220,
                                fieldLabel: 'Fecha Tope',
                                name:'dtfFechaT',
                                format:'Y-m-d',
                                minValue: new Date(), //<-- min date is today
                                value:new Date()


                        },
                        {
                        xtype: 'datefield',
                                x: 260,
                                y: 80,
                                width: 220,
                                fieldLabel: 'Fecha de Preaviso:',
                                name:'dtfFechaPA',
                                format:'Y-m-d',
                                minValue: new Date(), //<-- min date is today
                                value:new Date()
                        },
                        {
                        xtype: 'numberfield',
                                x: 10,
                                y: 120,
                                width: 220,
                                fieldLabel: 'Meta:',
                                name:'meta',
                        },
                        {
                        xtype: 'textfield',
                                x: 260,
                                y: 120,
                                width: 220,
                                fieldLabel: 'U.de Medida',
                                name:'medida',
                        }
                        ]
                }, {
                xtype: 'fieldset',
                        margin:'5 0 0 5',
                        height: 80,
                        width: 517,
                        layout: 'absolute',
                        title: '',
                        items: [
                        {
                        xtype: 'checkboxfield',
                                x: 10,
                                y: 10,
                                fieldLabel: 'Esta actividad depende de otra para iniciar?',
                                boxLabel: 'Si',
                                name:'cbfDepende'
                        },
                        {
                            xtype: 'textfield',
                            x: 200,
                            y: 30,
                            width: 130,
                            readOnly:true,
                            name :'idActiDepende', 
                            fieldLabel:'idDepende', 
                            hidden:true
                        },
                        {
                        xtype: 'combobox',
                                x: 200,
                                y: 10,
                                fieldLabel: 'Actividad:',
                                name:'cmbActividadDepende',
                                editable      : false,
                                store         : Ext.create('myapp.store.actividad.ActividadDependienteStore'),
                                valueField    : 'id',
                                displayField  : 'descripcion',
                                emptyText     :'Seleccione',
                                queryMode     : 'local',
                                disabled       :true,
                                triggerAction : 'all'


                        }
                        ]
                }, {
                xtype: 'fieldset',
                        margin:'5 0 0 5',
                        height: 80,
                        width: 517,
                        layout: 'absolute',
                        title: '',
                        items: [
                        {
                        xtype: 'label',
                                x: 10,
                                y: 10,
                                text: 'Datos del Responsable:',
                                name:'lblTitleResponsable'
                        },
                        {
                        xtype: 'button',
                                x: 10,
                                y: 30,
                                iconCls: 'icon-agregarUs',
                                name: 'btnAsignarResponsable',
                                text: 'Asignar'
                        },
                        {
                            xtype: 'textfield',
                            x: 10,
                            y: 5,
                            width: 130,
                            readOnly:true,
                            name :'idUsuario', 
                            hidden:true
                        },
                         
                         {
                            xtype: 'textfield',
                            x: 10,
                            y: 5,
                            width: 130,
                            readOnly:true,
                            name :'correo', 
                            hidden:true
                        },
                        {
                            xtype: 'image',
                            x: 150,
                            y: 10,
                            name :'fotoUsuario', 
                            height: 65,
                            width: 60,
                            src:BASE_PATH+'imagen/foto/silueta.png'
                        },
                         {
                            xtype: 'textfield',
                            x: 220,
                            y: 5,
                            width: 270,
                            readOnly:true,
                            name :'txtCedula', 
                            fieldLabel: 'Nro. de Cédula:'
                        },
                        
                        {
                            xtype: 'textfield',
                            x: 220,
                            y: 40,
                            width: 270,
                            readOnly:true,
                            name :'txtNombreCompleto', 
                            fieldLabel: 'Nombre:'
                        },
                        ]
                }

                ]


        }]
        },
        buildDockedItems : function(){
        return [{
        xtype : 'toolbar',
                flex  : 1,
                dock  : 'bottom',
                items: [{
                xtype: 'toolbar',
                        dock: 'bottom',
                        height: 40,
                        width: '100%',
                        items: [{
                        xtype: 'tbfill'
                        }, {
                        xtype: 'label',
                                iconCls: 'save',
                                name: 'btnGuardar',
                                x:100,
                                y:10,
                                text: '(*)Dato Obligatorio',
                                disabled: false,
                                //formBind: true,
                                scope: this,
                        }, {
                        xtype: 'button',
                                iconCls: 'save',
                                name: 'btnGuardar',
                                // itemId: 'addAvance', 
                                text: 'Guardar',
                                disabled: false,
                                //formBind: true,
                                scope: this,
                        }, {
                        xtype: 'button',
                                iconCls: 'icon-limpiar',
                                name: 'btnLimpiar',
                                text: 'Limpiar'
                        }

                        ]
                }]
        }]
        }
});