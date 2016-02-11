Ext.define('myapp.view.actividad.WinAsignarEncargado', {
extend: 'Ext.window.Window',
  alias: 'widget.winAsignarEncargado',
  itemId: 'winAsignarEncargado',
  title:'Plan de Accion',
  height: 550,
  width: 750,
  modal:true,
  requires: [
   'myapp.view.actividad.ListaAsignarUsuarioEncargado'
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
      xtype: 'listaAsignarUsuarioEncargado',
    }]
  },
  buildDockedItems : function(){
    return []
  }
});