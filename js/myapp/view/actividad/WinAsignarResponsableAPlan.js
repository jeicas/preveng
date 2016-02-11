Ext.define('myapp.view.actividad.WinAsignarResponsableAPlan', {
extend: 'Ext.window.Window',
  alias: 'widget.winAsignarResponsableAPlan',
  itemId: 'winAsignarResponsableAPlan',
  height: 450,
  width: 490,
  modal:true,
  requires: [
   'myapp.view.actividad.ListaResponsablePlan'
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
      xtype: 'listaResponsablePlan',
    }]
  },
  buildDockedItems : function(){
    return []
  }
});