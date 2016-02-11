Ext.define('myapp.controller.actividad.ListaActividadController', {
    extend: 'Ext.app.Controller',
    views: ['actividad.ListaActividad',
             'actividad.WinPlanEvento'
             
            ],
     requires: [
        'myapp.util.Util'
        
    ],
   
    refs: [
           {
              ref: 'ListaActividad',
              selector: 'listaActividad'
             },
              {
              ref: 'ListaPlanEvento',
              selector: 'listaPlanEvento'
             },
             {
              ref: 'Header',
              selector: 'appheader'
             },
             
            
           ],
    
    init: function(application) {
        this.control({
            "listaActividad":{
                itemdblclick: this.onClickVerPlan
            },
            "winActividad checkbox[name=cbfDepende]":{
                selection: this.cargarActividad
            }
        }); 
    },   

   



 onClickVerPlan: function (record, item, index, e, eOpts ){
    
    var win = Ext.create('myapp.view.actividad.WinPlanEvento'); 
    var header = this.getHeader();  
    idlogueado=header.down('textfield[name=txtidusuario]').getValue();
      newGrid=this.getListaPlanEvento();
      store= newGrid.getStore();      
      store.proxy.extraParams.id=item.data.idEvento;
      store.load();
       newGrid.down("label[name=lblIdEvento]").setText(item.data.idEvento);
      newGrid.down("label[name=lblEvento]").setText(item.data.evento);
      win.setTitle("Plan de Accion para el Evento: "+ item.data.evento);
      if (idlogueado!=item.data.idencargado)
      {
          win.down('button[name=btnNuevoPlan]').setVisible(false);
          win.down('button[name=btnEditarPlan]').setVisible(false);
          win.down('button[name=btnCancelarPlan]').setVisible(false);
          
      }
     win.show();
      
  },
   onClickVerPlan2: function (record, item, index, e, eOpts ){
    
    var win = Ext.create('myapp.view.actividad.WinPlanEvento'); 
          
     newGrid=this.getListaPlanEvento();
      store= newGrid.getStore();      
      store.proxy.extraParams.id=item.data.idEvento;
      store.load();
      newGrid.down("label[name=lblIdEvento]").setText(item.data.idEvento);
      win.setTitle("Plan de Accion para el Evento: "+ item.data.evento);
      win.show();
      
  }
  
  
  
});



