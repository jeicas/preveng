Ext.define('myapp.view.actividad.WinAsignarResponsableActividad', {
extend: 'Ext.window.Window',
  alias: 'widget.winAsignarResponsableActividad',
  itemId: 'winAsignarResponsableActividad',
  title:'Plan de Accion',
  height: 550,
  width: 750,
  modal:true,
  requires: [
   'myapp.view.actividad.ListaAsignarResponsableActividad'
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
    return [{
      xtype: 'listaAsignarResponsableActividad',
    }]
  },
  buildDockedItems : function(){
    return []
  }
});