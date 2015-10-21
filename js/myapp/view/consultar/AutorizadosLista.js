Ext.define('myapp.view.consultar.AutorizadosLista', {
	extend: 'Ext.grid.Panel', 
	alias: 'widget.autorizadosLista',
	itemId: 'autorizadosLista',
	requires: [
        'Ext.selection.CellModel', 
        'Ext.selection.CheckboxModel',
        'Ext.ux.ajax.SimManager',
        'Ext.ux.grid.FiltersFeature',
        'Ext.grid.column.Action'
    ],
    features    : [{
        ftype: 'filters',
        local: true
	},{
    	id: 'group',
    	ftype: 'groupingsummary',
    	//groupHeaderTpl:'{name}',
    	groupHeaderTpl:'<font size=2><font size=2>{name}</font>',
    	hideGroupedHeader: true,
    	enableGroupingMenu: false
    }],

    viewConfig: {},
	store: Ext.create('myapp.store.empleado.EmpleadosAutorizadosGrid'),
	selType: 'checkboxmodel',	
	emptyText   : 'No hay datos registrados',
	columnLines: true,
	initComponent : function(){
	    var me = this;
	    me.columns= me.buildColumns();
	    me.dockedItems = me.buildDockedItems();
	    me.callParent();
	 },
	 
	buildColumns: function(){
		return [{ 
			dataIndex: 'id',
			flex: 0.2,
			text: 'ID',
			hidden: true,
			items    : {
				xtype: 'textfield',
				flex : 1,
				margin: 2,
				enableKeyEvents: true,
				listeners: {
				    keyup: function() {
			           	var store = this.up('grid').store;
			           	store.clearFilter();
			            if (this.value) {
		                   	store.filter({
		                        property     : 'id',
		                        value         : this.value,
		                        anyMatch      : true,
		                        caseSensitive : false
		                    });
			            }
				    },
				    buffer: 500
				}
			}
		},{
			text:'Foto',
			dataIndex:'foto',
			flex: 0.3,
			renderer: function(value, metadata, record){
				return '<img width="50" height="50" src="../../empleados/_DSC'+ value +'">';
			}
		},{ 
			dataIndex: 'nacionalidad',
			flex: 0.1,
			text: 'Nac.',
			items    : {
				xtype: 'textfield',
				flex : 1,
				margin: 2,
				enableKeyEvents: true,
				listeners: {
				    keyup: function() {
			           	var store = this.up('grid').store;
			           	store.clearFilter();
			            if (this.value) {
		                   	store.filter({
		                        property     : 'nacionalidad',
		                        value         : this.value,
		                        anyMatch      : true,
		                        caseSensitive : false
		                    });
			            }
				    },
				    buffer: 500
				}
			}
		},{ 
			dataIndex: 'cedula',
			flex: 0.3,
			text: 'Cédula',
			items    : {
				xtype: 'textfield',
				flex : 1,
				margin: 2,
				enableKeyEvents: true,
				listeners: {
				    keyup: function() {
			           	var store = this.up('grid').store;
			           	store.clearFilter();
			            if (this.value) {
		                   	store.filter({
		                        property     : 'cedula',
		                        value         : this.value,
		                        anyMatch      : true,
		                        caseSensitive : false
		                    });
			            }
				    },
				    buffer: 500
				}
			}
		},{
			flex: 1,
			dataIndex: 'nombrecompleto',
			text: 'Nombre y apellido',
			items    : {
				xtype: 'textfield',
				flex : 1,
				margin: 2,
				enableKeyEvents: true,
				listeners: {
				    keyup: function() {
			           	var store = this.up('grid').store;
			           	store.clearFilter();
			            if (this.value) {
		                   	store.filter({
		                        property     : 'nombrecompleto',
		                        value         : this.value,
		                        anyMatch      : true,
		                        caseSensitive : false
		                    });
			            }
				    },
				    buffer: 500
				}
			}
		},{
			flex: 0.35,
			dataIndex: 'fechaautorizacion',
			text: 'Fecha',
			items    : {
				xtype: 'textfield',
				flex : 1,
				margin: 2,
				enableKeyEvents: true,
				listeners: {
				    keyup: function() {
			           	var store = this.up('grid').store;
			           	store.clearFilter();
			            if (this.value) {
		                   	store.filter({
		                        property     : 'fechaautorizacion',
		                        value         : this.value,
		                        anyMatch      : true,
		                        caseSensitive : false
		                    });
			            }
				    },
				    buffer: 500
				}
			}
		},{
			flex: 0.4,
			dataIndex: 'tipoautorizacion',
			text: 'Tipo',
			renderer: function(v){ return ('<SPAN class="ajustar-texto-grid">'+v+'</SPAN>')},
			items    : {
				xtype: 'textfield',
				flex : 1,
				margin: 2,
				enableKeyEvents: true,
				listeners: {
				    keyup: function() {
			           	var store = this.up('grid').store;
			           	store.clearFilter();
			            if (this.value) {
		                   	store.filter({
		                        property     : 'tipoautorizacion',
		                        value         : this.value,
		                        anyMatch      : true,
		                        caseSensitive : false
		                    });
			            }
				    },
				    buffer: 500
				}
			}
		},{
			flex: 0.4,
			text: 'Entrada',
			renderer: function(v){ return ('<SPAN class="ajustar-texto-grid">'+v+'</SPAN>')},
			dataIndex: 'horaentrada',
			items    : {
				xtype: 'textfield',
				flex : 1,
				margin: 2,
				enableKeyEvents: true,
				listeners: {
				    keyup: function() {
			           	var store = this.up('grid').store;
			           	store.clearFilter();
			            if (this.value) {
		                   	store.filter({
		                        property     : 'horaentrada',
		                        value         : this.value,
		                        anyMatch      : true,
		                        caseSensitive : false
		                    });
			            }
				    },
				    buffer: 500
				}
			}
		},{ 
			flex: 0.4,
			dataIndex: 'horasalida',
			renderer: function(v){ return ('<SPAN class="ajustar-texto-grid">'+v+'</SPAN>')},
			text: 'Salida',
			items    : {
				xtype: 'textfield',
				flex : 1,
				margin: 2,
				enableKeyEvents: true,
				listeners: {
				    keyup: function() {
			           	var store = this.up('grid').store;
			           	store.clearFilter();
			            if (this.value) {
		                   	store.filter({
		                        property     : 'horasalida',
		                        value         : this.value,
		                        anyMatch      : true,
		                        caseSensitive : false
		                    });
			            }
				    },
				    buffer: 500
				}
			}
		},{
	        xtype: 'actioncolumn',
	        flex: 0.1,
	        sortable: false,
	        menuDisabled: true,
	        items: [{
	            icon: '../../imagen/btn/accept.png',
	            tooltip: 'Procesar',
	            scope: this
	        }]
	    }]
	},
	buildDockedItems : function(){
		return [{
			xtype:'pagingtoolbar',
			dock:'bottom',
			store:this.store,
			displayInfo:true,
			items: [{    
			    xtype: 'tbfill'
		    },{ 
		    	xtype: 'button',
                id      :'guardarEvento',
    			text    : 'Procesar seleccionados',
    			iconCls :'aceptar',
             }]
		}];
	}
});