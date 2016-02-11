Ext.define('myapp.controller.seguridad.CalificacionController', {
    extend: 'Ext.app.Controller',
    views: ['seguridad.GridCalificacion',
    ],
    requires: [
        'myapp.util.Util'

    ],
    refs: [
        {
            ref: 'GridCalificacion',
            selector: 'gridCalificacion'
        },
        {
            ref: 'WinListaCalificacion',
            selector: 'winListaCalificacion'
        },
        {
            ref: 'ListaCalificacionEditar',
            selector: 'listaCalificacionEditar'
        },
    ],
    init: function (application) {
        this.control({
            "gridCalificacion button[name=btnNuevaConfiguracion]": {
                click: this.onClickConfigurar
            },
            "listaCalificacionEditar button[name=btnAgregar]": {
                click: this.agregarItem
            },
            "listaCalificacionEditar button[name=btnGuardar]": {
                click: this.onClickGuardarCalificacion
            },
            "listaCalificacionEditar actioncolumn[name=eliminarItem]": {
                click: this.onClickEliminarFila
            },
            
        });
    },
    onClickConfigurar: function (a, e, eOpts) {
        win = Ext.create('myapp.view.seguridad.WinListaCalificacion');
        win.show();
    },
    agregarItem: function (a, e, eOpts) {//function (sm, selection) {//function (a, e, eOpts) {
        grid4 = this.getListaCalificacionEditar();
        positionCEP = grid4.getStore().getCount();
        store = this.getListaCalificacionEditar().getStore();
        var plugin = grid4.getPlugin('rowediting');
        var r1 = new Ext.create('myapp.model.store.seguridad.calificacionModel', {
        });
        store.insert(positionCEP, r1);
        plugin.startEdit(positionCEP - 1, 0);
        grid4.getView().refresh(true);
    },
    onClickGuardarCalificacion: function (button, e, options) {

        var grid1 = this.getGridCalificacion();
        var gridCalif = this.getListaCalificacionEditar();
        var win = this.getWinListaCalificacion();
        store = gridCalif.getStore();
        modified = store.data.items;
        nitems = store.getCount();
        j = 0;
        if (nitems > 0) {
            var arregloGrid = [];
            Ext.each(modified, function (record) {
                arregloGrid.push(Ext.apply(record.data));
            });
            arregloGrid = Ext.encode(arregloGrid);
        }

        for (i = 0; i < nitems; i++)
        {

            if (modified[i].data.desde >= modified[i].data.hasta) {//modified[i].data.desde=>modified[i].data.hasta){
                j = i;
                i = nitems + 1;
                caso = 1;
            } else {
                if (i > 0) {
                    if (modified[i - 1].data.hasta >= modified[i].data.desde) {
                        j = i;
                        i = nitems + 1;
                        caso = 2;
                    }
                    else
                        caso = 3;
                } else
                    caso = 3;

            }


        }


        switch (caso) {
            case 1:
                {
                    rango = false;
                    Ext.MessageBox.show({title: 'Alerta', msg: "El rango inferior no puede ser mayor o igual al rango superior <br> Por favor verifique los rangos en el item: " + modified[j].data.descripcion, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});

                }

                break;
            case 2:
                {
                    rango = false;
                    Ext.MessageBox.show({title: 'Alerta', msg: "El rango inferior no puede ser menor o igual al rango superior del item anterior<br>Por favor verifique los rangos en el item: " + modified[j].data.descripcion, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                }

                break;
            default:
                rango = true
                break;
        }
        if (rango) {
            var loadingMask = new Ext.LoadMask(Ext.getBody(), {msg: "Guardando por Favor espere..."});
            loadingMask.show();
            Ext.Ajax.request({
                url: BASE_URL + 'seguridad/calificacion/guardarCalificacion',
                method: 'POST',
                params: {
                    records: arregloGrid,
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
        }




    },
    onClickEliminarFila: function (grid, record, rowIndex) {
    
      grid = this.getListaCalificacionEditar();
      store = grid.getStore();
      record = store.getAt(rowIndex);
      grid.getView().refresh(true);
      store.remove(record);
                       
    }
});



