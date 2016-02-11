Ext.define('myapp.view.avance.WinAsignarUsuarioAv', {
extend: 'Ext.window.Window',
  alias: 'widget.winAsignarUsuarioAv',
  itemId: 'winAsignarUsuarioAv',
  title:'Usuarios',
  height: 510,
  width: 900,
  modal:true,
  requires: [
   'myapp.view.avance.ListaAsignarUsuarioAv'
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
      xtype: 'listaAsignarUsuarioAv',
    }]
  },
  buildDockedItems : function(){
    return [{
      xtype : 'toolbar',
      flex  : 1,
      dock  : 'bottom',
      items: [  
      ]
    }]
  }
});




      