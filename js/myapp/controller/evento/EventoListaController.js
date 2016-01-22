var nuevo = false;
var nuevoS = false;
var nuevoTE = false;
var nuevoAg = false;
var nuevoAl = false;
var nuevoLin = false;
Ext.define('myapp.controller.evento.EventoListaController', {
    extend: 'Ext.app.Controller',
    views: ['evento.ListaEventos',
        'evento.WinEvento',
        'evento.Evento',
        'observacion.WinObservacionEvento',
        'maestroValor.WinMaestroTipoEvento',
        'maestroValor.WinMaestroAlcance',
        'maestroNombre.WinMaestroSector',
        'maestroNombre.WinMaestroAgente',
        'reportes.GraficoNivelEjecucion',
        'Viewport'
    ],
    requires: [
        'myapp.util.Util',
    ],
    refs: [
        {
            ref: 'ListaEventos',
            selector: 'listaEventos'
        },
        {
            ref: 'Evento',
            selector: 'evento'
        },
        {
            ref: 'WinEvento',
            selector: 'winEvento'
        },
        {
            ref: 'WinObservacionEvento',
            selector: 'winObservacionEvento'
        },
        {
            ref: 'WinMaestroAgente',
            selector: 'winMaestroAgente'
        },
        {
            ref: 'WinMaestroSector',
            selector: 'winMaestroSector'
        },
        {
            ref: 'WinMaestroTipoEvento',
            selector: 'winMaestroTipoEvento'
        },
        {
            ref: 'WinMaestroAlcance',
            selector: 'winMaestroAlcance'
        },
        {
            ref: 'GraficoNivelEjecucion',
            selector: 'GraficoNivelEjecucion'
        }, {
            ref: 'Viewport',
            selector: 'mainviewport'},
        //Lineamientos
        {
            ref: 'WinDescripcionLineamiento',
            selector: 'winDescripcionLineamiento'
        },
        {
            ref: 'ListaAsignarUsuario',
            selector: 'listaAsignarUsuario'
        },
        //Comisionado
        {
            ref: 'WinAsignarUsuario',
            selector: 'winAsignarUsuario'
        },
        //Reincidencia
        {
            ref: 'WinReincidencia',
            selector: 'winReincidencia'
        },
        {
            ref: 'WinAnexo',
            selector: 'winAnexo'
        },
    ],
    init: function (application) {
        this.control({
            "listaEventos button[name=btnNuevo]": {
                click: this.onClickNuevoEvento
            },
            //eventos del contenedor de la derecha
            "mainviewport button[name=btnNuevoLineamiento]": {
                click: this.onClickNuevoLineamiento
            },
            "mainviewport button[name=btnEditarLineamiento]": {
                click: this.onClickEditarLineamiento
            },
            "mainviewport button[name=btnEliminarLineamiento]": {
                click: this.onClickEliminarLineamiento
            },
            "winDescripcionLineamiento button[name=btnGuardar]": {
                click: this.onClickGuardarLineamiento
            },
            "winDescripcionLineamiento button[name=btnLimpiar]": {
                click: this.onClickLimpiarLineamiento
            },
            //==============Comisionados=======================
            "mainviewport button[name=btnNuevoComisionado]": {
                click: this.onClickNuevoComisionado
            },
            "mainviewport button[name=btnEliminarComisionado]": {
                click: this.onClickEliminarComisionado
            },
            "listaAsignarUsuario button[name=btnGuardar]": {
                click: this.onClickGuardarComisionado
            },
            //========reincidencia======================

            "mainviewport button[name=btnEliminarReincidencia]": {
                click: this.onClickEliminarReincidencia
            },
            "mainviewport button[name=btnNuevoReincidencia]": {
                click: this.onClickNuevoReincidencia
            },
            "winReincidencia radiogroup[name=rdgAgregarAnexo]": {
                change: this.changeRadio
            },
            "winReincidencia button[name=btnGuardar]": {
                click: this.onClickGuardarReincidencia
            },
            "winReincidencia radiogroup[name=rdgTipoAnexo]": {
                change: this.changeTipoAnexo
            },
            //========================================
            /*"listaEventos": {
             itemclick: this.onClickVerResumen
             },*/
            "listaEventos actioncolumn[name=ver]": {
                click: this.onClickVerResumen
            },
            "listaEventos button[name=btnEditar]": {
                click: this.onClickEditarEvento
            },
            "listaEventos button[name=btnCancelar]": {
                click: this.onClickCancelarEvento
            },
            "listaEventos actioncolumn[name=cerrarEvento]": {
                click: this.onClickCerrarEvento
            },
            "listaEventos actioncolumn[name=resumenEvento]": {
                click: this.onClickResumenEvento
            },
            "winEvento button[name=btnGuardar]": {
                click: this.onClickGuardarEvento
            },
            "winEvento button[name=btnNuevoAgente]": {
                click: this.onClickNuevoAgente
            },
            "winEvento button[name=btnNuevoTipoEvento]": {
                click: this.onClickNuevoTipoEvento
            },
            "winEvento button[name=btnNuevoAlcance]": {
                click: this.onClickNuevoAlcance
            },
            "winEvento button[name=btnNuevoSector]": {
                click: this.onClickNuevoSector
            },
            "winEvento button[name=btnEditarAgente]": {
                click: this.onClickEditarAgente
            },
            "winEvento button[name=btnEditarTipoEvento]": {
                click: this.onClickEditarTipoEvento
            },
            "winEvento button[name=btnEditarAlcance]": {
                click: this.onClickEditarAlcance
            },
            "winEvento button[name=btnEditarSector]": {
                click: this.onClickEditarSector
            },
            "winObservacionEvento button[name=btnGuardar]": {
                click: this.onClickGuardarObservacion
            },
            "winMaestroAlcance button[name=btnGuardar]": {
                click: this.onClickGuardarAlcance
            },
            "winMaestroAgente button[name=btnGuardar]": {
                click: this.onClickGuardarAgente
            },
            "winMaestroSector button[name=btnGuardar]": {
                click: this.onClickGuardarSector
            },
            "winMaestroTipoEvento button[name=btnGuardar]": {
                click: this.onClickGuardarTipoEvento
            },
        });
    },
    //Funciones Botones Viewport east
    // ====================funciones de la ventana listaLineamientoPorEvento================
    onClickNuevoLineamiento: function (button, e, options) {
        nuevoLin = true;
        var grid = this.getListaEventos();
        record = grid.getSelectionModel().getSelection();
        win = Ext.create('myapp.view.descripcion.WinDescripcionLineamiento');
        win.setTitle("Nuevo Lineamiento");
        win.down('textfield[name=txtEvento]').setValue(record[0].get('idEv'));
        win.down('label[name=lblTitulo]').setText('Defina los Lineamientos para el evento: ' + record[0].get('titulo'));
        win.show();
    },
    onClickEditarLineamiento: function (button, e, options) {
        nuevoLin = false;
        viewP = this.getViewport();
        for (i = 0; i < viewP.items.length; i++) {
            if (viewP.items.items[i].name == 'regioneste')
            {
                val = viewP.items.items[i].setVisible(false);
                valor = val.down('gridpanel[name=gridLineamiento]');
                i = viewP.items.length + 1;
            }
        }
        grid = valor;
        record = grid.getSelectionModel().getSelection();

        if (record[0]) {
            var win = Ext.create('myapp.view.descripcion.WinDescripcionLineamiento');
            win.down('textfield[name=txtDescripcion]').setValue(record[0].get('descripcion'));
            win.setTitle("Actualizar Lineamiento");
            win.show();
        } else {
            Ext.MessageBox.show({title: 'Informaci&oacute;n',
                msg: 'Debe seleccionar el evento que desea Editar',
                buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
        }


    },
    onClickEliminarLineamiento: function (button, e, options) {

        viewP = this.getViewport();
        for (i = 0; i < viewP.items.length; i++) {
            if (viewP.items.items[i].name == 'regioneste')
            {
                val = viewP.items.items[i].setVisible(false);
                valor = val.down('gridpanel[name=gridLineamiento]');
                i = viewP.items.length + 1;
            }
        }
        grid = valor;
        record = grid.getSelectionModel().getSelection();
        if (record[0]) {
            Ext.Msg.show({
                title: 'Confirmar',
                msg: 'Esta seguro que desea Eliminar el Lineamiento?',
                buttons: Ext.Msg.YESNO,
                icon: Ext.Msg.QUESTION,
                fn: function (buttonId) {
                    if (buttonId == 'yes') {
                        Ext.Ajax.request({
                            url: BASE_URL + 'lineamiento/lineamiento/eliminarLineamiento',
                            method: 'POST',
                            params: {
                                lin: record[0].get('idLin')

                            },
                            success: function (result, request) {
                                data = Ext.JSON.decode(result.responseText);
                                if (data.success) {
                                    Ext.MessageBox.show({title: 'Mensaje', msg: data.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                                    grid.getView().refresh();
                                    grid.getStore().load();
                                }
                                else {
                                    Ext.MessageBox.show({title: 'Alerta', msg: data.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                                    // myapp.util.Util.showErrorMsg(result.msg);
                                }
                            },
                            failure: function (result, request) {
                                var result = Ext.JSON.decode(result.responseText);
                                loadingMask.hide();
                                Ext.MessageBox.show({title: 'Alerta', msg: "Ha ocurrido un error. Por vuelva a intentarlo, si el problema persiste comuniquese con el administrador", buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                            }
                        });
                    }
                }
            });
        } else {
            Ext.MessageBox.show({title: 'Informaci&oacute;n',
                msg: 'Debe seleccionar el lineamiento que desea eliminar',
                buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
        }
    }, // ====================funciones de la ventana WinDescripcion================

    onClickGuardarLineamiento: function (button, e, options) {

        viewP = this.getViewport();
        for (i = 0; i < viewP.items.length; i++) {

            if (viewP.items.items[i].name == 'regioneste')
            {
                val = viewP.items.items[i].setVisible(false);
                valor = val.down('gridpanel[name=gridLineamiento]');
                i = viewP.items.length + 1;
            }
        }
        grid2 = valor;
        winO = this.getWinDescripcionLineamiento();
        if (nuevoLin) {

            var loadingMask = new Ext.LoadMask(Ext.getBody(), {msg: "grabando..."});
            loadingMask.show();
            Ext.Ajax.request({//AQUI ENVIO LA DATA 
                url: BASE_URL + 'lineamiento/lineamiento/registrarLineamiento',
                method: 'POST',
                params: {
                    descripcion: winO.down("textfield[name=txtDescripcion]").getValue(),
                    idEvento: winO.down("textfield[name=txtEvento]").getValue(),
                },
                success: function (result, request) {
                    result = Ext.JSON.decode(result.responseText);
                    loadingMask.hide();
                    if (result.success) {
                        grid2.getView().refresh();
                        grid2.getStore().load();
                        winO.close();
                        Ext.MessageBox.show({title: 'Alerta', msg: result.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                    }
                    else {
                        Ext.MessageBox.show({title: 'Alerta', msg: result.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                        // myapp.util.Util.showErrorMsg(result.msg);
                    }
                },
                failure: function (form, action) {
                    var result = action.result;
                    loadingMask.hide();
                    Ext.MessageBox.show({title: 'Alerta', msg: "Ha ocurrido un error. Por vuelva a intentarlo, si el problema persiste comuniquese con el administrador", buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                }
            });
        }
        else {
            var loadingMask = new Ext.LoadMask(Ext.getBody(), {msg: "grabando..."});
            loadingMask.show();
            record = grid2.getSelectionModel().getSelection();
            console.log(record);
            Ext.Ajax.request({//AQUI ENVIO LA DATA 
                url: BASE_URL + 'lineamiento/lineamiento/actualizarLineamiento',
                method: 'POST',
                params: {
                    descripcion: winO.down("textfield[name=txtDescripcion]").getValue(),
                    idLineam: record[0].get('idLin')
                },
                success: function (result, request) {
                    result = Ext.JSON.decode(result.responseText);
                    loadingMask.hide();
                    if (result.success) {
                        grid2.getView().refresh();
                        grid2.getStore().load();
                        winO.close();
                        Ext.MessageBox.show({title: 'Alerta', msg: result.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                    }
                    else {
                        Ext.MessageBox.show({title: 'Alerta', msg: result.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                        // myapp.util.Util.showErrorMsg(result.msg);
                    }
                },
                failure: function (form, action) {
                    var result = action.result;
                    loadingMask.hide();
                    Ext.MessageBox.show({title: 'Alerta', msg: "Ha ocurrido un error. Por vuelva a intentarlo, si el problema persiste comuniquese con el administrador", buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                }
            });
        }

    },
    onClickLimpiarLineamiento: function (button, e, options) {
        win = this.getWinLineamiento();
    },
    //======================Funciones de Comisionado=======================================

    onClickNuevoComisionado: function (button, e, options) {
        win = Ext.create('myapp.view.evento.WinAsignarUsuario');
        win.setTitle("Nuevo Comisionado");
        win.show();
    },
    onClickEliminarComisionado: function (button, e, options) {

        viewP = this.getViewport();
        for (i = 0; i < viewP.items.length; i++) {
            if (viewP.items.items[i].name == 'regioneste')
            {
                val = viewP.items.items[i].setVisible(true);
                valor = val.down('gridpanel[name=gridComisionado]');
                i = viewP.items.length + 1;
            }
        }
        grid = valor;
        record = grid.getSelectionModel().getSelection();
        if (record[0]) {
            Ext.Msg.show({
                title: 'Confirmar',
                msg: 'Esta seguro que desea Eliminar el Comisionado ' + record[0].get('nombrecompleto') + '?',
                buttons: Ext.Msg.YESNO,
                icon: Ext.Msg.QUESTION,
                fn: function (buttonId) {
                    if (buttonId == 'yes') {
                        Ext.Ajax.request({
                            url: BASE_URL + 'comisionado/comisionado/eliminarComisionado',
                            method: 'POST',
                            params: {
                                idComi: record[0].get('idCom'),
                            },
                            success: function (result, request) {
                                data = Ext.JSON.decode(result.responseText);

                                if (data.success) {
                                    Ext.MessageBox.show({title: 'Mensaje', msg: data.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                                    grid.getView().refresh();
                                    grid.getStore().load();

                                }
                                else {
                                    Ext.MessageBox.show({title: 'Alerta', msg: data.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                                    // myapp.util.Util.showErrorMsg(result.msg);
                                }
                            },
                            failure: function (result, request) {
                                var result = Ext.JSON.decode(result.responseText);
                                loadingMask.hide();
                                Ext.MessageBox.show({title: 'Alerta', msg: "Ha ocurrido un error. Por vuelva a intentarlo, si el problema persiste comuniquese con el administrador", buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                            }
                        });
                    }
                }
            });

        } else {
            Ext.MessageBox.show({title: 'Informaci&oacute;n',
                msg: 'Debe seleccionar el comisionado que desea eliminar',
                buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
        }
    },
    onClickGuardarComisionado: function (button, e, options) {

        viewP = this.getViewport();
        for (i = 0; i < viewP.items.length; i++) {
            if (viewP.items.items[i].name == 'regioneste')
            {
                val = viewP.items.items[i].setVisible(true);
                valor = val.down('gridpanel[name=gridComisionado]');
                idEvento = val.down('textfield[name=idEvento]').getValue();
                i = viewP.items.length + 1;
            }
        }
        grid3 = valor;
        grid2 = this.getListaAsignarUsuario();
        winU = this.getWinAsignarUsuario();

        record1 = grid2.getSelectionModel().getSelection();
        if (record1 != '') {
            store = grid3.getStore();
            
            if (store.data.items.length==0){
                encontrado = false;
            }
            for (i = 0; i < store.data.items.length; i++) {
                if (record1[0].get('idEmpl') == store.data.items[i].data['idUs'])
                {
                    encontrado = true;
                    i = store.data.items.length + 1;
                } else {
                    encontrado = false;
                }
            }
            if (!encontrado) {
                var loadingMask = new Ext.LoadMask(Ext.getBody(), {msg: "grabando..."});
                loadingMask.show();
                Ext.Ajax.request({//AQUI ENVIO LA DATA 
                    url: BASE_URL + 'comisionado/comisionado/registrarComisionado',
                    method: 'POST',
                    params: {
                        idEv: idEvento,
                        idUs: record1[0].get('idEmpl')
                    },
                    success: function (result, request) {
                        result = Ext.JSON.decode(result.responseText);
                        loadingMask.hide();

                        if (result.success) {
                            grid3.getView().refresh();
                            grid3.getStore().load();
                            winU.close();
                            Ext.MessageBox.show({title: 'Alerta', msg: result.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});

                        }
                        else {
                            Ext.MessageBox.show({title: 'Alerta', msg: result.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                            // myapp.util.Util.showErrorMsg(result.msg);
                        }
                    },
                    failure: function (form, action) {
                        var result = action.result;
                        loadingMask.hide();
                        Ext.MessageBox.show({title: 'Alerta', msg: "Ha ocurrido un error. Por vuelva a intentarlo, si el problema persiste comuniquese con el administrador", buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});

                    }
                });
            }
            else {
                Ext.MessageBox.show({title: 'Alerta', msg: 'Este empleado ya es un comisionado del evento seleccionado', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
            }
        } else {
            Ext.MessageBox.show({title: 'Alerta', msg: 'Debe seleccionar un empleado', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
        }



    },
    //===================Funciones Reincidencias=============================================


    onClickNuevoReincidencia: function (button, e, options) {
        viewP = this.getViewport();
        for (i = 0; i < viewP.items.length; i++) {
            if (viewP.items.items[i].name == 'regioneste')
            {
                val = viewP.items.items[i].setVisible(true);
                idEvento = val.down('textfield[name=idEvento]').getValue();
                i = viewP.items.length + 1;
            }
        }

        win = Ext.create('myapp.view.evento.WinReincidencia');
        win.setTitle("Nueva Reincidencia");
        win.down('textfield[name=txtIdEvento]').setValue(idEvento);
        win.down('button[name=btnGuardar]').setVisible(false);
        win.down('fieldset[name=formAnexo]').setVisible(false);
        win.show();
    },
    onClickEliminarReincidencia: function (button, e, options) {
        viewP = this.getViewport();
        for (i = 0; i < viewP.items.length; i++) {
            if (viewP.items.items[i].name == 'regioneste')
            {
                val = viewP.items.items[i].setVisible(true);
                valor = val.down('gridpanel[name=gridReincidencia]');
                i = viewP.items.length + 1;
            }
        }
        grid = valor;
        record = grid.getSelectionModel().getSelection();

        if (record[0]) {
            Ext.Msg.show({
                title: 'Confirmar',
                msg: 'Esta seguro que desea Eliminar la reincidecia?',
                buttons: Ext.Msg.YESNO,
                icon: Ext.Msg.QUESTION,
                fn: function (buttonId) {
                    if (buttonId == 'yes') {
                        Ext.Ajax.request({
                            url: BASE_URL + 'reincidencia/reincidencia/eliminarReincidencia',
                            method: 'POST',
                            params: {
                                id: record[0].get('idRein'),
                            },
                            success: function (result, request) {
                                data = Ext.JSON.decode(result.responseText);

                                if (data.success) {
                                    Ext.MessageBox.show({title: 'Mensaje', msg: data.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                                    grid.getView().refresh();
                                    grid.getStore().load();

                                }
                                else {
                                    Ext.MessageBox.show({title: 'Alerta', msg: data.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                                    // myapp.util.Util.showErrorMsg(result.msg);
                                }
                            },
                            failure: function (result, request) {
                                var result = Ext.JSON.decode(result.responseText);
                                loadingMask.hide();
                                Ext.MessageBox.show({title: 'Alerta', msg: "Ha ocurrido un error. Por vuelva a intentarlo, si el problema persiste comuniquese con el administrador", buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                            }
                        });
                    }
                }
            });

        } else {
            Ext.MessageBox.show({title: 'Informaci&oacute;n',
                msg: 'Debe seleccionar la reincidencia que desea eliminar',
                buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
        }
    },
    changeRadio: function (grupo, cmp) {
        win = this.getWinReincidencia();

        if (cmp.seleccionAgregar == 1)
        {
            win.setHeight(450);
            win.down('button[name=btnGuardar]').setVisible(false);
            win.down('fieldset[name=formAnexo]').setVisible(true);
            win.down('textfield[name=txtDireccion]').setVisible(false);
            win.down('filefield[name=txtArchivo]').setVisible(false);

        }
        else {

            win.down('button[name=btnGuardar]').setVisible(true);
            win.down('fieldset[name=formAnexo]').setVisible(false);
            win.setHeight(370);
        }
    },
    onClickGuardarReincidencia: function (button, e, options) {

        win = this.getWinReincidencia();

        viewP = this.getViewport();
        for (i = 0; i < viewP.items.length; i++) {
            if (viewP.items.items[i].name == 'regioneste')
            {
                val = viewP.items.items[i].setVisible(true);
                valor = val.down('gridpanel[name=gridReincidencia]');
                i = viewP.items.length + 1;
            }
        }
        grid = valor;

        formulario = win.down('form[name=formReincidencia]').getForm();
        formulario.submit({//AQUI ENVIO LA DATA 
            url: BASE_URL + 'reincidencia/reincidencia/registrarReincidencia',
            method: 'POST',
            params: formulario.getValues(),
            success: function (form, action) {
                var result = action.result;

                if (result.success) {
                    Ext.MessageBox.show({title: 'Mensaje', msg: result.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                    grid.getView().refresh();
                    grid.getStore().load();
                    win.close();

                } else {

                    Ext.MessageBox.show({title: 'Mensaje', msg: result.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});

                }
            },
            failure: function (form, action) {

                Ext.MessageBox.show({title: 'Alerta', msg: 'Se ha detectado algun error', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
            }

        });



    },
    changeTipoAnexo: function (grupo, cmp) {
        win = this.getWinReincidencia();

        if (cmp.seleccion == 1)
        {

            win.down('button[name=btnGuardar]').setVisible(true);
            win.down('textfield[name=txtDireccion]').setVisible(true);
            win.down('filefield[name=txtArchivo]').setVisible(false);
            win.down('textfield[name=txtSeleccion]').setValue(cmp.seleccion);
        }
        else {
            win.down('button[name=btnGuardar]').setVisible(true);
            win.down('textfield[name=txtDireccion]').setVisible(false);
            win.down('textfield[name=txtArchivo]').setVisible(true);
            win.down('textfield[name=txtSeleccion]').setValue(cmp.seleccion);
        }
    },
    //==============Funciones de la Lista de Eventos=====================================
    onClickNuevoEvento: function (button, e, options) {
        nuevo = true;
        var win = Ext.create('myapp.view.evento.WinEvento');
        win.setTitle("Nuevo Evento");
        win.show();
    }, // fin de la function
    onClickVerResumen: function (grid, record, rowIndex) {

        var grid = this.getListaEventos();
        store = grid.getStore();
        var win = this.getViewport();
        rec = store.getAt(rowIndex);

        if (record != '') {

            for (i = 0; i < win.items.length; i++) {

                if (win.items.items[i].name == 'regioneste')
                {
                    win.items.items[i].setVisible(true);
                    win.items.items[i].setTitle('Resumen del evento ' + rec.get('titulo'));
                    win.items.items[i].down('textfield[name=idEvento]').setValue(rec.get('idEv'));
                    storeLineamiento = win.items.items[i].items.items[0].items.items[0].getStore();
                    storeComisionado = win.items.items[i].items.items[0].items.items[1].getStore();
                    storeReincidencia = win.items.items[i].items.items[0].items.items[2].getStore();
                    storeLineamiento.proxy.extraParams.id = rec.get('idEv');
                    storeLineamiento.load();
                    storeComisionado.proxy.extraParams.id = rec.get('idEv');
                    storeComisionado.load();
                    storeReincidencia.proxy.extraParams.id = rec.get('idEv');
                    storeReincidencia.load();

                    if (rec.get('estatus') == 'Completado' || rec.get('estatus') == 'Expirado')
                    {
                        win.items.items[i].down('button[name=btnNuevoLineamiento]').setVisible(false);
                        win.items.items[i].down('button[name=btnEditarLineamiento]').setVisible(false);
                        win.items.items[i].down('button[name=btnEliminarLineamiento]').setVisible(false);
                        win.items.items[i].down('button[name=btnNuevoComisionado]').setVisible(false);
                        win.items.items[i].down('button[name=btnEliminarComisionado]').setVisible(false);
                        win.items.items[i].down('button[name=btnNuevoReincidencia]').setVisible(false);
                        win.items.items[i].down('button[name=btnEliminarReincidencia]').setVisible(false);
                        
                    }
                    else {
                        win.items.items[i].down('button[name=btnNuevoLineamiento]').setVisible(true);
                        win.items.items[i].down('button[name=btnEditarLineamiento]').setVisible(true);
                        win.items.items[i].down('button[name=btnEliminarLineamiento]').setVisible(true);
                        win.items.items[i].down('button[name=btnNuevoComisionado]').setVisible(true);
                        win.items.items[i].down('button[name=btnEliminarComisionado]').setVisible(true);
                        win.items.items[i].down('button[name=btnNuevoReincidencia]').setVisible(true);
                        win.items.items[i].down('button[name=btnEliminarReincidencia]').setVisible(true);
                    }

                    i = win.items.length + 1;
                }
            }
        }
        else {
            for (i = 0; i < win.items.length; i++) {
                if (win.items.items[i].name == 'regioneste')
                {
                    win.items.items[i].setVisible(false);
                    i = win.items.length + 1;
                }
            }


        }


    },
    onClickResumenEvento: function (grid, record, rowIndex) {
        var grid = this.getListaEventos();
        store = grid.getStore();
        record = store.getAt(rowIndex);
        var win = this.getViewport();
        for (i = 0; i < win.items.length; i++) {

            if (win.items.items[i].name == 'regioneste')
            {
                win.items.items[i].setVisible(false);
                i = win.items.length + 1;
            }
        }
        var winE = Ext.create('myapp.view.evento.WinEventoCompleto');
        winE.setTitle("Resumen Evento " + record.get('titulo'));
        winE.down('textfield[name=titulo]').setValue(record.get('titulo'));
        winE.down('textareafield[name=descripcion]').setValue(record.get('descripcion'));
        winE.down('textfield[name=fecha]').setValue(record.get('fechaEvento'));
        winE.down('textfield[name=sector]').setValue(record.get('sector'));
        winE.down('textfield[name=alcance]').setValue(record.get('alcance'));
        winE.down('textfield[name=agente]').setValue(record.get('agente'));
        winE.down('textfield[name=tipoEvento]').setValue(record.get('tipoEvento'));
        winE.down('textfield[name=estatus]').setValue(record.get('estatus'));
        winE.down('textfield[name=observacion]').setValue(record.get('observacion'));
        // cargar las grid de Plan de accion  

        store3 = winE.down('gridpanel[name=gridPlanDeAccion]').getStore();
        store3.proxy.extraParams.id = record.get('idEv');
        store3.load();
        // carga la grafica 

        store4 = winE.down('GraficoNivelEjecucion').getStore();
        store4.proxy.extraParams.id = record.get('idEv');
        store4.load();
        store5 = winE.down('grid[name=gridCalcularNivel]').getStore();
        store5.proxy.extraParams.id = record.get('idEv');
        store5.load();
        winE.down('textfield[name=responsable]').setValue(record.get('nombrecompleto'));
        winE.show();
    }, // fin de la function


    onClickEditarEvento: function (button, e, options) {
        nuevo = false;
        var grid = this.getListaEventos();
        record = grid.getSelectionModel().getSelection();
        if (record[0]) {
            if (record[0].get('estatus') == 'Completado' || record[0].get('estatus') == 'Expirado' || record[0].get('estatus') == 'Cancelado') {
                Ext.MessageBox.show({title: 'Informaci&oacute;n',
                    msg: 'El evento no se puede editar porque está ' + record[0].get('estatus'),
                    buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
            } else {
                var win = Ext.create('myapp.view.evento.WinEvento');
                win.down('textfield[name=txtTitulo]').setValue(record[0].get('titulo'));
                win.down('textfield[name=txtDescripcion]').setValue(record[0].get('descripcion'));
                win.down('combobox[name=cmbAgente]').setValue(record[0].get('agente'));
                win.down('combobox[name=cmbAlcance]').setValue(record[0].get('alcance'));
                win.down('combobox[name=cmbSector]').setValue(record[0].get('sector'));
                win.down('combobox[name=cmbTipoEvento]').setValue(record[0].get('tipoEvento'));
                win.down('datefield[name=dtfFechaT]').setValue(record[0].get('fechaEvento'));
                win.down('datefield[name=dtfFechaPA]').setValue(record[0].get('fechaPreAviso'));
                win.down('numberfield[name=txtPresupuesto]').setValue(record[0].get('presupuesto'));
                win.setTitle("Actualizar Evento");
                win.show();
            }
        } else {
            Ext.MessageBox.show({title: 'Informaci&oacute;n',
                msg: 'Debe seleccionar el evento que desea Editar',
                buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
        }

    },
    onClickCancelarEvento: function (button, e, options) {

        var grid = this.getListaEventos();
        record = grid.getSelectionModel().getSelection();
        if (record[0]) {
            if (record[0].get('estatus') == 'Pendiente'
                    || record[0].get('estatus') == 'En Ejecución'
                    || record[0].get('estatus') == 'Sin Plan') {
                Ext.Msg.show({
                    title: 'Confirmar',
                    msg: 'Esta seguro que desea CANCELAR el Evento ' + record[0].get('titulo') + '?',
                    buttons: Ext.Msg.YESNO,
                    icon: Ext.Msg.QUESTION,
                    fn: function (buttonId) {
                        if (buttonId == 'yes') {
                            var win = Ext.create('myapp.view.observacion.WinObservacionEvento');
                            win.setTitle("Cancelar Evento  " + record[0].get('titulo'));
                            win.down('label[name=lblDescripcion]').setText("Indique la razón por la que desea cancelar el Evento" + record[0].get('titulo') + "?");
                            win.show();
                        }
                    }
                });
            }
            else {
                Ext.MessageBox.show({title: 'Informaci&oacute;n',
                    msg: "El Evento " + record[0].get('titulo') + " no lo puede cancelar, porque ha sido: " + record[0].get('estatus'),
                    buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
            }


        } else {
            Ext.MessageBox.show({title: 'Informaci&oacute;n',
                msg: 'Debe seleccionar el evento que desea Cancelar',
                buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
        }
    },
    onClickCerrarEvento: function (grid, record, rowIndex) {
        var grid = this.getListaEventos();
        store = grid.getStore();
        rec = store.getAt(rowIndex);
        if (rec.get('estatus') == 'En Ejecución') {
            Ext.Msg.show({
                title: 'Confirmar',
                msg: 'Esta seguro que desea Cerrar el Evento ' + rec.get('titulo') + '?',
                buttons: Ext.Msg.YESNO,
                icon: Ext.Msg.QUESTION,
                fn: function (buttonId) {
                    if (buttonId == 'yes') {

                        Ext.Ajax.request({//AQUI ENVIO LA DATA 
                            url: BASE_URL + 'evento/evento/cerrarEvento',
                            method: 'POST',
                            params: {
                                idEvento: rec.get('idEv'),
                            },
                            success: function (result, request) {
                                result = Ext.JSON.decode(result.responseText);
                                if (result.success) {
                                    grid.getView().refresh();
                                    grid.getStore().load();
                                    Ext.MessageBox.show({title: 'Alerta', msg: result.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                                }
                                else {
                                    Ext.MessageBox.show({title: 'Alerta', msg: result.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                                    // myapp.util.Util.showErrorMsg(result.msg);
                                }
                            },
                            failure: function (form, action) {
                                var result = action.result;
                                loadingMask.hide();
                                Ext.MessageBox.show({title: 'Alerta', msg: "Ha ocurrido un error. Por vuelva a intentarlo, si el problema persiste comuniquese con el administrador", buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                            }
                        });
                    }
                }
            });
        }
        else {
            console.log('Else' + rec.get('estatus'));
            Ext.MessageBox.show({title: 'Informaci&oacute;n',
                msg: "El Evento " + rec.get('titulo') + " no lo puede completar, porque ha sido " + rec.get('estatus'),
                buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.INFO});
        }
    },
    //==============Funciones de la ventana Evento=====================================

    onClickGuardarEvento: function (button, e, options) {
        formulario = this.getEvento();
        grid = this.getListaEventos();
        win = this.getWinEvento();
        if (nuevo) {
            var loadingMask = new Ext.LoadMask(Ext.getBody(), {msg: "grabando..."});
            loadingMask.show();
            Ext.Ajax.request({//AQUI ENVIO LA DATA 
                url: BASE_URL + 'evento/evento/registrarEvento',
                method: 'POST',
                params: {
                    txtTitulo: win.down('textfield[name=txtTitulo]').getValue(),
                    txtDescripcion: win.down('textfield[name=txtDescripcion]').getValue(),
                    txtPresupuesto: win.down('textfield[name=txtPresupuesto]').getValue(),
                    cmbAgente: win.down('combobox[name=cmbAgente]').getValue(),
                    cmbAlcance: win.down('combobox[name=cmbAlcance]').getValue(),
                    cmbSector: win.down('combobox[name=cmbSector]').getValue(),
                    cmbTipoEvento: win.down('combobox[name=cmbTipoEvento]').getValue(),
                    dtfFechaT: win.down('datefield[name=dtfFechaT]').getValue(),
                    dtfFechaPA: win.down('datefield[name=dtfFechaPA]').getValue(),
                },
                success: function (result, request) {
                    result = Ext.JSON.decode(result.responseText);
                    loadingMask.hide();
                    if (result.success) {
                        grid.getView().refresh();
                        grid.getStore().load();
                        Ext.MessageBox.show({title: 'Alerta', msg: result.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                        win.close();
                    }
                    else {
                        Ext.MessageBox.show({title: 'Alerta', msg: result.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                        // myapp.util.Util.showErrorMsg(result.msg);
                    }
                },
                failure: function (form, action) {
                    var result = action.result;
                    loadingMask.hide();
                    Ext.MessageBox.show({title: 'Alerta', msg: "Ha ocurrido un error. Por vuelva a intentarlo, si el problema persiste comuniquese con el administrador", buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                }
            });
        }
        else
        {
            record = grid.getSelectionModel().getSelection();
//Validaciones de los combos
            storeAct = win.down("combobox[name=cmbAgente]").getStore();
            valor = win.down("combobox[name=cmbAgente]").getValue();
            for (i = 0; i < storeAct.data.items.length; ++i) {

                if (storeAct.data.items[i].data['nombre'] == valor) {
                    cmbAgente = storeAct.data.items[i].data['id'];
                    i = storeAct.data.items.length + 1;
                } else {
                    if (storeAct.data.items[i].data['id'] == valor) {
                        cmbAgente = storeAct.data.items[i].data['id'];
                        i = storeAct.data.items.length + 1;
                    }
                }

            }

            storeTE = win.down("combobox[name=cmbTipoEvento]").getStore();
            valor4 = win.down("combobox[name=cmbTipoEvento]").getValue();

            for (j = 0; j < storeTE.data.items.length; ++j) {

                if (storeTE.data.items[j].data['nombre'] == valor4) {
                    cmbTipoEvento = storeTE.data.items[j].data['id'];
                    j = storeTE.data.items.length + 1;
                } else {
                    if (storeTE.data.items[j].data['id'] == valor4) {
                        cmbTipoEvento = storeTE.data.items[j].data['id'];
                        j = storeTE.data.items.length + 1;
                    }
                }

            }

            storeAl = win.down("combobox[name=cmbAlcance]").getStore();
            valor1 = win.down("combobox[name=cmbAlcance]").getValue();

            for (k = 0; k < storeAl.data.items.length; ++k) {

                if (storeAl.data.items[k].data['nombre'] == valor1) {
                    cmbAlcance = storeAl.data.items[k].data['id'];
                    k = storeAl.data.items.length + 1;
                } else {
                    if (storeAl.data.items[k].data['id'] == valor1) {
                        cmbAlcance = storeAl.data.items[k].data['id'];
                        k = storeAl.data.items.length + 1;
                    }
                }

            }
            storeS = win.down("combobox[name=cmbSector]").getStore();
            valor3 = win.down("combobox[name=cmbSector]").getValue();

            for (l = 0; l < storeS.data.items.length; ++l) {

                if (storeS.data.items[l].data['nombre'] == valor3) {
                    cmbSector = storeS.data.items[l].data['id'];
                    l = storeS.data.items.length + 1;
                } else {
                    if (storeS.data.items[l].data['id'] == valor3) {

                        cmbSector = storeS.data.items[l].data['id'];
                        l = storeS.data.items.length + 1;
                    }
                }

            }
//Validaciones de los combos

            Ext.Ajax.request({//AQUI ENVIO LA DATA 
                url: BASE_URL + 'evento/evento/actualizarEvento',
                method: 'POST',
                params: {
                    txtIdEvento: record[0].get('idEv'),
                    txtTitulo: win.down('textfield[name=txtTitulo]').getValue(),
                    txtDescripcion: win.down('textfield[name=txtDescripcion]').getValue(),
                    txtPresupuesto: win.down('textfield[name=txtPresupuesto]').getValue(),
                    cmbAgente: cmbAgente,
                    cmbAlcance: cmbAlcance,
                    cmbSector: cmbSector,
                    cmbTipoEvento: cmbTipoEvento,
                    dtfFechaT: win.down('datefield[name=dtfFechaT]').getValue(),
                    dtfFechaPA: win.down('datefield[name=dtfFechaPA]').getValue(),
                },
                success: function (result, request) {
                    result = Ext.JSON.decode(result.responseText);
                    if (result.success) {
                        grid.getView().refresh();
                        grid.getStore().load();
                        Ext.MessageBox.show({title: 'Alerta', msg: result.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                        win.close();
                    }
                    else {
                        Ext.MessageBox.show({title: 'Alerta', msg: result.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                    }
                },
                failure: function (form, action) {
                    var result = action.result;
                    Ext.MessageBox.show({title: 'Alerta', msg: "Ha ocurrido un error. Por vuelva a intentarlo, si el problema persiste comuniquese con el administrador", buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                }
            });
        }

    }, // fin de la function 

    //============================MAESTROS===============================================
    onClickNuevoAgente: function (button, e, options) {
        nuevoAg = true;
        var winAgente = Ext.create('myapp.view.maestroNombre.WinMaestroAgente');
        winAgente.setTitle("Nuevo  Agente");
        winAgente.show();
    },
    onClickNuevoAlcance: function (button, e, options) {
        nuevoAl = true;
        var winAlcance = Ext.create('myapp.view.maestroValor.WinMaestroAlcance');
        winAlcance.setTitle("Nuevo  Alcance");
        winAlcance.show();
    },
    onClickNuevoSector: function (button, e, options) {
        nuevoS = true;
        var winSector = Ext.create('myapp.view.maestroNombre.WinMaestroSector');
        winSector.setTitle("Nuevo  Sector");
        winSector.show();
    },
    onClickNuevoTipoEvento: function (button, e, options) {
        nuevoTE = true;
        var winTE = Ext.create('myapp.view.maestroValor.WinMaestroTipoEvento');
        winTE.setTitle("Nuevo  Tipo de Evento");
        winTE.show();
    },
    onClickEditarAgente: function (button, e, options) {
        nuevoAg = false;
        winE = this.getWinEvento();
        var winAgente = Ext.create('myapp.view.maestroNombre.WinMaestroAgente');
        winAgente.setTitle("Actualizar  Agente");
        storeS = winE.down("combobox[name=cmbAgente]").getStore();
        valor = winE.down("combobox[name=cmbAgente]").getValue();
        for (i = 0; i < storeS.data.items.length; ++i)
        {

            if (storeS.data.items[i].data['id'] == valor) {
                winAgente.down("textfield[name=nombre]").setValue(storeS.data.items[i].data['nombre']);
                i = storeS.data.items.length + 1;
            }
        }
        winAgente.show();
    },
    onClickEditarTipoEvento: function (button, e, options) {
        nuevoTE = false;
        winE = this.getWinEvento();
        var winTE = Ext.create('myapp.view.maestroValor.WinMaestroTipoEvento');
        winTE.setTitle("Actualizar  Tipo de Evento");
        storeS = winE.down("combobox[name=cmbTipoEvento]").getStore();
        valor = winE.down("combobox[name=cmbTipoEvento]").getValue();
        for (i = 0; i < storeS.data.items.length; ++i)
        {

            if (storeS.data.items[i].data['id'] == valor) {
                winTE.down("textfield[name=nombre]").setValue(storeS.data.items[i].data['nombre']);
                winTE.down("textfield[name=valor]").setValue(storeS.data.items[i].data['valor']);
                i = storeS.data.items.length + 1;
            }
        }
        winTE.show();
    },
    onClickEditarSector: function (button, e, options) {
        nuevoS = false;
        winE = this.getWinEvento();
        var winSector = Ext.create('myapp.view.maestroNombre.WinMaestroSector');
        winSector.setTitle("Actualizar  Sector");
        storeS = winE.down("combobox[name=cmbSector]").getStore();
        valor = winE.down("combobox[name=cmbSector]").getValue();
        for (i = 0; i < storeS.data.items.length; ++i)
        {

            if (storeS.data.items[i].data['id'] == valor) {
                winSector.down("textfield[name=nombre]").setValue(storeS.data.items[i].data['nombre']);
                i = storeS.data.items.length + 1;
            }
        }




        winSector.show();
    },
    onClickEditarAlcance: function (button, e, options) {
        nuevoAl = false;
        winE = this.getWinEvento();
        var winAlcance = Ext.create('myapp.view.maestroValor.WinMaestroAlcance');
        winAlcance.setTitle("Actualizar  Alcance");
        storeS = winE.down("combobox[name=cmbAlcance]").getStore();
        valor = winE.down("combobox[name=cmbAlcance]").getValue();
        for (i = 0; i < storeS.data.items.length; ++i)
        {

            if (storeS.data.items[i].data['id'] == valor) {
                winAlcance.down("textfield[name=nombre]").setValue(storeS.data.items[i].data['nombre']);
                winAlcance.down("textfield[name=valor]").setValue(storeS.data.items[i].data['valor']);
                i = storeS.data.items.length + 1;
            }
        }
        winAlcance.show();
    },
    //======================Funciones de la ventana Observaciones ====================0
    onClickGuardarObservacion: function (button, e, options) {

        grid = this.getListaEventos();
        winO = this.getWinObservacionEvento();
        var loadingMask = new Ext.LoadMask(Ext.getBody(), {msg: "grabando..."});
        loadingMask.show();
        record = grid.getSelectionModel().getSelection();
        Ext.Ajax.request({//AQUI ENVIO LA DATA 
            url: BASE_URL + 'evento/evento/cancelarEvento',
            method: 'POST',
            params: {
                observacion: winO.down("textfield[name=txtDescripcion]").getValue(),
                idEvento: record[0].get('idEv')
            },
            success: function (result, request) {
                result = Ext.JSON.decode(result.responseText);
                loadingMask.hide();
                if (result.success) {
                    grid.getView().refresh();
                    grid.getStore().load();
                    winO.close();
                    Ext.MessageBox.show({title: 'Alerta', msg: result.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                }
                else {
                    Ext.MessageBox.show({title: 'Alerta', msg: result.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                    // myapp.util.Util.showErrorMsg(result.msg);
                }
            },
            failure: function (form, action) {
                var result = action.result;
                loadingMask.hide();
                Ext.MessageBox.show({title: 'Alerta', msg: "Ha ocurrido un error. Por vuelva a intentarlo, si el problema persiste comuniquese con el administrador", buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
            }
        });
    },
    //==============================Maestros=======================================
    onClickGuardarAgente: function (button, e, options) {
        winE = this.getWinEvento();
        storeE = winE.down("combobox[name=cmbAgente]").getStore();
        winO = this.getWinMaestroAgente();
        var loadingMask = new Ext.LoadMask(Ext.getBody(), {msg: "grabando..."});
        loadingMask.show();
        if (nuevoAg) {
            Ext.Ajax.request({//AQUI ENVIO LA DATA 
                url: BASE_URL + 'agente/agente/registrarAgente',
                method: 'POST',
                params: {
                    txtNombre: winO.down("textfield[name=nombre]").getValue(),
                },
                success: function (result, request) {
                    result = Ext.JSON.decode(result.responseText);
                    loadingMask.hide();
                    if (result.success) {

                        storeE.load();
                        winO.close();
                        Ext.MessageBox.show({title: 'Alerta', msg: result.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                    }
                    else {
                        Ext.MessageBox.show({title: 'Alerta', msg: result.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                        // myapp.util.Util.showErrorMsg(result.msg);
                    }
                },
                failure: function (form, action) {
                    var result = action.result;
                    loadingMask.hide();
                    Ext.MessageBox.show({title: 'Alerta', msg: "Ha ocurrido un error. Por vuelva a intentarlo, si el problema persiste comuniquese con el administrador", buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                }
            });
        }
        else {

            Ext.Ajax.request({//AQUI ENVIO LA DATA 
                url: BASE_URL + 'agente/agente/actualizarAgente',
                method: 'POST',
                params: {
                    id: winE.down("combobox[name=cmbAgente]").getValue(),
                    txtNombre: winO.down("textfield[name=nombre]").getValue(),
                },
                success: function (result, request) {
                    result = Ext.JSON.decode(result.responseText);
                    loadingMask.hide();
                    if (result.success) {

                        storeE.load();
                        winO.close();
                        Ext.MessageBox.show({title: 'Alerta', msg: result.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                    }
                    else {
                        Ext.MessageBox.show({title: 'Alerta', msg: result.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                        // myapp.util.Util.showErrorMsg(result.msg);
                    }
                },
                failure: function (form, action) {
                    var result = action.result;
                    loadingMask.hide();
                    Ext.MessageBox.show({title: 'Alerta', msg: "Ha ocurrido un error. Por vuelva a intentarlo, si el problema persiste comuniquese con el administrador", buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                }
            });
        }



    },
    onClickGuardarSector: function (button, e, options) {
        winE = this.getWinEvento();
        storeE = winE.down("combobox[name=cmbSector]").getStore();
        winO = this.getWinMaestroSector();
        var loadingMask = new Ext.LoadMask(Ext.getBody(), {msg: "grabando..."});
        loadingMask.show();
        if (nuevoS) {
            Ext.Ajax.request({//AQUI ENVIO LA DATA 
                url: BASE_URL + 'sector/sector/registrarSector',
                method: 'POST',
                params: {
                    txtNombre: winO.down("textfield[name=nombre]").getValue(),
                },
                success: function (result, request) {
                    result = Ext.JSON.decode(result.responseText);
                    loadingMask.hide();
                    if (result.success) {

                        storeE.load();
                        winO.close();
                        Ext.MessageBox.show({title: 'Alerta', msg: result.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                    }
                    else {
                        Ext.MessageBox.show({title: 'Alerta', msg: result.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                        // myapp.util.Util.showErrorMsg(result.msg);
                    }
                },
                failure: function (form, action) {
                    var result = action.result;
                    loadingMask.hide();
                    Ext.MessageBox.show({title: 'Alerta', msg: "Ha ocurrido un error. Por vuelva a intentarlo, si el problema persiste comuniquese con el administrador", buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                }
            });
        }
        else {
            Ext.Ajax.request({//AQUI ENVIO LA DATA 
                url: BASE_URL + 'sector/sector/actualizarSector',
                method: 'POST',
                params: {
                    id: winE.down("combobox[name=cmbSector]").getValue(),
                    txtNombre: winO.down("textfield[name=nombre]").getValue(),
                },
                success: function (result, request) {
                    result = Ext.JSON.decode(result.responseText);
                    loadingMask.hide();
                    if (result.success) {

                        storeE.load();
                        winO.close();
                        Ext.MessageBox.show({title: 'Alerta', msg: result.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                    }
                    else {
                        Ext.MessageBox.show({title: 'Alerta', msg: result.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                        // myapp.util.Util.showErrorMsg(result.msg);
                    }
                },
                failure: function (form, action) {
                    var result = action.result;
                    loadingMask.hide();
                    Ext.MessageBox.show({title: 'Alerta', msg: "Ha ocurrido un error. Por vuelva a intentarlo, si el problema persiste comuniquese con el administrador", buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                }
            });
        }

    },
    onClickGuardarTipoEvento: function (button, e, options) {
        winE = this.getWinEvento();
        storeE = winE.down("combobox[name=cmbTipoEvento]").getStore();
        winO = this.getWinMaestroTipoEvento();
        var loadingMask = new Ext.LoadMask(Ext.getBody(), {msg: "grabando..."});
        loadingMask.show();
        if (nuevoTE) {
            Ext.Ajax.request({//AQUI ENVIO LA DATA 
                url: BASE_URL + 'tipoEvento/tipoEvento/registrarTipoEvento',
                method: 'POST',
                params: {
                    txtValor: winO.down("textfield[name=valor]").getValue(),
                    txtNombre: winO.down("textfield[name=nombre]").getValue(),
                },
                success: function (result, request) {
                    result = Ext.JSON.decode(result.responseText);
                    loadingMask.hide();
                    if (result.success) {

                        storeE.load();
                        winO.close();
                        Ext.MessageBox.show({title: 'Alerta', msg: result.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                    }
                    else {
                        Ext.MessageBox.show({title: 'Alerta', msg: result.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                        // myapp.util.Util.showErrorMsg(result.msg);
                    }
                },
                failure: function (form, action) {
                    var result = action.result;
                    loadingMask.hide();
                    Ext.MessageBox.show({title: 'Alerta', msg: "Ha ocurrido un error. Por vuelva a intentarlo, si el problema persiste comuniquese con el administrador", buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                }
            });
        }
        else {
            Ext.Ajax.request({//AQUI ENVIO LA DATA 
                url: BASE_URL + 'tipoEvento/tipoEvento/actualizarTipoEvento',
                method: 'POST',
                params: {
                    id: winE.down("combobox[name=cmbTipoEvento]").getValue(),
                    txtValor: winO.down("textfield[name=valor]").getValue(),
                    txtNombre: winO.down("textfield[name=nombre]").getValue(),
                },
                success: function (result, request) {
                    result = Ext.JSON.decode(result.responseText);
                    loadingMask.hide();
                    if (result.success) {

                        storeE.load();
                        winO.close();
                        Ext.MessageBox.show({title: 'Alerta', msg: result.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                    }
                    else {
                        Ext.MessageBox.show({title: 'Alerta', msg: result.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                        // myapp.util.Util.showErrorMsg(result.msg);
                    }
                },
                failure: function (form, action) {
                    var result = action.result;
                    loadingMask.hide();
                    Ext.MessageBox.show({title: 'Alerta', msg: "Ha ocurrido un error. Por vuelva a intentarlo, si el problema persiste comuniquese con el administrador", buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                }
            });
        }

    },
    onClickGuardarAlcance: function (button, e, options) {
        winE = this.getWinEvento();
        storeE = winE.down("combobox[name=cmbAlcance]").getStore();
        winO = this.getWinMaestroAlcance();
        var loadingMask = new Ext.LoadMask(Ext.getBody(), {msg: "grabando..."});
        loadingMask.show();
        if (nuevoAl) {
            Ext.Ajax.request({//AQUI ENVIO LA DATA 
                url: BASE_URL + 'alcance/alcance/registrarAlcance',
                method: 'POST',
                params: {
                    txtValor: winO.down("textfield[name=valor]").getValue(),
                    txtNombre: winO.down("textfield[name=nombre]").getValue(),
                },
                success: function (result, request) {
                    result = Ext.JSON.decode(result.responseText);
                    loadingMask.hide();
                    if (result.success) {

                        storeE.load();
                        winO.close();
                        Ext.MessageBox.show({title: 'Alerta', msg: result.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                    }
                    else {
                        Ext.MessageBox.show({title: 'Alerta', msg: result.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                        // myapp.util.Util.showErrorMsg(result.msg);
                    }
                },
                failure: function (form, action) {
                    var result = action.result;
                    loadingMask.hide();
                    Ext.MessageBox.show({title: 'Alerta', msg: "Ha ocurrido un error. Por vuelva a intentarlo, si el problema persiste comuniquese con el administrador", buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                }
            });
        }
        else {
            Ext.Ajax.request({//AQUI ENVIO LA DATA 
                url: BASE_URL + 'alcance/alcance/actualizarAlcance',
                method: 'POST',
                params: {
                    id: winE.down("combobox[name=cmbAlcance]").getValue(),
                    txtValor: winO.down("textfield[name=valor]").getValue(),
                    txtNombre: winO.down("textfield[name=nombre]").getValue(),
                },
                success: function (result, request) {
                    result = Ext.JSON.decode(result.responseText);
                    loadingMask.hide();
                    if (result.success) {

                        storeE.load();
                        winO.close();
                        Ext.MessageBox.show({title: 'Alerta', msg: result.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                    }
                    else {
                        Ext.MessageBox.show({title: 'Alerta', msg: result.msg, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                        // myapp.util.Util.showErrorMsg(result.msg);
                    }
                },
                failure: function (form, action) {
                    var result = action.result;
                    loadingMask.hide();
                    Ext.MessageBox.show({title: 'Alerta', msg: "Ha ocurrido un error. Por vuelva a intentarlo, si el problema persiste comuniquese con el administrador", buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING});
                }
            });
        }

    },
});