Ext.define('myapp.view.seguridad.WinListaCalificacion', {
extend: 'Ext.window.Window',
  alias: 'widget.winListaCalificacion',
  itemId: 'winListaCalificacion',
  title:'Configurar Calificacion',
  height: 450,
  width: 550,
  modal:true,
  requires: [
   'myapp.view.seguridad.ListaCalificacionEditar'
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
      xtype: 'listaCalificacionEditar',
    }]
  },
  buildDockedItems : function(){
    return []
  }
});