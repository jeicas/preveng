Ext.define('myapp.view.descripcion.WinDescripcionLineamiento', {
extend: 'Ext.window.Window',
  alias: 'widget.winDescripcionLineamiento',
  itemId: 'winDescripcionLineamiento',
  title:'Descripción',
  height: '67%',
  width: '65%',
  modal:true,
  requires: [
    
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
      xtype: 'container',
            height: '100%',
            width: '100%',
            layout: 'vbox',
            items: [
                  {
                        xtype: 'label',
                        width: 400,
                        text:'',
                        name:'lblTitulo'
                    },
                    {
                        xtype: 'textareafield',
                         margin:'10 0 0 10',
                        width:'95%',
                        height: 250,
                        allowBlank :false,
                        fieldLabel: 'Descripción:',
                        name:'txtDescripcion'
                    }, 
                       {
                        xtype: 'textfield',
                        width: '30%',
                        hidden: true,
                        fieldLabel: 'Descripción:',
                        name:'txtEvento'
                    }
        ]// fin del contenedor
    }]
  },
  buildDockedItems : function(){
    return [{
      xtype : 'toolbar',
      flex  : 1,
      dock  : 'bottom',
      items: [
          {
            xtype : 'tbfill'
          },
          {
            xtype   : 'button',
            iconCls :'save',
            name    :'btnGuardar',
           // itemId: 'addAvance', 
            text    : 'Guardar',
            disabled:false,
            //formBind: true,
            scope   : this,


          },
          {
            xtype   : 'button',
            iconCls :'icon-limpiar',
            name      :'btnLimpiar',
            text    : 'Limpiar'
          }
      ]
    }]
  }
});