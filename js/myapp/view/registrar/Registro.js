Ext.define('myapp.view.registrar.Registro', {
	extend: 'Ext.window.Window',
	alias: 'widget.registro',
	height: 360,
	width: 655,
	modal:true,
	draggable:false,
	requires: ['myapp.util.Util'],
	resizable:false,
	layout: {
		type: 'fit'
	},
	title: 'Registro Usuario',
	initComponent: function() {
    var me = this;
    me.items = me.buildItem();
    me.dockedItems = me.buildDockedItems();
    me.callParent();
  	},
	buildItem : function(){
        return [{   
			xtype: 'form',
			bodyPadding: 5,
			layout: {
				type: 'hbox', 
				align: 'stretch'
				},
			items:
			[{
				xtype: 'fieldset',
				flex: 2,
				title: 'Información del Usuario',
				defaults: {
					anchor: '90%',
					xtype: 'textfield',
					allowBlank: false,
					labelWidth: 70
					},
				items: [{
			         xtype: 'container',
	                layout: 'hbox',
			    	
			    	items: [{
	                    xtype: 'combobox',
	                    editable: false,  
	                    name: 'nacionalidad',
	                    editable: false, 
	                    fieldLabel: 'Cedula', 
	                    labelWidth: 70,
	                    width: 120,
	                    value:'V',
	                    margins:'0 5 5 0',
	                    selecOnFocus: true,
	                    store: Ext.create('myapp.store.usuario.Nacionalidad'),
	                    valueField: 'nombre',
	                    displayField: 'nombre', 
	                    queryMode: 'local',
	                    allowBlank: false, 
	                    forceSelection: true,
	                    triggerAction: 'all',           
	                    editable:false
	                },{
	                    xtype: 'textfield',
	                    labelWidth: 100,
	                    maskRe: /[0-9]/,
	                    name: 'cedula',
	                    width:245,
	                    minLength:6,
	                    maxLength:8,
	                    allowBlank: false
	                },{
		              xtype   : 'button',
		              iconCls : 'icon-buscar',
		              tooltip :'Buscar empleado',
		              itemId      :'buscar',

		            }]}, {
				        fieldLabel: 'Usuario',
				        name: 'usuario',
				        blankText:'Campo obligatorio.. '
				    },{
				        xtype: 'combobox',
				        labelWidth: 70,
				        fieldLabel: 'Tipousuario',
				        name: 'tipousuario',
				        displayField: 'nombre',
				        valueField: 'id',
				        queryMode: 'local',
				        store: 'usuario.Tipousuario',
				        lazyRender: true,
						selectOnFocus: true,    
						forceSelection: true
				    },{
				        xtype: 'hiddenfield',
				        fieldLabel: 'Label',
				        name: 'id'
				    },{
				        fieldLabel: 'Nombre',
				        maxLength: 70,
				        name: 'nombre',
				        blankText:'Campo obligatorio.. ',
				        vtype:'letra'
				    },{
				        fieldLabel: 'Apellido',
				        maxLength: 70,
				        name: 'apellido',
				        blankText:'Campo obligatorio.. ',
				        vtype:'letra'
				        },{
				        fieldLabel: 'foto',
				        maxLength: 70,
				        name: 'foto',
				        allowBlank: true,
				        hidden: true
				    },{
				        xtype: 'combobox',
				        fieldLabel: 'Status',
				        name: 'status',
				        displayField: 'nombre',
				        valueField: 'nombre',
				        queryMode: 'local',
				       	store: Ext.create('myapp.store.usuario.Status'),
				        selectOnFocus: true,    
						forceSelection: true
				    }]	
			},{
	            xtype: 'fieldset',
	            title: 'Foto',
	            width: 170,
	                items: [{
	                    xtype: 'image',
	                    height: 150,
	                    width: 150,
	                    src: ''
	                }]
	        }]
		}]
	},
	buildDockedItems : function(){
    	return [{
	        xtype: 'toolbar',
	        flex: 1,
	        dock: 'bottom',
	        ui: 'footer',
	        layout: {
	            pack: 'end',
	            type: 'hbox'
	        },
	        items: [{
	            xtype: 'button',
	            text: 'Cancelar',
	            itemId: 'cancel',
	            iconCls: 'cancel'
	        },{
	            xtype: 'button',
	            text: 'Guardar',
	           	itemId: 'save',
	           	name:'save',
	            iconCls: 'save'
	        }]
	    }]
	},  
});

