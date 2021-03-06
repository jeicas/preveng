Ext.define('myapp.controller.actividad.ListaPlanEventoAsignarEjecutorController', {
    extend: 'Ext.app.Controller',
    views: ['actividad.ListaPlanEventoAsignarEjecutor',
        'actividad.ListaEmpleadoPlan',
        'avance.WinAsignarUsuarioAv'
    ],
    requires: [
        'myapp.util.Util'
    ],
    refs: [
        {
            ref: 'ListaPlanEventoAsignarEjecutor',
            selector: 'listaPlanEventoAsignarEjecutor'
        },
        {
            ref: 'ListaEmpleadoPlan',
            selector: 'listaEmpleadoPlan'
        },
        {
            ref: 'WinAsignarUsuarioAv',
            selector: 'winAsignarUsuarioAv'
        },
        {
            ref: 'ListaAsignarUsuarioAv',
            selector: 'listaAsignarUsuarioAv'
        }
    ],
    init: function (application) {
        this.control({
            "listaPlanEventoAsignarEjecutor": {
                itemdblclick: this.onClickNuevaAsignacion
            },
            "listaEmpleadoPlan button[name=btnAsignarEmpleado]": {
                click: this.onClickAsignarEmpleado
            },
            "listaAsignarUsuarioAv button[name=btnGuardar]": {
                click: this.onClickGuardarEjecutores
            }

        });
    },
    onClickNuevaAsignacion: function (record, item, index, e, eOpts) {
        var win = Ext.create('myapp.view.actividad.WinAsignarEjecutorAPlan');
        newGrid = this.getListaEmpleadoPlan();
        if (item.data.actividad != 'no tiene actividades registrado') {
            Ext.Ajax.request({//AQUI ENVIO LA DATA 
                url: BASE_URL + 'avance/avance/buscarEjecutor',
                method: 'POST',
                params: {
                    id: item.data.idAct
                },
                success: function (result, request) {
                    result = Ext.JSON.decode(result.responseText);
                    if (result.cuanto == 0) {

                        if (item.data.estatus != 'Completado')
                        {
                            store = newGrid.getStore();
                            store.proxy.extraParams.id = item.data.idAct;
                            store.load();
                            newGrid.down("label[name=lblIdActividad]").setText(item.data.idAct);
                            newGrid.down("label[name=lblActividad]").setText(item.data.actividad);
                            newGrid.down("label[name=lblEvento]").setText(item.data.evento);
                            win.setTitle("Asignar Empleados al plan de accion: " + item.data.actividad);
                            win.show();
                        }
                        Ext.MessageBox.show({title: 'Mensaje', msg: "No tiene Ejecutores registrados", buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                    }
                    else {

                        if (item.data.estatus == 'Sin Iniciar' || item.data.estatus == 'En Ejecución' || item.data.estatus == 'En Espera')
                        {
                            store = newGrid.getStore();
                            store.proxy.extraParams.id = item.data.idAct;
                            store.load();
                            newGrid.down("label[name=lblIdActividad]").setText(item.data.idAct);
                            newGrid.down("label[name=lblActividad]").setText(item.data.actividad);
                            newGrid.down("label[name=lblEvento]").setText(item.data.evento);
                            win.setTitle("Asignar Empleados al plan de accion: " + item.data.actividad);
                            win.show();
                        } else {

                            store = newGrid.getStore();
                            store.proxy.extraParams.id = item.data.idAct;
                            store.load();
                            newGrid.down("button[name=btnAsignarEmpleado]").setVisible(false);
                            newGrid.down("label[name=lblIdActividad]").setText(item.data.idAct);
                            newGrid.down("label[name=lblActividad]").setText(item.data.actividad);
                            newGrid.down("label[name=lblEvento]").setText(item.data.evento);
                            win.setTitle("Asignar Empleados al plan de accion: " + item.data.actividad);
                            win.show();
                        }
                    }


                },
                failure: function (form, action) {
                    var result = action.result;

                    Ext.MessageBox.show({title: 'Alerta', msg: "Ha ocurrido un error. Por vuelva a intentarlo, si el problema persiste comuniquese con el administrador", buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});

                }
            });

        }


    }, // fin de la function 

    onClickAsignarEmpleado: function (button, e, options) {
        var win = Ext.create('myapp.view.avance.WinAsignarUsuarioAv');
        win.setTitle("Asignar Nuevo Empleado");
        win.show();
    }, // fin de la function


    onClickGuardarEjecutores: function (button, e, options) {

        var grid1 = this.getListaEmpleadoPlan();
        var gridUsu = this.getListaAsignarUsuarioAv();
        var win = this.getWinAsignarUsuarioAv();

        records = gridUsu.getSelectionModel().getSelection();
        var arregloGrid = [];
        Ext.each(records, function (record) {
            arregloGrid.push(Ext.apply(record.data));
        });
        
        arregloItems = Ext.encode(arregloGrid);
        if (records[0]) {
            store = grid1.getStore();
            console.log(store);
            if (store.data.items.length == 0) {
                encontrado = false;
            }
          
            for (i = 0; i < store.data.items.length; i++) {
                if (records[0].get('idEmpl') == store.data.items[i].data['idEmpleado'])
                {
                    encontrado = true;
                    i = store.data.items.length + 1;
                } else {
                    encontrado = false;
                }
            }
            if (!encontrado) {
                var loadingMask = new Ext.LoadMask(Ext.getBody(), {msg: "Guardando por Favor espere..."});
                loadingMask.show();
                Ext.Ajax.request({
                    url: BASE_URL + 'avance/avance/asignarEmpleado',
                    method: 'POST',
                    params: {
                        records: arregloItems,
                        activ: grid1.down("label[name=lblIdActividad]").getEl().dom.textContent,
                        tactiv: grid1.down("label[name=lblActividad]").getEl().dom.textContent,
                        evento: grid1.down("label[name=lblEvento]").getEl().dom.textContent,
                    },
                    success: function (result, request) {
                        data = Ext.JSON.decode(result.responseText);

                        if (data.success) {
                            Ext.MessageBox.show({title: 'Mensaje', msg: data.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                            grid1.getStore().load();
                            grid1.getView().refresh();
                            win.close();
                            loadingMask.hide();
                        }
                        else {
                            Ext.MessageBox.show({title: 'Alerta', msg: data.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                            // myapp.util.Util.showErrorMsg(result.msg);
                        }
                    },
                    failure: function (result, request) {
                        var result = Ext.JSON.decode(result.responseText);
                        loadingMask.hide();
                        Ext.MessageBox.show({title: 'Alerta', msg: data.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                    }
                });
            } else {
                Ext.MessageBox.show({title: 'Informaci&oacute;n',
                    msg: 'Este empleado ya se encuentra asignado a este plan',
                    buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
            }


        } else {
            Ext.MessageBox.show({title: 'Informaci&oacute;n',
                msg: 'Debe seleccionar un Empleado',
                buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
        }
    }, // fin de la function


});